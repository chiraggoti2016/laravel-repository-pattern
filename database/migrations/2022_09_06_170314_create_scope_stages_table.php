<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScopeStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scope_stages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('scope', 50)->index()->comment('scope slug');
            $table->foreign('scope')->references('slug')->on('scopes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scope_stages');
    }
}
