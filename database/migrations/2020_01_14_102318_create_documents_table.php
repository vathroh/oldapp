<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_id');
            $table->string('file_name');
            $table->string('file_extension');
            $table->integer('file_size');
            $table->string('tipe_dokumen');
            $table->string('jenis_dokumen');
            $table->string('uploaded_by');
            $table->string('scope');
            $table->string('kode_kegiatan');
            $table->integer('kode_kel');
            $table->string('desa');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('link');
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
        Schema::dropIfExists('documents');
    }
}
