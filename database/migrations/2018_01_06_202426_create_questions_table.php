<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->enum('question_type', ['SINGLE_CHOICE', 'MULTIPLE_CHOICE', ' TRUE_FALSE', 'FILL_IN', 'SHORT_ANSWER']);;
            $table->string('tags')->default('0');
            $table->enum('level_type', ['EASY', 'MIDDLE', 'HARD']);
            $table->string('title');
            $table->string('body');
            $table->string('answer');
            $table->string('answer_comment');
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
