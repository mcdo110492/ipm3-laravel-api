<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeContractHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeContractHistory', function (Blueprint $table) {
            $table->increments('employeeContractId');
            $table->unsignedInteger('employeeId');
            $table->date('contractStart');
            $table->date('contractEnd');
            $table->unsignedInteger('contractTypeId');
            $table->date('contractExtension')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('employeeContractHistory');
    }
}
