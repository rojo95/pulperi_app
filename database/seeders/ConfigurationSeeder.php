<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = [
            [
                'description' => 'Cambio de Moneda Definido por el Usuario',
                'status' => false
            ],
            [
                'description' => 'Limitar Deuda',
                'status' => false
            ],
        ];

        foreach ($config as $value) {
            Configuration::create($value);
        }
    }
}
