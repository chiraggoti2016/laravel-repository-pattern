<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpu_count_database_details', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('hostname_id');
            $table->integer('cpu_count_id');
            $table->string('user')->nullable();
            $table->string('db_name')->nullable();
            $table->string('db_type')->nullable();
            $table->string('instance_name')->nullable();
            $table->string('database_name')->nullable();
            $table->string('open_mode')->nullable();
            $table->string('db_role')->nullable();
            $table->string('dbid')->nullable();
            $table->string('version')->nullable();
            $table->string('banner')->nullable();
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
        Schema::dropIfExists('cpu_count_database_details');
    }
};
