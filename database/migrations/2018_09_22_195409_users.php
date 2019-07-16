<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
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
            // $table->string('username', 255)->unique();
            $table->string('email', 255)->unique();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('password', 255);
            $table->tinyinteger('active')->default(0);
            $table->string('activation_token')->nullable();
            $table->integer('last_login')->default(time());
            $table->ipAddress('last_login_address')->default('0.0.0.0');
            $table->integer('locked_until')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->engine = 'InnoDB';

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
