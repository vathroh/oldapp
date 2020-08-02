<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllvillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allvillages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('KD_KAB');
            $table->string('NAMA_KAB');
            $table->string('KD_KEC');
            $table->string('NAMA_KEC');
            $table->string('IDDESA');
            $table->string('KD_KEL');
            $table->string('NAMA_DESA');
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
        Schema::dropIfExists('allvillages');
    }
}
