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
        Schema::create('cpu_count_memory_details', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('hostname_id');
            $table->integer('cpu_count_id');
            $table->enum('memory_type', ['Mem', 'Swap'])->default('Mem');
            $table->integer('total')->nullable();
            $table->integer('used')->nullable();
            $table->integer('free')->nullable();
            $table->integer('shared')->nullable();
            $table->integer('buffers')->nullable();
            $table->integer('cached')->nullable();
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
        Schema::dropIfExists('cpu_count_memory_details');
    }
};
