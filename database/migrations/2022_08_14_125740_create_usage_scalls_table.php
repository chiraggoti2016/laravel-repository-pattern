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
        Schema::create('usage_scalls', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->string('hostname');
            $table->double('scall_s', 12, 2)->nullable();
            $table->double('badcall_s', 12, 2)->nullable();
            $table->double('packet_s', 12, 2)->nullable();
            $table->double('udp_s', 12, 2)->nullable();
            $table->double('tcp_s', 12, 2)->nullable();
            $table->double('hit_s', 12, 2)->nullable();
            $table->double('miss_s', 12, 2)->nullable();
            $table->double('sread_s', 12, 2)->nullable();
            $table->double('swrite_s', 12, 2)->nullable();
            $table->double('saccess_s', 12, 2)->nullable();
            $table->double('sgetatt_s', 12, 2)->nullable();
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
        Schema::dropIfExists('usage_scalls');
    }
};
