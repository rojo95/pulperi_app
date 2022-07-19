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
            ['name'=>'Bolívares','exchange'=>5.5],
            ['name'=>'Dólares','exchange'=>1],
        ];

        foreach ($divisas as $divisa) {
            Divisas::create([
                'name' => $divisa['name'],
                'exchange' => $divisa['exchange'],
            ]);
        }
    }
}
