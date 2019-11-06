<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicehutangdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicehutangdetails', function (Blueprint $table) {
            $table->string('KodeHutang');
            $table->string('KodeLPB');
            $table->double('Subtotal');
            $table->string('KodeInvoiceHutang');
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
        Schema::dropIfExists('invoicehutangdetails');
    }
}
