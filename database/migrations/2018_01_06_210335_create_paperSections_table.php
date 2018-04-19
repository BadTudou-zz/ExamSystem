<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaperSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('describe');
            $table->enum('question_type', ['SINGLE_CHOICE', 'MULTIPLE_CHOICE', ' TRUE_FALSE', 'FILL_IN', 'SHORT_ANSWER']);;
            $table->integer('score')->comment('分值');
            $table->integer('number')->comment('提数');
            $table->string('questions')->comment('题目')->nullable();
            $table->string('scores')->comment('分数')->nullable();
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
        Schema::dropIfExists('paper_sections');
    }
}
