<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratjalanreturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suratjalanreturns', function (Blueprint $table) {
            $table->bigIncrements('KodeSuratJalanReturnId',10);
            $table->integer('KodeSuratJalanId');
            $table->string('KodeSuratJalanReturn');
            $table->datetime('Tanggal');
            $table->string('Status');
            $table->string('KodeUser');
            $table->double('Total');
            $table->string('PPN');
            $table->double('NilaiPPN');
            $table->double('Printed');
            $table->double('Diskon');
            $table->double('NilaiDiskon');
            $table->double('Subtotal');
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
        Schema::dropIfExists('suratjalanreturns');
    }
}
