<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id')->comment('出卷人')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('title')->comment('试卷标题');
            $table->integer('score')->comment('分值');
            $table->integer('min')->comment('时长');
            $table->string('describe')->comment('描述');
            $table->string('sections')->comment('节')->nullable();
            $table->string('tags')->nullable();
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
        Schema::dropIfExists('papers');
    }
}
