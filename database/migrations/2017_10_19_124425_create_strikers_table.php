<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrikersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strikers', function (Blueprint $table) {
            $table->increments('strikerId');
            $table->string('strikerNumber',20);
            $table->string('firstName',150);
            $table->string('middleName',150);
            $table->string('lastName',150);
            $table->date('birthday');
            $table->date('dateEmployed');
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
        Schema::dropIfExists('strikers');
    }
}
