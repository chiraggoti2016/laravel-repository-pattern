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
            $table->string('slug', 25);
            $table->string('folder', 25)->nullable();
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->enum('status', ['pending', 'in progress', 'completed'])->default('pending');
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
