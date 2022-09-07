<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(ScopeSeeder::class);
        $this->call(ScopeStageSeeder::class);
        $this->call(CountrySeeder::class);
    }
}
