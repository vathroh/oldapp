<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\withHeadings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\kppdata;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return kppdata::select('allvillages.NAMA_KAB', 'allvillages.NAMA_KEC', 'allvillages.NAMA_DESA', 'bkmdatas.bkm', 
			'kppdatas.lokasi_bdi_bpm', 'kppdatas.nama_kpp',
			\DB::raw('
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
			'), 'pengurus_kpps.ketua_kpp', 'pengurus_kpps.ketua_kpp_hp', 'kppdatas.anggota_pria', 'kppdatas.anggota_wanita',
			'kppdatas.anggota_miskin', 'kppdatas.struktur_organisasi', 'kppdatas.anggaran_dasar', 'kppdatas.anggaran_rumah_tangga', 
			'kppdatas.surat_keputusan', 'kppdatas.rencana_kerja', 'kppdatas.pertemuan_rutin', 'kppdatas.administrasi_rutin', 
			'kppdatas.buku_inventaris_kegiatan', 'kppdatas.kegiatan_pengecekan')
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
				)))->get();
					
    }
    
    public function headings(): array
    {
        return [
            'KABUPATEN',
            'KECAMATAN',
            'KELURAHAN',
            'NAMA BKM',
            'TAHUN BDI/BPM'
        ];
    }
}
