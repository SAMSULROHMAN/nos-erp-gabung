<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventlogs', function (Blueprint $table) {
            $table->string('KodeUser');
            $table->date('Tanggal');
            $table->time('Jam');
            $table->string('Keterangan');
            $table->string('Tipe');
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
        Schema::dropIfExists('eventlogs');
    }
}
