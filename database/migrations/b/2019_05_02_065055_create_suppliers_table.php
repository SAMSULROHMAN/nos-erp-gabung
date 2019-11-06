<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->string('KodeSupplier')->primary();
            $table->string('NamaSupplier');
            $table->string('Kontak');
            $table->string('Handphone');
            $table->string('Email')->nullable();
            $table->string('NIK')->nullable();
            $table->string('Status');
            $table->string('KodeLokasi')->nullable();
            $table->string('KodeUser')->nullable();
            $table->string('Alamat');
            $table->string('Kota')->nullable();
            $table->string('Provinsi')->nullable();
            $table->string('Negara')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
