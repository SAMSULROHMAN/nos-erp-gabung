<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePelunasanhutangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelunasanhutangs', function (Blueprint $table) {
            $table->string('KodePelunasanHutang');
            $table->date('Tanggal');
            $table->string('Status');
            $table->string('KodeHutang');
            $table->string('KodeInvoice');
            $table->string('KodeBayar');
            $table->string('TipeBayar');
            $table->double('Jumlah');
            $table->string('Keterangan');
            $table->string('KodeMataUang');
            $table->string('KodeUser');
            $table->string('KodeSupplier');
            $table->string('KodeKasBank');
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
        Schema::dropIfExists('pelunasanhutangs');
    }
}
