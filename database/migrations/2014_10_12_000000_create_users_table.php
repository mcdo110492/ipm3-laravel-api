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
            $table->increments('userId');
            $table->string('username',50)->unique();
            $table->string('password',250);
            $table->string('profileName',150);
            $table->unsignedSmallInteger('role');
            $table->unsignedSmallInteger('status')->default(1);
            $table->string('profileImage',250)->default('avatars/default.jpg');
            $table->unsignedInteger('projectId');
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
