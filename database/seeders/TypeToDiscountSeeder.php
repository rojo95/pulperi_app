<?php

namespace Database\Seeders;

use App\Models\TypeToDiscount;
use Illuminate\Database\Seeder;

class TypeToDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = [
            'Venta del producto.',
            'Vencimiento del producto.',
            'Motivado por razones externas.',
            'Retirado por un trabajador.',
        ];

        foreach ($types as $type) {
            TypeToDiscount::create([
                'description' => $type
            ]);
        }

    }
}
