<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvopnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invopnames', function (Blueprint $table) {
            $table->datetime('Tanggal');
            $table->string('Status');
            $table->string('KodeLokasi');
            $table->string('KodeItem');
            $table->string('KodeSatuan');
            $table->double('qtyOPN');
            $table->double('qtyIN');
            $table->double('qtyOUT');
            $table->double('qtyInHand');
            $table->double('qtyOpname');
            $table->double('qtyBlc');
            $table->double('HargaRata');
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
        Schema::dropIfExists('invopnames');
    }
}
