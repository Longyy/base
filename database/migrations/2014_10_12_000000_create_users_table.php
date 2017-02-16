<?php

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
            $table->increments('iAutoID');
            $table->string('sName');
            $table->string('sEmail')->unique();
            $table->string('sPassword', 60);
            $table->rememberToken();
            $table->integer('iCreateTime');
            $table->integer('iUpdateTime');
            $table->integer('iDeleteTime');
            $table->integer('iStatus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
