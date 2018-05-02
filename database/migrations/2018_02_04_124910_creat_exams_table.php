<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('title')->comment('考试标题');
            $table->integer('paper_id')->unsigned();
            $table->foreign('paper_id')->references('id')->on('papers')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->enum('exam_type', ['PRACTICE', 'EXAM']);
            $table->integer('score')->comment('分值');
            $table->integer('min')->comment('时长');
            $table->string('describe')->comment('描述');
            $table->string('allowable_lecture_ids')->default('0');
            $table->string('allowable_orgaization_ids')->default('0');
            $table->string('allowable_user_ids')->default('0');
            $table->datetime('begin_at')->nullable();
            $table->datetime('start_at')->nullable();
            $table->datetime('finish_at')->nullable();
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
        Schema::table('exams', function (Blueprint $table) {
            //
        });
    }
}
