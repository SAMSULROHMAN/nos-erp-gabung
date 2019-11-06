<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHutangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hutangs', function (Blueprint $table) {
            $table->string('KodeHutang');
            $table->datetime('Tanggal');
            $table->string('KodeSupplier');
            $table->string('Status');
            $table->string('KodeLPB');
            $table->string('Invoice');
            $table->double('Jumlah');
            $table->string('Keterangan');
            $table->string('KodeMataUang');
            $table->string('KodeUser');
            $table->double('Term');
            $table->string('Koreksi');
            $table->string('Kembali');
            $table->string('InvoiceSupplier');
            $table->date('TanggalInvoiceSupplier');
            $table->string('hutangcol');
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
        Schema::dropIfExists('hutangs');
    }
}
