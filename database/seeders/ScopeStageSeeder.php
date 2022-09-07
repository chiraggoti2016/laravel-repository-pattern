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
    		array('name' => 'Oracle Database', 'scope_id' => 1),
            array('name' => 'Pre-Engagement Questionaire', 'scope_id' => 1),
            array('name' => 'Data Collection', 'scope_id' => 1),
            array('name' => 'Data Review', 'scope_id' => 1),
            array('name' => 'Right Sizing', 'scope_id' => 1),
            array('name' => 'Right Costing', 'scope_id' => 1),
            array('name' => 'TCO Calculation', 'scope_id' => 1),
            array('name' => 'Report Preparation', 'scope_id' => 1),
            array('name' => 'Report Presentation - Draft', 'scope_id' => 1),
            array('name' => 'Report Review', 'scope_id' => 1),
            array('name' => 'Report Presentation - Final', 'scope_id' => 1),
            array('name' => 'Final Submission & Sign-off', 'scope_id' => 1),
    	];
    	DB::table('scope_stages')->insert($scopes);

        // Oracle Apps
        $scopes = [
    		array('name' => 'Oracle Apps', 'scope_id' => 2),
            array('name' => 'Pre-Engagement Questionaire', 'scope_id' => 2),
            array('name' => 'Data Collection', 'scope_id' => 2),
            array('name' => 'Data Review', 'scope_id' => 2),
            array('name' => 'Right Sizing', 'scope_id' => 2),
            array('name' => 'Right Costing', 'scope_id' => 2),
            array('name' => 'TCO Calculation', 'scope_id' => 2),
            array('name' => 'Report Preparation', 'scope_id' => 2),
            array('name' => 'Report Presentation - Draft', 'scope_id' => 2),
            array('name' => 'Report Review', 'scope_id' => 2),
            array('name' => 'Report Presentation - Final', 'scope_id' => 2),
            array('name' => 'Final Submission & Sign-off', 'scope_id' => 2),
    	];
    	DB::table('scope_stages')->insert($scopes);


        // Microsoft
        $scopes = [
            array('name' => 'Microsoft', 'scope_id' => 3),
            array('name' => 'Pre-Engagement Questionaire', 'scope_id' => 3),
            array('name' => 'Data Collection', 'scope_id' => 3),
            array('name' => 'Data Review', 'scope_id' => 3),
            array('name' => 'Right Sizing', 'scope_id' => 3),
            array('name' => 'Right Costing', 'scope_id' => 3),
            array('name' => 'TCO Calculation', 'scope_id' => 3),
            array('name' => 'Report Preparation', 'scope_id' => 3),
            array('name' => 'Report Presentation - Draft', 'scope_id' => 3),
            array('name' => 'Report Review', 'scope_id' => 3),
            array('name' => 'Report Presentation - Final', 'scope_id' => 3),
            array('name' => 'Final Submission & Sign-off', 'scope_id' => 3),
        ];
    	DB::table('scope_stages')->insert($scopes);


        // Vmware
        $scopes = [
            array('name' => 'Vmware', 'scope_id' => 4),
            array('name' => 'Pre-Engagement Questionaire', 'scope_id' => 4),
            array('name' => 'Data Collection', 'scope_id' => 4),
            array('name' => 'Data Review', 'scope_id' => 4),
            array('name' => 'Right Sizing', 'scope_id' => 4),
            array('name' => 'Right Costing', 'scope_id' => 4),
            array('name' => 'TCO Calculation', 'scope_id' => 4),
            array('name' => 'Report Preparation', 'scope_id' => 4),
            array('name' => 'Report Presentation - Draft', 'scope_id' => 4),
            array('name' => 'Report Review', 'scope_id' => 4),
            array('name' => 'Report Presentation - Final', 'scope_id' => 4),
            array('name' => 'Final Submission & Sign-off', 'scope_id' => 4),
        ];
    	DB::table('scope_stages')->insert($scopes);


        // Sap
        $scopes = [
            array('name' => 'Sap', 'scope_id' => 5),
            array('name' => 'Pre-Engagement Questionaire', 'scope_id' => 5),
            array('name' => 'Data Collection', 'scope_id' => 5),
            array('name' => 'Data Review', 'scope_id' => 5),
            array('name' => 'Right Sizing', 'scope_id' => 5),
            array('name' => 'Right Costing', 'scope_id' => 5),
            array('name' => 'TCO Calculation', 'scope_id' => 5),
            array('name' => 'Report Preparation', 'scope_id' => 5),
            array('name' => 'Report Presentation - Draft', 'scope_id' => 5),
            array('name' => 'Report Review', 'scope_id' => 5),
            array('name' => 'Report Presentation - Final', 'scope_id' => 5),
            array('name' => 'Final Submission & Sign-off', 'scope_id' => 5),
        ];
    	DB::table('scope_stages')->insert($scopes);

        Schema::enableForeignKeyConstraints();
    }
}
