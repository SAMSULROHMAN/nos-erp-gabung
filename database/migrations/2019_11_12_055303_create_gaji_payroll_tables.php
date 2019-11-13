<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGajiPayrollTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gaji', function (Blueprint $table) {
            $table->increments('IDKaryawan');
            $table->decimal('GajiPokok',12,3);
            $table->decimal('TunjanganJabatan',12,3);
            $table->decimal('TunjanganKeluarga',12,3);
            $table->decimal('UangMakan',12,3);
            $table->decimal('UangLembur',12,3);
            $table->decimal('PersenPotPph',12,3);
            $table->decimal('Ptkp',12,3);
            $table->decimal('PersenPotJamso',12,3);
            $table->decimal('PotLain',12,3);
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
        Schema::dropIfExists('gaji');
    }
}
