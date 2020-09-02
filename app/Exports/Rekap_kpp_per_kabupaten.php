<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class Rekap_kpp_per_kabupaten implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('kpp_data_view')->groupBy('KD_KAB')->selectRaw('NAMA_KAB, count(*) as jml_kpp,
				SUM(CASE WHEN Status  = "Perlu Perhatian" Then 1 ELSE 0 END) as perlu_perhatian, 
				SUM(CASE WHEN Status  = "Awal" Then 1 ELSE 0 END) as awal, 
				SUM(CASE WHEN Status  = "Terbangun" Then 1 ELSE 0 END) as terbangun, 
				SUM(CASE WHEN Status  = "Berdaya" Then 1 ELSE 0 END) as berdaya, 
				SUM(CASE WHEN Status  = "Mandiri" Then 1 ELSE 0 END) as mandiri,
				SUM(anggota_pria) as jml_pria,
				SUM(anggota_wanita) as jml_wanita,
				SUM(anggota_miskin) as jml_miskin,
				SUM(CASE WHEN struktur_organisasi = "Ada" THEN 1 ELSE 0 END) as jml_struktur_organisasi,
				SUM(CASE WHEN anggaran_dasar = "Ada" THEN 1 ELSE 0 END) as jml_anggaran_dasar,
				SUM(CASE WHEN anggaran_rumah_tangga = "Ada" THEN 1 ELSE 0 END) as jml_anggaran_rumah_tangga,
				SUM(CASE WHEN surat_keputusan = "Ada" THEN 1 ELSE 0 END) as jml_surat_keputusan,
                SUM(CASE WHEN rencana_kerja = "Ada" THEN 1 ELSE 0 END) as jml_rencana_kerja,
				SUM(CASE WHEN pertemuan_rutin = "Setiap Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_bulan,
                SUM(CASE WHEN pertemuan_rutin = "Setiap Tiga Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_tiga_bulan,
			    SUM(CASE WHEN pertemuan_rutin = "Setiap Enam Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_enam_bulan,
				SUM(CASE WHEN pertemuan_rutin = "Insidentil (sesuai kebutuhan)" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_insidentil,
                count(*) - SUM(CASE WHEN pertemuan_rutin = "Setiap Bulan" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN pertemuan_rutin = "Setiap Tiga Bulan" THEN 1 ELSE 0 END) -
			    SUM(CASE WHEN pertemuan_rutin = "Setiap Enam Bulan" THEN 1 ELSE 0 END) -
				SUM(CASE WHEN pertemuan_rutin = "Insidentil (sesuai kebutuhan)" THEN 1 ELSE 0 END) jml_pertemuan_rutin_tidak_pernah,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 ELSE 0 END) as jml_administrasi_bulanan_lengkap,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 ELSE 0 END) as jml_administrasi_bulanan_minimalis,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END) as jml_administrasi_triwulan,
                count(*) - SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END) as jml_administrasi_tidak_ada,
                SUM(CASE WHEN buku_inventaris_kegiatan = "Ada" THEN 1 ELSE 0 END) as jml_buku_inventaris_kegiatan,
                SUM(CASE WHEN bop = "Ada" THEN 1 ELSE 0 END) as jml_bop,
                SUM(jumlah_bop) as jml_dana_bop,
                count(*) - SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) -
 				SUM(CASE WHEN kegiatan_pengecekan = "sudah_dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_pernah,
                SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_dilakukan,
                SUM(CASE WHEN kegiatan_pengecekan = "sudah_dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_sudah_dilakukan,
                SUM(jumlah_kegiatan_perbaikan) as jml_kegiatan_perbaikan,
                SUM(jumlah_dana_perbaikan) as jml_dana_perbaikan
		')->get();
    
    }
}
