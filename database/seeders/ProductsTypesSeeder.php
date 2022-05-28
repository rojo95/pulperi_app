<?php

namespace Database\Seeders;

use App\Models\ProductsType;
use Illuminate\Database\Seeder;

class ProductsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tProds = [
            'Limpieza',
            'Comestible',
            'Medicina',
            'Higiene Personal',
        ];

        foreach ($tProds as $tProd) {
            ProductsType::create([
                'name' => $tProd
            ]);
        }
    }
}
