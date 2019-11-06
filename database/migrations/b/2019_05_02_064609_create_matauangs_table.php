<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatauangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matauangs', function (Blueprint $table) {
            $table->string('KodeMataUang')->primary();
            $table->string('NamaMataUang');
            $table->double('Nilai');
            $table->string('Status');
            $table->string('KodeUser');
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
        Schema::dropIfExists('matauangs');
    }
}
