<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePindahgudangdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pindahgudangdetails', function (Blueprint $table) {
            $table->string('KodePindah');
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
        Schema::dropIfExists('pindahgudangdetails');
    }
}
