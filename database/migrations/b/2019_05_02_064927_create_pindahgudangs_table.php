<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePindahgudangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pindahgudangs', function (Blueprint $table) {
            $table->string('KodePindah');
            $table->string('KodeUser');
            $table->string('Status');
            $table->string('DariLokasi');
            $table->string('KeLokasi');
            $table->datetime('Tanggal');
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
        Schema::dropIfExists('pindahgudangs');
    }
}
