<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('KodeItem')->primary();
            $table->string('KodeKategori');
            $table->string('NamaItem');
            $table->string('Alias');
            $table->enum('jenisitem',['bahanbaku','bahanjadi']);
            $table->string('Keterangan');
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
        Schema::dropIfExists('items');
    }
}
