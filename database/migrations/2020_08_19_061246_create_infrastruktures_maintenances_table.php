<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfrastrukturesMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infrastruktures_maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kelurahan_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('sumber_dana');
            $table->bigint('jumlah');
            $table->string('foto_sebelum_perbaikan'); 
            $table->string('foto_perbaikan')->nullable();
            $table->string('foto_sesudah_perbaikan')->nullable();
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
        Schema::dropIfExists('infrastruktures_maintenances');
    }
}
