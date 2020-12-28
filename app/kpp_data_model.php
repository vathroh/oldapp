<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kpp_data_model extends Model
{
    return kppdata::select("*", 'kppdatas.id', \DB::raw('
			CASE
			WHEN
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "kegiatan_pengecekan" AND skor_kpp.criteria = kppdatas.kegiatan_pengecekan) +
				CASE WHEN (select count(*) from infrastruktures_maintenances) > 0 THEN 1 ELSE 0 END  > 2
					 THEN "Mandiri"
			WHEN
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "administrasi_rutin" AND skor_kpp.criteria = kppdatas.administrasi_rutin) + 
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "buku_inventaris_kegiatan" AND skor_kpp.criteria = kppdatas.buku_inventaris_kegiatan) + 
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "pertemuan_rutin" AND skor_kpp.criteria = kppdatas.pertemuan_rutin) +
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "bop" AND skor_kpp.criteria = kppdatas.bop) = 8
					THEN "Berdaya"
			WHEN
            (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2
                THEN "Terbangun"
			WHEN 
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) + 
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) + 
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan) >= 2 
					THEN "Awal" 
			ELSE "Perlu Perhatian" 
			END As Status 
			'))
			->join('allvillages', 'kppdatas.kode_desa', '=', 'allvillages.KD_KEL')
            ->join('bkmdatas', 'kppdatas.kode_desa', '=', 'bkmdatas.kelurahan_id')
            ->join('pengurus_kpps', 'kppdatas.kode_desa', '=', 'pengurus_kpps.kelurahan_id')
            ->join('users', 'kppdatas.user_id', '=', 'users.id')
            ->whereIn('KD_KAB', explode(', ', str_replace(array('["',  '"]'),'', DB::table('work_zones')
            ->where('id', function($query){
                $query->select('work_zone_id')
                      ->from('job_descs')
                      ->where('user_id', Auth::user()->id)
                      ->get()
                      ->pluck('work_zone_id');
				})->get()
				->pluck('zone')
				)));
}
