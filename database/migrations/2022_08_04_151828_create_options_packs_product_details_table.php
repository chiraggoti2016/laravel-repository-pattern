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
        Schema::create('options_packs_product_details', function (Blueprint $table) {
            $table->id();
            $table->integer('hostname_id');
            $table->integer('project_id');
            $table->integer('cpu_count_database_detail_id');
            $table->string('hostname');
            $table->string('con_name')->default('ALL');
            $table->string('product');
            $table->string('feature_being_used')->nullable();
            $table->string('usage')->nullable();
            $table->date('last_sample_date')->nullable();
            $table->string('dbid')->nullable();
            $table->string('version')->nullable();
            $table->integer('detected_usages')->nullable();
            $table->integer('total_samples')->nullable();
            $table->string('currently_used')->nullable();
            $table->date('first_usage_date')->nullable();
            $table->date('last_usage_date')->nullable();
            $table->string('extra_feature_info')->nullable();
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
        Schema::dropIfExists('options_packs_product_details');
    }
};
