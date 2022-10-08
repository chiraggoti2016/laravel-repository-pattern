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
            $table->dropColumn(['startdate', 'enddate']);
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
            $table->text('startdate')->nullable();
            $table->text('enddate')->nullable();
        });
    }
}
