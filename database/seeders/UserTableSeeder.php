<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                'first_name' => 'Optima',
                'last_name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin@123'), // password 
                'role'  => 'admin',
            ]);
    }
}
