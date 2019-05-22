<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_post', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('college_id');
            $table->string('class_id');
            $table->string('post');
            $table->string('comment');
            $table->string('image');
            $table->string('video');
            $table->string('deleted_at');
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
        Schema::dropIfExists('college_post');
    }
}
