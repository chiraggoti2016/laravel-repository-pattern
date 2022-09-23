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
        Schema::create('usage_databases', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->string('hostname');
            $table->string('cpu')->nullable();
            $table->string('usr')->nullable();
            $table->string('nice')->nullable();
            $table->string('sys')->nullable();
            $table->string('iowait')->nullable();
            $table->string('steal')->nullable();
            $table->string('irq')->nullable();
            $table->string('soft')->nullable();
            $table->string('guest')->nullable();
            $table->string('gnice')->nullable();
            $table->string('idle')->nullable();
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
        Schema::dropIfExists('usage_databases');
    }
};
