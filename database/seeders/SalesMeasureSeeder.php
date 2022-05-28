<?php

namespace Database\Seeders;

use App\Models\sales_measures;
use Illuminate\Database\Seeder;

class SalesMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Unidades',
            'Kilogramos',
        ];

        foreach ($types as $type) {
            sales_measures::create([
                'description' => $type
            ]);
        }
    }
}
