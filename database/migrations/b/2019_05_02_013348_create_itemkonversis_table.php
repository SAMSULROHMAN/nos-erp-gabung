<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemkonversisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemkonversis', function (Blueprint $table) {
            $table->string('KodeItem')->primary();
            $table->string('KodeSatuan');
            $table->double('Konversi');
            $table->double('HargaBeli');
            $table->double('HargaJual');
            $table->double('HargaGrosir');
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
        Schema::dropIfExists('itemkonversis');
    }
}
