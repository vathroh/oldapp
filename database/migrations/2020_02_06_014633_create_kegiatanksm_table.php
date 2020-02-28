<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatanksmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatanksm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('TAHUN');
            $table->string('KD_KSM');
            $table->string('KD_KEGIATAN');
            $table->string('KEGIATAN');
            $table->string('RTRW');
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
        Schema::dropIfExists('kegiatanksm');
    }
}
