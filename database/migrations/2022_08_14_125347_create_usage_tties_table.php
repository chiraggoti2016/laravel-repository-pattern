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
        Schema::create('usage_tties', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->string('hostname');
            $table->string('tty')->nullable();
            $table->double('rcvin_s', 12, 2)->nullable();
            $table->double('xmtin_s', 12, 2)->nullable();
            $table->double('framerr_s', 12, 2)->nullable();
            $table->double('prtyerr_s', 12, 2)->nullable();
            $table->double('brk_s', 12, 2)->nullable();
            $table->double('ovrun_s', 12, 2)->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('usage_tties');
    }
};
