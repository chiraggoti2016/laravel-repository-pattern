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
        Schema::create('usage_kbswpfrees', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->string('hostname');
            $table->double('kbswpfree', 12, 2)->nullable();
            $table->double('kbswpused', 12, 2)->nullable();
            $table->double('swpused', 12, 2)->nullable();
            $table->double('kbswpcad', 12, 2)->nullable();
            $table->double('swpcad', 12, 2)->nullable();
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
        Schema::dropIfExists('usage_kbswpfrees');
    }
};
