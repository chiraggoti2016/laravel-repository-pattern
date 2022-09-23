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
        Schema::create('usage_devs', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->string('hostname');
            $table->string('dev')->nullable();
            $table->double('tps', 12, 2)->nullable();
            $table->double('rd_sec_s', 12, 2)->nullable();
            $table->double('wr_sec_s', 12, 2)->nullable();
            $table->double('avgrq_sz', 12, 2)->nullable();
            $table->double('avgqu_sz', 12, 2)->nullable();
            $table->double('await', 12, 2)->nullable();
            $table->double('svctm', 12, 2)->nullable();
            $table->double('util', 12, 2)->nullable();
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
        Schema::dropIfExists('usage_devs');
    }
};
