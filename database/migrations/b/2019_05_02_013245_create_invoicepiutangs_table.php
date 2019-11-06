<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicepiutangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicepiutangs', function (Blueprint $table) {
            $table->bigIncrements('KodeInvoicePiutang');
            $table->datetime('Tanggal');
            $table->string('KodePelanggan');
            $table->string('Status');
            $table->double('Total');
            $table->string('Keterangan');
            $table->string('KodeMataUang');
            $table->string('KodeUser');
            $table->double('Term');
            $table->string('KodeLokasi');
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
        Schema::dropIfExists('invoicepiutangs');
    }
}
