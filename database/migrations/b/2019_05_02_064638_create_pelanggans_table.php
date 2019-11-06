<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->string('KodePelanggan')->primary();
            $table->string('NamaPelanggan');
            $table->string('Kontak');
            $table->string('Handphone');
            $table->string('Email');
            $table->string('NIK');
            $table->double('LimitPiutang')->nullable();
            $table->double('Diskon')->nullable();
            $table->string('Status');
            $table->string('KodeLokasi')->nullable();
            $table->string('KodeUser')->nullable();
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
        Schema::dropIfExists('pelanggans');
    }
}
