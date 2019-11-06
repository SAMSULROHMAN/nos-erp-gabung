<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembelianlangsungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelianlangsungs', function (Blueprint $table) {
            $table->string('KodePembelianLangsung');
            $table->date('Tanggal');
            $table->string('KodeLokasi');
            $table->string('KodeMataUang');
            $table->string('KodeUser');
            $table->string('Status');
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
        Schema::dropIfExists('pembelianlangsungs');
    }
}
