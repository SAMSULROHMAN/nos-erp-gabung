<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualanlangsungdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualanlangsungdetails', function (Blueprint $table) {
            $table->string('KodePenjualanLangsung');
            $table->string('KodeItem');
            $table->string('KodeSatuan');
            $table->double('Qty');
            $table->double('Harga');
            $table->string('Keterangan');
            $table->integer('NoUrut');
            $table->double('Subtotal');
            $table->double('Diskon');
            $table->double('NilaiDiskon');
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
