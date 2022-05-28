<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metodos = [
            'Divisas',
            'Efectivo',
            'Pago Móvil',
            'Transferencia',
            'Débito'
        ];


        foreach ($metodos as $v) {
            PaymentMethod::create([
                'description' => $v,
            ]);
        }

    }
}
