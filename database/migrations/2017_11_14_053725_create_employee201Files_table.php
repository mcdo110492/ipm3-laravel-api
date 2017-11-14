<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployee201FilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee201Files', function (Blueprint $table) {
            $table->increments('employee201FileId');
            $table->unsignedInteger('employeeId');
            $table->string('filePath',200);
            $table->unsignedSmallInteger('fileStatus')->default(1);
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
        Schema::dropIfExists('employee201Files');
    }
}
