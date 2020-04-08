<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKsmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ksm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('KD_KEL');
            $table->integer('KD_KSM');
            $table->integer('TAHUN');
            $table->string('NAMA_KSM');
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
        Schema::dropIfExists('ksm');
    }
}
