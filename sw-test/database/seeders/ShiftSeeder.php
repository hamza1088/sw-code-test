<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rota;
use App\Models\Shop;
use App\Models\Staff;
use App\Models\Shift;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shifts = [
            [
                'start_time' => '2022-09-19 08:00:00',
                'end_time' => '2022-09-19 20:00:00',
                'staff_id' => 1,
                'rota_id' => 2
            ],
            [
                'start_time' => '2022-09-20 08:00:00',
                'end_time' => '2022-09-20 13:00:00',
                'staff_id' => 1,
                'rota_id' => 2
            ], [
                'start_time' => '2022-09-20 13:00:00',
                'end_time' => '2022-09-20 20:00:00',
                'staff_id' => 2,
                'rota_id' => 2
            ],
            [
                'start_time' => '2022-09-21 08:00:00',
                'end_time' => '2022-09-21 13:00:00',
                'staff_id' => 3,
                'rota_id' => 2
            ],
            [
                'start_time' => '2022-09-21 09:00:00',
                'end_time' => '2022-09-21 20:00:00',
                'staff_id' => 4,
                'rota_id' => 2
            ],
            [
                'start_time' => '2022-09-22 08:00:00',
                'end_time' => '2022-09-22 20:00:00',
                'staff_id' => 3,
                'rota_id' => 2
            ],
            [
                'start_time' => '2022-09-22 08:00:00',
                'end_time' => '2022-09-22 20:00:00',
                'staff_id' => 4,
                'rota_id' => 2
            ],
            [
                'start_time' => '2022-09-23 08:00:00',
                'end_time' => '2022-09-23 13:00:00',
                'staff_id' => 3,
                'rota_id' => 2
            ],
            [
                'start_time' => '2022-09-23 13:00:00',
                'end_time' => '2022-09-23 20:00:00',
                'staff_id' => 4,
                'rota_id' => 2
            ],
            [
                'start_time' => '2022-09-23 08:00:00',
                'end_time' => '2022-09-23 20:00:00',
                'staff_id' => 1,
                'rota_id' => 2
            ],
        ];

        foreach ($shifts as $shift) {
            Shift::create($shift);
        }
    }
}
