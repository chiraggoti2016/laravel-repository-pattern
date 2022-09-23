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
        Schema::create('cpu_count_storage_details', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('hostname_id');
            $table->integer('cpu_count_id');
            $table->string('file_system');
            $table->string('size')->nullable();
            $table->string('used')->nullable();
            $table->string('avail')->nullable();
            $table->string('use_percentage')->nullable();
            $table->string('mounted_on')->nullable();
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
        Schema::dropIfExists('cpu_count_storage_details');
    }
};
