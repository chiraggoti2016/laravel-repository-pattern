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
        Schema::create('usage_kbmemfrees', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->string('hostname');
            $table->double('kbmemfree', 12, 2)->nullable();
            $table->double('kbmemused', 12, 2)->nullable();
            $table->double('memused', 12, 2)->nullable();
            $table->double('kbbuffers', 12, 2)->nullable();
            $table->double('kbcached', 12, 2)->nullable();
            $table->double('kbcommit', 12, 2)->nullable();
            $table->double('commit', 12, 2)->nullable();
            $table->double('kbactive', 12, 2)->nullable();
            $table->double('kbinact', 12, 2)->nullable();
            $table->double('kbdirty', 12, 2)->nullable();
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
        Schema::dropIfExists('usage_kbmemfrees');
    }
};
