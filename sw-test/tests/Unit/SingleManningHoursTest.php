<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Rota\Rota;
use App\SingleManning\SingleManningHours;
use Illuminate\Support\Collection;

class SingleManningHoursTest extends TestCase
{
    private Rota $rota;
    private SingleManningHours $singleManningHours;
    private Collection $rotaInfo;
    private array $manningInfo;
    protected function setUp(): void
    {
        parent::setUp();

        $this->rota = new Rota();
        $this->singleManningHours = new SingleManningHours();
        $this->rotaInfo = $this->rota->createRota();
        $this->manningInfo = $this->singleManningHours->calculateSingleMinutes();
    }


    public function test_it_generate_manning_minutes_for_each_day_separately()
    {
        $expectedCaseCount = 5;
        $casesRecievedByManning = sizeof($this->manningInfo);
        $this->assertEquals($expectedCaseCount, $casesRecievedByManning);
    }

    public function test_it_calculate_single_manning_if_one_shift_in_a_day()
    {
        $shifts = collect(array([

                "id" => 1,
                "rota_id" => 2,
                "staff_id" => 1,
                "start_time" => "2022-09-19 08:00:00",
                "end_time" => "2022-09-19 20:00:00",
                "created_at" => "2022-09-28T06:17:08.000000Z",
                "updated_at" => "2022-09-28T06:17:08.000000Z"

        ]));


        $actualResult = $this->singleManningHours->getDailySingleMannings(
            $shifts,
            '2022-09-19',
            $this->rotaInfo->get('breaks'),
            1
        );

        $size = 0;
        $breaks = $this->rotaInfo->get('breaks');

        foreach ($breaks as $break) {
            $dailyBreaks = collect($break)->where('start_time', '>=', '2022-09-19 00:00:00')
                ->where('start_time', '<=', '2022-09-19 23:59:59');
            if (sizeof($dailyBreaks) > 0) {
                $size++;
            }
        }

        if (count($shifts) == 1 && $size == 0) {
            $to_time = strtotime($shifts[0]['end_time']);
            $from_time = strtotime($shifts[0]['start_time']);
            $expectedResult= round(abs($to_time - $from_time) / 60, 2);
        }
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_it_calculate_overlaping_minutes(): void
    {
        $shifts = collect(array(

           3 => ["id" => 4,
                "rota_id" => 2,
                "staff_id" => 3,
                "start_time" => "2022-09-21 07:00:00",
                "end_time" => "2022-09-21 13:00:00",
                "created_at" => "2022-09-28T06:17:08.000000Z",
                "updated_at" => "2022-09-28T06:17:08.000000Z",
        ],
        4 => [
            "id" => 5,
            "rota_id" => 2,
            "staff_id" => 4,
            "start_time" => "2022-09-21 09:00:00",
            "end_time" => "2022-09-21 21:00:00",
            "created_at" => "2022-09-28T06:17:08.000000Z",
            "updated_at" => "2022-09-28T06:17:08.000000Z"
         ,
        ]
    ));

        $actualResult = $this->singleManningHours->calculateOverlapMinutes($shifts, 3);

        $lastStart = $shifts[3]['start_time'] >= $shifts[4]['start_time'] ? $shifts[3]['start_time'] : $shifts[4]['start_time'];
        $lastStart = strtotime($lastStart);

        $firstEnd = $shifts[3]['end_time'] <= $shifts[4]['end_time'] ? $shifts[3]['end_time'] : $shifts[4]['end_time'];
        $firstEnd = strtotime($firstEnd);

        $overlap = floor(($firstEnd - $lastStart) / 60);

        $expectedResult =  $overlap > 0 ? $overlap : 0;

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_it_can_return_zero_if_no_body_work_alone(): void
    {
        $shifts = collect(array(

            7 => ["id" => 8,
                 "rota_id" => 2,
                 "staff_id" => 3,
                 "start_time" => "2022-09-23 08:00:00",
                 "end_time" => "2022-09-23 13:00:00",
                 "created_at" => "2022-09-28T06:17:08.000000Z",
                 "updated_at" => "2022-09-28T06:17:08.000000Z",
         ],
         8 => [
             "id" => 9,
             "rota_id" => 2,
             "staff_id" => 4,
             "start_time" => "2022-09-23 13:00:00",
             "end_time" => "2022-09-23 20:00:00",
             "created_at" => "2022-09-28T06:17:08.000000Z",
             "updated_at" => "2022-09-28T06:17:08.000000Z"
          ,
         ],
         9 => [
            "id" => 10,
            "rota_id" => 2,
            "staff_id" => 1,
            "start_time" => "2022-09-23 08:00:00",
            "end_time" => "2022-09-23 20:00:00",
            "created_at" => "2022-09-28T06:17:08.000000Z",
            "updated_at" => "2022-09-28T06:17:08.000000Z"
         ,
         ],
     ));

        $actualResult = $this->singleManningHours->getDailySingleMannings(
            $shifts,
            '2022-09-23',
            $this->rotaInfo->get('breaks'),
            5
        );
        $this->assertEquals(0, $actualResult);

    }
}
