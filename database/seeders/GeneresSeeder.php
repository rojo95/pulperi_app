<?php

namespace Database\Seeders;

use App\Models\Genere;
use Illuminate\Database\Seeder;

class GeneresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generes = [
            'Masculino',
            'Femenino',
        ];

        foreach ($generes as $genere) {
            Genere::create([
                'description' => $genere
            ]);
        }
    }
}
