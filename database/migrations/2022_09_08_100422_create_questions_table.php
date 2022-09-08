<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->text('sub_question');
            $table->text('information');
            $table->enum('response_collector', ['YesNo', 'FreeText', 'Ticker', 'Form', 'Upload']);
            $table->string('scope', 50)->index()->comment('scope slug');
            $table->foreign('scope')->references('slug')->on('scopes')->onDelete('cascade');
            $table->string('category', 40)->unique()->comment('category slug');
            $table->foreign('category')->references('slug')->on('question_categories')->onDelete('cascade');
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
        Schema::dropIfExists('questions');
    }
}
