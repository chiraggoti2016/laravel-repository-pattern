<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use DB;

class QuestionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        DB::table('question_categories')->truncate();

        $question_categories = [
    		array('id' => '1','category' => 'General', 'slug' => 'general'),
    		array('id' => '2','category' => 'License Entitlement', 'slug' => 'license_entitlement'),
    		array('id' => '3','category' => 'Oracle Products', 'slug' => 'oracle_products'),
    	];
    	DB::table('question_categories')->insert($question_categories);

        Schema::enableForeignKeyConstraints();
    }
}
