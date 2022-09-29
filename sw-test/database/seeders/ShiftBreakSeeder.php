<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rota;
use App\Models\Shop;
use App\Models\Staff;
use App\Models\ShiftBreak;

class ShiftBreakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shiftBreaks = [
            [
                'start_time' => '2022-09-22 11:00:00',
                'end_time' => '2022-09-22 12:00:00',
                'shift_id' => 6,
            ],
            [
                'start_time' => '2022-09-22 04:00:00',
                'end_time' => '2022-09-22 05:00:00',
                'shift_id' => 7,

            ],
        ];

        foreach ($shiftBreaks as $shiftBreak) {
            ShiftBreak::create($shiftBreak);
        }
    }
}
