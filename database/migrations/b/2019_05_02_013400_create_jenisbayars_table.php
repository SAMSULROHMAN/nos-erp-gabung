<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJenisbayarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenisbayars', function (Blueprint $table) {
            $table->string('KodeJenisBayar');
            $table->string('JenisBayar');
            $table->string('Status');
            $table->string('Keterangan');
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
        Schema::dropIfExists('jenisbayars');
    }
}
