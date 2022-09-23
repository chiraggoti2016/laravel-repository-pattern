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
        Schema::create('usage_ifacerxpcks', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->string('hostname');
            $table->double('iface', 12, 2)->nullable();
            $table->double('rxpck_s', 12, 2)->nullable();
            $table->double('txpck_s', 12, 2)->nullable();
            $table->double('rxkb_s', 12, 2)->nullable();
            $table->double('txkb_s', 12, 2)->nullable();
            $table->double('rxcmp_s', 12, 2)->nullable();
            $table->double('txcmp_s', 12, 2)->nullable();
            $table->double('rxmcst_s', 12, 2)->nullable();
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
        Schema::dropIfExists('usage_ifacerxpcks');
    }
};
