<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTrainingInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeTrainingInfo', function (Blueprint $table) {
            $table->increments('employeeTrainingId');
            $table->unsignedInteger('employeeId');
            $table->string('trainingName',150);
            $table->string('trainingTitle',150);
            $table->date('trainingFrom');
            $table->date('trainingTo');
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
        Schema::dropIfExists('employeeTrainingInfo');
    }
}
