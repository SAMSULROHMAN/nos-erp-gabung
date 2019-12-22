<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePenerimaanbarangreturndetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaanbarangreturndetails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('KodePenerimaanBarangReturn');
            $table->string('KodeItem');
            $table->string('KodeSatuan');
            $table->string('Harga');
            $table->string('Qty');
            $table->text('Keterangan')->nullable();
            $table->string('NoUrut')->nullable();
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
        Schema::dropIfExists('table_penerimaanbarangreturndetails');
    }
}
