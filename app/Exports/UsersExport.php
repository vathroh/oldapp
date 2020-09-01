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
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "kegiatan_pengecekan" AND skor_kpp.criteria = kppdatas.kegiatan_pengecekan) = 2 THEN 2 ELSE 0 END
                    +
                    CASE WHEN (select count(*) from infrastruktures_maintenances) > 0 THEN 2 ELSE 0 END  
                    > 3, 2, 0)
                +
                IF(                    
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "administrasi_rutin" AND skor_kpp.criteria = kppdatas.administrasi_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "buku_inventaris_kegiatan" AND skor_kpp.criteria = kppdatas.buku_inventaris_kegiatan) = 2 THEN 2 ELSE 0 END
                    +
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "pertemuan_rutin" AND skor_kpp.criteria = kppdatas.pertemuan_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "bop" AND skor_kpp.criteria = kppdatas.bop) = 2 THEN 2 ELSE 0 END
                    = 8, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0
                )
                +
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 10  THEN "Mandiri" 

            WHEN
                IF(
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "administrasi_rutin" AND skor_kpp.criteria = kppdatas.administrasi_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "buku_inventaris_kegiatan" AND skor_kpp.criteria = kppdatas.buku_inventaris_kegiatan) = 2 THEN 2 ELSE 0 END
                    +
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "pertemuan_rutin" AND skor_kpp.criteria = kppdatas.pertemuan_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "bop" AND skor_kpp.criteria = kppdatas.bop) = 2 THEN 2 ELSE 0 END
                    = 8, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0
                )
                +
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 8  THEN "Berdaya" 
            WHEN
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0
                )
                +
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 6 THEN "Terbangun" 
            WHEN 
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 4 THEN "Awal" 
            WHEN 
                (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2
                THEN "Perlu Perhatian"
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
