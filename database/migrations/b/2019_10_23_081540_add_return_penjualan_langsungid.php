<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReturnPenjualanLangsungid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualanlangsungreturns', function (Blueprint $table) {
            $table->bigIncrements('KodePenjualanLangsungReturnID');
            $table->Integer('KodePenjualanLangsungID');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
