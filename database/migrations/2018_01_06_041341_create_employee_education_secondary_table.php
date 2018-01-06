<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEducationSecondaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeEducationSecondary', function (Blueprint $table) {
            $table->increments('educSecondaryId');
            $table->string('educSecondarySchool',150);
            $table->string('educSecondaryAddress',150);
            $table->string('educSecondaryYear',20);
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
        Schema::dropIfExists('employeeEducationSecondary');
    }
}
