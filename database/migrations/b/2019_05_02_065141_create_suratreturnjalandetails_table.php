<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratreturnjalandetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suratjalanreturndetails', function (Blueprint $table) {
            $table->bigIncrements('id',10);
            $table->string('KodeSuratJalanReturn');
            $table->string('KodeItem');
            $table->double('Qty');
            $table->integer('NoUrut');
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
        Schema::dropIfExists('suratjalanreturndetails');
    }
}
