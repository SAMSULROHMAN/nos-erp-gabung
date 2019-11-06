<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemesananPenjualanDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan_penjualan_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('KodeSO');
            $table->string('KodeItem');
            $table->double('Qty');
            $table->double('Harga');
            $table->integer('NoUrut');
            $table->double('Subtotal');
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
        Schema::dropIfExists('penjualanlangsungdetails');
    }
}
