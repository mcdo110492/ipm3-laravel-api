<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLicenseInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeLicenseInfo', function (Blueprint $table) {
            $table->increments('employeeLicenseId');
            $table->unsignedInteger('employeeId');
            $table->string('licenseNumber',20);
            $table->string('licenseType',20);
            $table->date('dateIssued');
            $table->date('dateExpiry');
            $table->string('licenseImage',200);
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
        Schema::dropIfExists('employeeLicenseInfo');
    }
}
