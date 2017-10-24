<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeClubInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeClubInfo', function (Blueprint $table) {
            $table->increments('employeeClubId');
            $table->unsignedInteger('employeeId');
            $table->string('clubName',150);
            $table->string('clubPosition',150);
            $table->date('membershipDate');
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
        Schema::dropIfExists('employeeClubInfo');
    }
}
