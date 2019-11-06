<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStokkeluardetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stokkeluardetails', function (Blueprint $table) {
            $table->bigIncrements('id',10);
            $table->string('KodeStokKeluar');
            $table->string('KodeItem');
            $table->string('KodeSatuan');
            $table->double('Qty');
            $table->string('Keterangan');
            $table->integer('NoUrut');
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
        Schema::dropIfExists('stokkeluardetails');
    }
}
