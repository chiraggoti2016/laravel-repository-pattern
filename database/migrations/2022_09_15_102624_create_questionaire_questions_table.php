<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionaireQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionaire_questions', function (Blueprint $table) {
            $table->id();
            $table->text('input')->nullable();
            $table->text('depend')->nullable();
            $table->unsignedBigInteger('question_id')->comment('question id');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->unsignedBigInteger('questionaire_id')->comment('questionaire id');
            $table->foreign('questionaire_id')->references('id')->on('questionaires')->onDelete('cascade');
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
        Schema::dropIfExists('questionaire_questions');
    }
}
