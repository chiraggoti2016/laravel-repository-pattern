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
        Schema::create('usage_ifacerxerrs', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->string('hostname');
            $table->string('iface')->nullable();
            $table->double('rxerr_s', 12, 2)->nullable();
            $table->double('txerr_s', 12, 2)->nullable();
            $table->double('coll_s', 12, 2)->nullable();
            $table->double('rxdrop_s', 12, 2)->nullable();
            $table->double('txdrop_s', 12, 2)->nullable();
            $table->double('txcarr_s', 12, 2)->nullable();
            $table->double('rxfram_s', 12, 2)->nullable();
            $table->double('rxfifo_s', 12, 2)->nullable();
            $table->double('txfifo_s', 12, 2)->nullable();
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
        Schema::dropIfExists('usage_ifacerxerrs');
    }
};
