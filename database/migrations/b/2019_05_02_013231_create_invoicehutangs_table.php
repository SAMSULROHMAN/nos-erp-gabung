<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicehutangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicehutangs', function (Blueprint $table) {
            $table->string('KodeInvoiceHutang');
            $table->datetime('Tanggal');
            $table->string('KodeSupplier');
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
        Schema::dropIfExists('invoicehutangs');
    }
}
