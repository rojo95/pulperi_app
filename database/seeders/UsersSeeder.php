<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'admin',
            'email' => 'no_reply@gmail.com',
            'password' => bcrypt('123456789', ['rounds' => 12]),
        ]);

        $user->assignRole('Admin');
    }
}
