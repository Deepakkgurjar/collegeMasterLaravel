<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('college_id');
            $table->string('class_id');
            $table->year('year');
            $table->string('email')->unique('users');
            $table->string('password');
            $table->string('verify')->default('n');
            $table->string('api_token');
            $table->string('deleted_at');
            $table->string('approved_by')->default('admin');
            $table->string('sub_admin_flag')->default('s');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
