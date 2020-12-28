<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKppdatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kppdatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_desa')->nullable();
            $table->string('lokasi_bdi/bpm')->nullable();
            $table->string('kode_kpp')->nullable();
            $table->string('nama_kpp')->nullable();
            $table->integer('anggota_laki-laki')->unsigned()->nullable();
            $table->integer('anggota_perempuan')->unsigned()->nullable();
            $table->integer('anggota_miskin')->unsigned()->nullable();
            $table->date('tanggal_pembentukan/revitalisasi')->nullable();
            $table->string('scan_dok_pembentukan/revitalisasi')->nullable();
            $table->string('struktur_organisasi')->nullable();
            $table->string('scan_struktur_organisasi')->nullable();
            $table->string('ad-art/sk')->nullable();
            $table->string('scan_ad-art/sk')->nullable();
            $table->string('rencana_kerja')->nullable();
            $table->string('scan_rencana_kerja')->nullable();
            $table->string('pertemuan_rutin')->nullable();
            $table->string('foto_pertemuan_rutin')->nullable();
            $table->string('buku_inventaris_kegiatan')->nullable();
            $table->string('scan_buku_inventaris_kegiatan')->nullable();
            $table->string('administrasi_rutin')->nullable();
            $table->string('scan_administrasi_rutin')->nullable();
            $table->string('sumber_dana_operasional')->nullable();
            $table->integer('nilai_bop')->unsigned()->nullable();
            $table->string('kegiatan_pengecekan')->nullable();
            $table->string('foto_kegiatan_pengecekan')->nullable();
            $table->string('kegiatan_perbaikan')->nullable();
            $table->string('sumber_dana_perbaikan')->nullable();
            $table->integer('nilai_perbaikan')->unsigned()->nullable();
            $table->string('keterangan_lain_lain')->nullable();
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
        Schema::dropIfExists('kppdatas');
    }
}
