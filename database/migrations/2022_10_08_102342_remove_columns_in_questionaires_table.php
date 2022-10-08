<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsInQuestionairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionaires', function (Blueprint $table) {
            $table->dropColumn(['status','startdate', 'enddate']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('questionaires', function (Blueprint $table) {
            $table->enum('status', ['init', 'draft', 'send', 'completed'])->default('init');
            $table->text('startdate')->nullable();
            $table->text('enddate')->nullable();
        });
    }
}
