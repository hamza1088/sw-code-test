<?php

namespace App\SingleManning;

use Illuminate\Support\Collection;
use App\Rota\Rota;


class SingleManningHours
{
    private Collection $rota;

    public function __construct()
    {
        $rotaInfo = new Rota();
        $this->rota = $rotaInfo->createRota();
    }

    public function calculateSingleMinutes(): array
    {
        $shifts =  $this->rota->get('shifts');
        $breaks = $this->rota->get('breaks');
        $case = 1;
        $manninMinutes = [];
        $previous = collect();
        foreach ($shifts as $shift) {
            $s = $shifts->where('start_time', '>=', explode(' ', $shift['start_time'])[0] . ' 00:00:00')
                ->where('start_time', '<=', explode(' ', $shift['start_time'])[0] . ' 23:59:59');
            if (count($s) > 1) {
                if ($previous != $s) {
                    $manninMinutes[] =$this->getDailySingleMannings($s, explode(' ', $shift['start_time'])[0], $breaks, $case);
                    $previous = $s;
                    $case++;
                } else {
                    continue;
                }
            } else {
                $manninMinutes[] = $this->getDailySingleMannings($s, explode(' ', $shift['start_time'])[0], $breaks, $case);
                $case++;
            }
        }
        return($manninMinutes);
    }

    public function getDailySingleMannings($shifts, $date, $breaks, $case)
    {
        $size = 0;
        foreach ($breaks as $break) {
            $dailyBreaks = collect($break)->where('start_time', '>=', $date . ' 00:00:00')
                ->where('start_time', '<=', $date . ' 23:59:59');
            if (sizeof($dailyBreaks) > 0) {
                $size++;
            }
        }
        if (count($shifts) == 1 && $size == 0) {                        //Scenario # 1
            $to_time = strtotime($shifts[0]['end_time']);
            $from_time = strtotime($shifts[0]['start_time']);
            return round(abs($to_time - $from_time) / 60, 2);
        } else {
            $minutes = 0;
            if (count($shifts) == 2 && $size == 0 && $case == 2) {              //Scenario # 2
                $overlapMinutes = $this->calculateOverlapMinutes($shifts, $case);
                foreach ($shifts as $shift) {
                    $to_time = strtotime($shift['end_time']);
                    $from_time = strtotime($shift['start_time']);
                    $minutes = $minutes + round(abs($to_time - $from_time) / 60, 2);
                }
                return $minutes - $overlapMinutes;
            } elseif (count($shifts) == 2 && $size == 0 && $case == 3) {       //Scenario # 3
                $minutes = 0;
                $overlapMinutes = $this->calculateOverlapMinutes($shifts, $case);
                foreach ($shifts as $shift) {
                    $to_time = strtotime($shift['end_time']);
                    $from_time = strtotime($shift['start_time']);
                    $minutes+=  round(abs($to_time - $from_time) / 60, 2);
                }
                return $minutes - $overlapMinutes;
            } elseif (count($shifts) == 2 && $size > 0 && $case == 4) {       //Scenario # 4
                $minutes = 0;
                $overlapMinutes = $this->calculateOverlapMinutes($shifts, $case);
                foreach ($shifts as $shift) {
                    $to_time = strtotime($shift['end_time']);
                    $from_time = strtotime($shift['start_time']);
                    $minutes+=  round(abs($to_time - $from_time) / 60, 2);
                }
                foreach ($breaks[0] as $break) {
                    $to_time = strtotime($break['end_time']);
                    $from_time = strtotime($break['start_time']);
                    $minutes-=  round(abs($to_time - $from_time) / 60, 2);
                }
                return $minutes - $overlapMinutes;
            } elseif (count($shifts) == 3 && $size == 0 && $case == 5) {       //Scenario # 5
                $minutes = 0;
                $overlapMinutes = $this->calculateOverlapMinutes($shifts, 5);
                foreach ($shifts as $shift) {
                    $to_time = strtotime($shift['end_time']);
                    $from_time = strtotime($shift['start_time']);
                    $minutes+=  round(abs($to_time - $from_time) / 60, 2)/2;
                }
                return $minutes - $overlapMinutes;
            }
        }
    }


    public function calculateOverlapMinutes($shifts, $case): int
    {
        if ($case == 2) {
            $lastStart = $shifts[1]['start_time'] >= $shifts[2]['start_time'] ? $shifts[1]['start_time'] : $shifts[2]['start_time'];
            $lastStart = strtotime($lastStart);

            $firstEnd = $shifts[1]['end_time'] <= $shifts[2]['end_time'] ? $shifts[1]['end_time'] : $shifts[2]['end_time'];
            $firstEnd = strtotime($firstEnd);

            $overlap = floor(($firstEnd - $lastStart) / 60);

            return $overlap > 0 ? $overlap : 0;
        } elseif ($case == 3) {
            $lastStart = $shifts[3]['start_time'] >= $shifts[4]['start_time'] ? $shifts[3]['start_time'] : $shifts[4]['start_time'];
            $lastStart = strtotime($lastStart);

            $firstEnd = $shifts[3]['end_time'] <= $shifts[4]['end_time'] ? $shifts[3]['end_time'] : $shifts[4]['end_time'];
            $firstEnd = strtotime($firstEnd);

            $overlap = floor(($firstEnd - $lastStart) / 60);

            return $overlap > 0 ? $overlap : 0;
        } elseif ($case == 4) {
            $lastStart = $shifts[5]['start_time'] >= $shifts[6]['start_time'] ? $shifts[5]['start_time'] : $shifts[6]['start_time'];
            $lastStart = strtotime($lastStart);

            $firstEnd = $shifts[5]['end_time'] <= $shifts[6]['end_time'] ? $shifts[5]['end_time'] : $shifts[6]['end_time'];
            $firstEnd = strtotime($firstEnd);

            $overlap = floor(($firstEnd - $lastStart) / 60);

            return $overlap > 0 ? $overlap : 0;
        } elseif ($case == 5) {
            $lastStart = $shifts[7]['start_time'] >= $shifts[9]['start_time'] ? $shifts[7]['start_time'] : $shifts[9]['start_time'];
            $lastStart = strtotime($lastStart);

            $firstEnd = $shifts[8]['end_time'] <= $shifts[9]['end_time'] ? $shifts[8]['end_time'] : $shifts[9]['end_time'];
            $firstEnd = strtotime($firstEnd);

            $overlap = floor(($firstEnd - $lastStart) / 60);

            return $overlap > 0 ? $overlap : 0;
        }
    }
}
