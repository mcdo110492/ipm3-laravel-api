<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEducationHighestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeEducationHighest', function (Blueprint $table) {
            $table->increments('educHighestId');
            $table->string('educHighestSchool',150);
            $table->string('educHighestAddress',150);
            $table->string('educHighestCourse',150);
            $table->string('educHighestYear',20);
            $table->unsignedInteger('employeeId');
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
        Schema::dropIfExists('employeeEducationHighest');
    }
}
