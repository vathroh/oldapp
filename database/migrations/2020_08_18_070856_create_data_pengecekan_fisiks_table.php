<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPengecekanFisiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_pengecekan_fisiks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kelurahan_id');
            $table->date('tanggal');
            $table->string('keterangan');
            $table->string('foto_pengecekan_fisik');
            $table->int('inputby_id');
            $table->int('editby_id');
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
        Schema::dropIfExists('data_pengecekan_fisiks');
    }
}
