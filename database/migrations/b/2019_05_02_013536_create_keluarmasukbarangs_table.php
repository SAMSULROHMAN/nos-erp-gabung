<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeluarmasukbarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluarmasukbarangs', function (Blueprint $table) {
            $table->string('Tanggal');
            $table->string('KodeLokasi');
            $table->string('KodeItem');
            $table->string('JenisTransaksi');
            $table->string('KodeTransaksi');
            $table->string('Qty');
            $table->string('HargaRata');
            $table->string('KodeUser');
            $table->bigInteger('idx');
            $table->bigInteger('indexmov');
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
        Schema::dropIfExists('keluarmasukbarangs');
    }
}
