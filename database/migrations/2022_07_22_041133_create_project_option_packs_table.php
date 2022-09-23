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
        Schema::create('project_option_packs', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->string('file');
            $table->string('hostname');
            $table->string('instance_name')->nullable();
            $table->string('database_name')->nullable();
            $table->string('open_mode')->nullable();
            $table->string('database_role')->nullable();
            $table->string('created')->nullable();
            $table->string('dbid')->nullable();
            $table->string('version')->nullable();
            $table->string('banner')->nullable();
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
        Schema::dropIfExists('project_option_packs');
    }
};
