<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEducationTertiaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeEducationTertiary', function (Blueprint $table) {
            $table->increments('educTertiaryId');
            $table->string('educTertiarySchool',150);
            $table->string('educTertiaryAddress',150);
            $table->string('educTertiaryCourse',150);
            $table->string('educTertiaryYear',20);
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
        Schema::dropIfExists('employeeEducationTertiary');
    }
}
