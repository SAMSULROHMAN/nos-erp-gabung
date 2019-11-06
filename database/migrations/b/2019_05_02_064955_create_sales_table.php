<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->string('KodeSales');
            $table->string('NamaSales');
            $table->string('Kontak');
            $table->string('Handphone');
            $table->string('Email');
            $table->string('NIK');
            $table->string('Status');
            $table->string('KodeLokasi');
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
        Schema::dropIfExists('sales');
    }
}
