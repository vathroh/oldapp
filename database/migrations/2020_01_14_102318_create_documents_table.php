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
            $table->string('year');
            $table->string('folder_id');
            $table->string('file_id');
            $table->string('file_name');
            $table->string('file_extension');
            $table->string('tipe_dokumen');
            $table->string('jenis_dokumen');
            $table->string('uploaded_by');
            $table->string('scope');
            $table->string('kode_kegiatan');
            $table->string('nama_desa');
            $table->string('nama_kab');
            $table->text('comments');
            $table->string('path');
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
