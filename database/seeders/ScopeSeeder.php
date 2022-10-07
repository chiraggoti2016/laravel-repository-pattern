<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use DB;

class ScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        DB::table('scopes')->truncate();

        $scopes = [
    		array('id' => '1','name' => 'Oracle Database', 'slug' => 'oracle_database'),
    		array('id' => '2','name' => 'Oracle Apps', 'slug' => 'oracle_apps'),
    		array('id' => '3','name' => 'Microsoft', 'slug' => 'microsoft'),
    		array('id' => '4','name' => 'VMware', 'slug' => 'vmware'),
    		array('id' => '5','name' => 'SAP', 'slug' => 'sap'),
    	];
    	DB::table('scopes')->insert($scopes);

        Schema::enableForeignKeyConstraints();
    }
}
