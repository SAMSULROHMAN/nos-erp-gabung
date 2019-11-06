<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePiutangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piutangs', function (Blueprint $table) {
            $table->string('KodePiutang');
            $table->datetime('Tanggal');
            $table->string('KodePelanggan');
            $table->string('Status');
            $table->string('KodeSuratJalan');
            $table->string('Invoice');
            $table->double('Jumlah');
            $table->string('Keterangan');
            $table->string('KodeMataUang');
            $table->string('KodeUser');
            $table->double('Term');
            $table->string('Koreksi');
            $table->string('Kembali');
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
        Schema::dropIfExists('piutangs');
    }
}
