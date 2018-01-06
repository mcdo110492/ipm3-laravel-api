<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeContactInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeContactInfo', function (Blueprint $table) {
            $table->increments('employeeContactId');
            $table->unsignedInteger('employeeId');
            $table->string('presentAddress',150);
            $table->string('provincialAddress',150);
            $table->string('primaryMobileNumber',50);
            $table->string('secondaryMobileNumber',50);
            $table->string('telephoneNumber',50);
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
        Schema::dropIfExists('employeeContactInfo');
    }
}
