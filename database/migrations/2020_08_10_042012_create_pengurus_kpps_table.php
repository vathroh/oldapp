<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengurusKppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengurus_kpps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kelurahan_id');
            $table->string('ketua')->nullabe();
            $table->string('ketua_hp')->nullabe();
            $table->string('sekretaris')->nullabe();
            $table->string('sekretaris_hp')->nullabe();
            $table->string('bendahara')->nullabe();
            $table->string('bendahara_hp')->nullabe();
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
        Schema::dropIfExists('pengurus_kpps');
    }
}
