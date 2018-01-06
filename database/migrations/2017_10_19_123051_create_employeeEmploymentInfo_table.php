<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEmploymentInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeEmploymentInfo', function (Blueprint $table) {
            $table->increments('employeeEmploymentId');
            $table->unsignedInteger('employeeId');
            $table->unsignedInteger('positionId');
            $table->unsignedInteger('employeeStatusId');
            $table->unsignedInteger('employmentStatusId');
            $table->unsignedInteger('contractTypeId');
            $table->date('dateHired');
            $table->date('contractStart');
            $table->date('contractEnd');
            $table->string('remarks',150)->nullable();
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
        Schema::dropIfExists('employeeEmploymentInfo');
    }
}
