<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeHealthInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeHealthInfo', function (Blueprint $table) {
            $table->increments('employeeHealthId');
            $table->unsignedInteger('employeeId');
            $table->string('height',20);
            $table->string('weight',20);
            $table->string('bloodType',20);
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
        Schema::dropIfExists('employeeHealthInfo');
    }
}
