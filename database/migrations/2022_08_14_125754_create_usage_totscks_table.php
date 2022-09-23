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
        Schema::create('usage_totscks', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->string('hostname');
            $table->string('totsck');
            $table->double('tcpsck', 12, 2)->nullable();
            $table->double('udpsck', 12, 2)->nullable();
            $table->double('rawsck', 12, 2)->nullable();
            $table->double('ip_frag', 12, 2)->nullable();
            $table->double('tcp_tw', 12, 2)->nullable();
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
        Schema::dropIfExists('usage_totscks');
    }
};
