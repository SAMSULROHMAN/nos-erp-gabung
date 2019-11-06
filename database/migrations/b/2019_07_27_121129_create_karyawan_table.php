<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->bigIncrements('IDKaryawan',10);
            $table->string('KodeKaryawan',10);
            $table->string('Nama',50);
            $table->string('Alamat',200);
            $table->string('Kota',100);
            $table->string('Propinsi');
            $table->string('Negara');
            $table->string('Telepon');
            $table->string('Email');
            $table->enum('JenisKelamin',['Laki-laki','Perempuan']);
            $table->string('KodeUser');
            $table->string('Status');
            $table->string('Jabatan');
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
        Schema::dropIfExists('karyawan');
    }
}
