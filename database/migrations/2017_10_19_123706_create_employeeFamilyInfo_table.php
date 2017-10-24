<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeFamilyInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeFamilyInfo', function (Blueprint $table) {
            $table->increments('employeeFamilyId');
            $table->unsignedInteger('employeeId');
            $table->string('familyName',150);
            $table->string('occupation',150);
            $table->date('birthday');
            $table->string('address',150);
            $table->string('relation',150);
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
        Schema::dropIfExists('employeeFamilyInfo');
    }
}
