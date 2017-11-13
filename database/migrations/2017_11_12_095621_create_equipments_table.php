<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->increments('equipmentId');
            $table->string('equipmentCode',20)->unique();
            $table->string('bodyNumber',20)->unique();
            $table->string('model',150);
            $table->string('capacity',50);
            $table->string('plateNo',50)->unique();
            $table->string('remarks',150)->nullable();
            $table->unsignedSmallInteger('status')->default(1);
            $table->unsignedInteger('unitId');
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
        Schema::dropIfExists('equipments');
    }
}
