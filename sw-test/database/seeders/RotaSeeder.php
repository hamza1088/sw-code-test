<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rota;
use App\Models\Shop;

class RotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shop = Shop::create(['name' => 'FunHouse',]);
        $rotas = [
            [
                'shop_id' => $shop->id,
                'week_commence_date' => '2022-09-12',
            ],
            [
                'shop_id' => $shop->id,
                'week_commence_date' => '2022-09-19',
            ],
        ];

        foreach ($rotas as $rota) {
            Rota::create($rota);
        }
    }
}
