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
        Schema::create('hostnames', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('hostname');
            $table->string('host_details')->nullable();
            $table->string('server_identifier')->nullable();
            $table->enum('environment', ['production', 'development', 'test', 'dr', 'qa', 'staging', 'other'])->nullable();
            $table->string('cpu_count_file')->nullable();
            $table->string('cpu_count_new_file')->nullable();
            $table->string('cpu_count_file_path')->nullable();
            $table->date('cpu_count_date')->nullable();
            $table->string('cpu_usage_file')->nullable();
            $table->string('cpu_usage_new_file')->nullable();
            $table->string('cpu_usage_file_path')->nullable();
            $table->date('cpu_usage_date')->nullable();
            $table->string('options_packs_file')->nullable();
            $table->string('options_packs_new_file')->nullable();
            $table->string('options_packs_file_path')->nullable();
            $table->date('options_packs_date')->nullable();
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
        Schema::dropIfExists('hostnames');
    }
};
