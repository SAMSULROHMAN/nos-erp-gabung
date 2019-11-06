<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKasbanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasbanks', function (Blueprint $table) {
            $table->string('KodeKasBank');
            $table->datetime('Tanggal');
            $table->string('Status');
            $table->date('TanggalCheque');
            $table->string('KodeBayar');
            $table->string('TipeBayar');
            $table->string('NoLink');
            $table->string('BayarDari');
            $table->string('Untuk');
            $table->string('Keterangan');
            $table->string('KodeUser');
            $table->string('Tipe');
            $table->double('Total');
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
        Schema::dropIfExists('kasbanks');
    }
}
