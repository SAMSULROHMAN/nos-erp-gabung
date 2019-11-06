<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratjalansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suratjalans', function (Blueprint $table) {
            $table->bigIncrements('KodeSuratJalanID',10);
            $table->string('KodeSuratJalan');
            $table->datetime('Tanggal');
            $table->string('KodeLokasi');
            $table->string('KodeMataUang');
            $table->string('Status');
            $table->string('KodeUser');
            $table->double('Total');
            $table->string('PPN');
            $table->double('NilaiPPN');
            $table->double('Printed');
            $table->double('Diskon');
            $table->double('NilaiDiskon');
            $table->double('Subtotal');
            $table->string('KodePelanggan');
            $table->integer('NoIndeks');
            $table->string('Nopol');
            $table->string('KodeSO');
            $table->string('KodeSopir');
            $table->string('Alamat');
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
        Schema::dropIfExists('suratjalans');
    }
}
