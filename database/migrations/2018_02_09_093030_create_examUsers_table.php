<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_user', function (Blueprint $table) {
            $table->integer('exam_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('exam_id')->references('id')->on('exams')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('answers')->comment('答案')->nullable();
            $table->string('results')->comment('结果')->nullable();
            $table->string('score')->comment('分值')->nullable();
            $table->datetime('begin_at')->nullable();
            $table->datetime('finish_at')->nullable();
            $table->datetime('correct_at')->nullable();
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
        Schema::table('user_exam', function (Blueprint $table) {
            //
        });
    }
}
