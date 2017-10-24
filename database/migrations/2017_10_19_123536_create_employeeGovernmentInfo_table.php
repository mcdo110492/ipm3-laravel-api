<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeGovernmentInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeGovernmentInfo', function (Blueprint $table) {
            $table->increments('employeeGovernmentId');
            $table->unsignedInteger('employeeId');
            $table->string('sssNumber',20);
            $table->string('pagIbigNumber',20);
            $table->string('philHealthNumber',20);
            $table->string('tinNumber',20);
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
        Schema::dropIfExists('employeeGovernmentInfo');
    }
}
