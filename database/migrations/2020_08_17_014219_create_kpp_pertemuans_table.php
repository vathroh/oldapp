<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKppPertemuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpp_pertemuans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kelurahan_id');
            $table->date('tanggal');
            $table->string('pokok_bahasan');
            $table->string('keterangan');
            $table->bigIncrements('inputby_id')->nullabe();
            $table->bigIncrements('editedby_id')->nullabe();
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
        Schema::dropIfExists('kpp_pertemuans');
    }
}
