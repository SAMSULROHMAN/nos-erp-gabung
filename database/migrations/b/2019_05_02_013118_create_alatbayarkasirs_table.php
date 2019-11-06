<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlatbayarkasirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alatbayarkasirs', function (Blueprint $table) {
            $table->string('KodeAlatBayarKasir');
            $table->string('UntukPembayaran');
            $table->string('Keterangan');
            $table->double('Total');
            $table->string('PPN');
            $table->double('NominalPPN');
            $table->double('Bayar');
            $table->double('Kembali');
            $table->double('Ongkir');
            $table->string('KodeJenisBayar');
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
        Schema::dropIfExists('alatbayarkasirs');
    }
}
