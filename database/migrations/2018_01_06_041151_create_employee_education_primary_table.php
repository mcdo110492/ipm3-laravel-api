<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEducationPrimaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeEducationPrimary', function (Blueprint $table) {
            $table->increments('educPrimaryId');
            $table->string('educPrimarySchool',150);
            $table->string('educPrimaryAddress',150);
            $table->string('educPrimaryYear',20);
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
        Schema::dropIfExists('employeeEducationPrimary');
    }
}
