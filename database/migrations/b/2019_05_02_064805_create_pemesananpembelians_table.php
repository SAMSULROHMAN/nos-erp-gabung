<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemesananpembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesananpembelians', function (Blueprint $table) {
            $table->string('KodePO');
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
            $table->string('KodeSupplier');
            $table->string('Expired');
            $table->date('Tanggal');
            $table->string('Keterangan');
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
        Schema::dropIfExists('pemesananpembelians');
    }
}
