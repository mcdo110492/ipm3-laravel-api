<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeePersonalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeePersonalInfo', function (Blueprint $table) {
            $table->increments('employeeId');
            $table->string('employeeNumber',20)->unique();
            $table->string('firstName',150);
            $table->string('middleName',150);
            $table->string('lastName',150);
            $table->date('birthday');
            $table->string('placeOfBirth',150);
            $table->string('civilStatus',50);
            $table->string('citizenship',50);
            $table->string('religion',150);
            $table->string('profileImage',250)->default('employee/default.jpg');
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
        Schema::dropIfExists('employeePersonalInfo');
    }
}
