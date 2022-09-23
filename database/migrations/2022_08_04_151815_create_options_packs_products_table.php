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
        Schema::create('options_packs_products', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->integer('cpu_count_database_detail_id');
            $table->string('hostname');
            $table->string('con_name')->default('ALL');
            $table->string('product');
            $table->string('usage')->nullable();
            $table->string('last_sample_date')->nullable();
            $table->string('first_usage_date')->nullable();
            $table->string('last_usage_date')->nullable();
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
        Schema::dropIfExists('options_packs_products');
    }
};
