<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEducationInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeEducationInfo', function (Blueprint $table) {
            $table->increments('employeeEducationId');
            $table->unsignedInteger('employeeId');
            $table->string('schoolName',150);
            $table->string('schoolAddress',150);
            $table->string('schoolYear',20);
            $table->string('degree',150);
            $table->string('major',150);
            $table->string('minor',150);
            $table->string('awards',150);
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
        Schema::dropIfExists('employeeEducationInfo');
    }
}
