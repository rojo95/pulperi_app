<?php

namespace Database\Seeders;

use App\Models\Divisas;
use Illuminate\Database\Seeder;

class DivisasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $divisas = [
            'Bolívares',
            'Dólares',
        ];

        foreach ($divisas as $divisa) {
            Divisas::create([
                'name' => $divisa
            ]);
        }
    }
}
