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
        Schema::create('usage_pgpgins', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->string('hostname');
            $table->string('pgpgin_s')->nullable();
            $table->string('pgpgout_s')->nullable();
            $table->string('fault_s')->nullable();
            $table->string('majflt_s')->nullable();
            $table->string('pgfree_s')->nullable();
            $table->string('pgscank_s')->nullable();
            $table->string('pgscand_s')->nullable();
            $table->string('pgsteal_s')->nullable();
            $table->string('vmeff')->nullable();
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
        Schema::dropIfExists('usage_pgpgins');
    }
};
