<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemesananpenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesananpenjualans', function (Blueprint $table) {
            $table->string('KodeSO');
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
            $table->double('Expired');
            $table->string('KodeSales');
            $table->string('POPelanggan');
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
        Schema::dropIfExists('pemesananpenjualans');
    }
}
