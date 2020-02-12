<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_folders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_folder');
            $table->string('parent_folder');
            $table->string('id_folder');
            $table->string('nama_folder');
            $table->string('path_folder');
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
        Schema::dropIfExists('google_folders');
    }
}
