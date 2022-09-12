<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use DB;

class ScopeStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('scope_stages')->truncate();

        // Oracle Database
        $scopes = [
            array('name' => 'Pre-Engagement Questionaire', 'scope' => 'oracle_database'),
            array('name' => 'Data Collection', 'scope' => 'oracle_database'),
            array('name' => 'Data Review', 'scope' => 'oracle_database'),
            array('name' => 'Right Sizing', 'scope' => 'oracle_database'),
            array('name' => 'Right Costing', 'scope' => 'oracle_database'),
            array('name' => 'TCO Calculation', 'scope' => 'oracle_database'),
            array('name' => 'Report Preparation', 'scope' => 'oracle_database'),
            array('name' => 'Report Presentation - Draft', 'scope' => 'oracle_database'),
            array('name' => 'Report Review', 'scope' => 'oracle_database'),
            array('name' => 'Report Presentation - Final', 'scope' => 'oracle_database'),
            array('name' => 'Final Submission & Sign-off', 'scope' => 'oracle_database'),
    	];
    	DB::table('scope_stages')->insert($scopes);

        // Oracle Apps
        $scopes = [
            array('name' => 'Pre-Engagement Questionaire', 'scope' => 'oracle_apps'),
            array('name' => 'Data Collection', 'scope' => 'oracle_apps'),
            array('name' => 'Data Review', 'scope' => 'oracle_apps'),
            array('name' => 'Right Sizing', 'scope' => 'oracle_apps'),
            array('name' => 'Right Costing', 'scope' => 'oracle_apps'),
            array('name' => 'TCO Calculation', 'scope' => 'oracle_apps'),
            array('name' => 'Report Preparation', 'scope' => 'oracle_apps'),
            array('name' => 'Report Presentation - Draft', 'scope' => 'oracle_apps'),
            array('name' => 'Report Review', 'scope' => 'oracle_apps'),
            array('name' => 'Report Presentation - Final', 'scope' => 'oracle_apps'),
            array('name' => 'Final Submission & Sign-off', 'scope' => 'oracle_apps'),
    	];
    	DB::table('scope_stages')->insert($scopes);


        // Microsoft
        $scopes = [
            array('name' => 'Pre-Engagement Questionaire', 'scope' => 'microsoft'),
            array('name' => 'Data Collection', 'scope' => 'microsoft'),
            array('name' => 'Data Review', 'scope' => 'microsoft'),
            array('name' => 'Right Sizing', 'scope' => 'microsoft'),
            array('name' => 'Right Costing', 'scope' => 'microsoft'),
            array('name' => 'TCO Calculation', 'scope' => 'microsoft'),
            array('name' => 'Report Preparation', 'scope' => 'microsoft'),
            array('name' => 'Report Presentation - Draft', 'scope' => 'microsoft'),
            array('name' => 'Report Review', 'scope' => 'microsoft'),
            array('name' => 'Report Presentation - Final', 'scope' => 'microsoft'),
            array('name' => 'Final Submission & Sign-off', 'scope' => 'microsoft'),
        ];
    	DB::table('scope_stages')->insert($scopes);


        // Vmware
        $scopes = [
            array('name' => 'Pre-Engagement Questionaire', 'scope' => 'vmware'),
            array('name' => 'Data Collection', 'scope' => 'vmware'),
            array('name' => 'Data Review', 'scope' => 'vmware'),
            array('name' => 'Right Sizing', 'scope' => 'vmware'),
            array('name' => 'Right Costing', 'scope' => 'vmware'),
            array('name' => 'TCO Calculation', 'scope' => 'vmware'),
            array('name' => 'Report Preparation', 'scope' => 'vmware'),
            array('name' => 'Report Presentation - Draft', 'scope' => 'vmware'),
            array('name' => 'Report Review', 'scope' => 'vmware'),
            array('name' => 'Report Presentation - Final', 'scope' => 'vmware'),
            array('name' => 'Final Submission & Sign-off', 'scope' => 'vmware'),
        ];
    	DB::table('scope_stages')->insert($scopes);


        // Sap
        $scopes = [
            array('name' => 'Pre-Engagement Questionaire', 'scope' => 'sap'),
            array('name' => 'Data Collection', 'scope' => 'sap'),
            array('name' => 'Data Review', 'scope' => 'sap'),
            array('name' => 'Right Sizing', 'scope' => 'sap'),
            array('name' => 'Right Costing', 'scope' => 'sap'),
            array('name' => 'TCO Calculation', 'scope' => 'sap'),
            array('name' => 'Report Preparation', 'scope' => 'sap'),
            array('name' => 'Report Presentation - Draft', 'scope' => 'sap'),
            array('name' => 'Report Review', 'scope' => 'sap'),
            array('name' => 'Report Presentation - Final', 'scope' => 'sap'),
            array('name' => 'Final Submission & Sign-off', 'scope' => 'sap'),
        ];
    	DB::table('scope_stages')->insert($scopes);

        Schema::enableForeignKeyConstraints();
    }
}
