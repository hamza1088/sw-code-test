<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rota;
use App\Models\Shop;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$shop = Staff::create(['name' => 'FunHouse',]);
        $staffs = [
            [
                'first_name' => 'Black',
                'surname' => 'Widow',
                'shop_id' => 1
            ],
            [
                'first_name' => 'Thor',
                'surname' => 'Anderson',
                'shop_id' => 1
            ],
            [
                'first_name' => 'Wolverine',
                'surname' => 'Doe',
                'shop_id' => 1
            ],
            [
                'first_name' => 'Gamora',
                'surname' => 'Lee',
                'shop_id' => 1
            ],
            
        ];

        foreach ($staffs as $staff) {
            Staff::create($staff);
        }
    }
}
