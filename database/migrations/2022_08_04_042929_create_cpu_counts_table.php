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
        Schema::create('cpu_counts', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('hostname_id');
            $table->string('hostname');
            $table->string('os')->nullable();
            $table->string('kernel_version')->nullable();
            $table->string('user_input')->nullable();
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
        Schema::dropIfExists('cpu_counts');
    }
};
