<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
            $table->date('startdate');
            $table->date('enddate');
            $table->enum('status', ['pending', 'on-going', 'completed'])->default('pending');
            $table->enum('scope', ['oracle_database', 'oracle_apps', 'microsoft', 'vmware', 'sap'])->default('oracle_database');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
