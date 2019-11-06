<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlamatpelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alamatpelanggans', function (Blueprint $table) {
            $table->string('KodePelanggan');
            $table->string('Alamat');
            $table->string('Kota');
            $table->string('Provinsi');
            $table->string('Negara');
            $table->string('Faks');
            $table->string('Telepon');
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
        Schema::dropIfExists('alamatpelanggans');
    }
}
