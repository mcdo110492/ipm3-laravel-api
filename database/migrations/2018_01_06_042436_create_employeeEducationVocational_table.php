<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEducationVocationalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeEducationVocational', function (Blueprint $table) {
            $table->increments('educVocationalId');
            $table->string('educVocationSchool',150);
            $table->string('educVocationalAddress',150);
            $table->string('educVocationalCourse',150);
            $table->string('educVocationalYear',20);
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
        Schema::dropIfExists('employeeEducationVocational');
    }
}
