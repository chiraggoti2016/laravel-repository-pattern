<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        // DB::table('users')->truncate();
        User::updateOrCreate([
            'email' => 'admin@admin.com',
            'role'  => 'admin',
        ],[
                'first_name' => 'Optima',
                'last_name' => 'Admin',
                'password' => \Hash::make('admin@123'), // password 
                'email_verified_at' => date('Y-m-d'),
        ]);
    }
}
