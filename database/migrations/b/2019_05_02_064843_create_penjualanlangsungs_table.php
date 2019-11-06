<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualanlangsungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualanlangsungs', function (Blueprint $table) {
            $table->string('KodePenjualanLangsung');
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
        Schema::dropIfExists('penjualanlangsungs');
    }
}
