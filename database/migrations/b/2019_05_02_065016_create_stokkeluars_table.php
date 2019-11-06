<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStokkeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stokkeluars', function (Blueprint $table) {
            $table->string('KodeStokKeluar')->primary();
            $table->string('KodeLokasi');
            $table->datetime('Tanggal');
            $table->string('Status');
            $table->string('KodeUser');
            $table->double('TotalItem');
            $table->double('Printed');
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
        Schema::dropIfExists('stokkeluars');
    }
}
