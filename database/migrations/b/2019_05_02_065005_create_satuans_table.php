<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSatuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satuans', function (Blueprint $table) {
            $table->string('KodeSatuan')->primary();
            $table->string('NamaSatuan');
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
        Schema::dropIfExists('satuans');
    }
}
