<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_stages', function (Blueprint $table) {
            $table->id();
            $table->datetime('startdate')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('enddate')->nullable();
            $table->string('status')->default('init');
            $table->unsignedBigInteger('project_id')->comment('project id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->unsignedBigInteger('scope_stage_id')->comment('scope stage id');
            $table->foreign('scope_stage_id')->references('id')->on('scope_stages')->onDelete('cascade');
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
        Schema::dropIfExists('project_stages');
    }
}
