<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Profile::create([
            'name' => 'Administrador',
            'lastname' => 'Admin',
            'identification' => '00000000',
            'genere_id' => 1,
            'user_id' => 1,
        ]);

    }
}
