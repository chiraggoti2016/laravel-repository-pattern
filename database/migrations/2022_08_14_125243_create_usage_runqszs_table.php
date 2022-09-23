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
        Schema::create('usage_runqszs', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->string('hostname');
            $table->double('runq_sz', 12, 2)->nullable();
            $table->double('plist_sz', 12, 2)->nullable();
            $table->double('davg_1', 12, 2)->nullable();
            $table->double('davg_5', 12, 2)->nullable();
            $table->double('davg_15', 12, 2)->nullable();
            $table->double('blocked', 12, 2)->nullable();
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
        Schema::dropIfExists('usage_runqszs');
    }
};
