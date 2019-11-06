<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicepiutangdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicepiutangdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('KodePiutang');
            $table->string('KodeSuratJalan');
            $table->double('Subtotal');
            $table->string('KodeInvoicePiutang');
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
        Schema::dropIfExists('invoicepiutangdetails');
    }
}
