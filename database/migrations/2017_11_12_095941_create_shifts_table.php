<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->increments('shiftId');
            $table->unsignedInteger('equipmentId');
            $table->unsignedInteger('collectionScheduleId');
            $table->unsignedInteger('collectionTypeId');
            $table->string('geofenceName',150);
            $table->string('sectors',150);
            $table->time('shiftTime');
            $table->string('routeFile',200)->default('routes/default.jpg');
            $table->unsignedInteger('projectId');
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
        Schema::dropIfExists('shifts');
    }
}
