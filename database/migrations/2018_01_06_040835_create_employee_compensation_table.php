<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeCompensationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeCompensations', function (Blueprint $table) {
            $table->increments('employeeCompensationId');
            $table->unsignedInteger('employeeId');
            $table->unsignedInteger('salaryTypeId');
            $table->string('salary',20);
            $table->date('effectiveDate');
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
       Schema::dropIfExists('employeeCompensations');
    }
}
