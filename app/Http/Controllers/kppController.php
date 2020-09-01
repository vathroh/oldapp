<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\infrastruktures_maintenance;
use App\alldistrict;
use App\allsubdistrict;
use App\allvillage;
use App\kppdata;
use App\bkmdata;
use App\pengurus_kpp;
use App\User;
use App\kpp_pertemuan;
use App\kpp_operating_fund;
use App\data_pengecekan_fisik;
use App\kpp_data_model;
use Gate;

class kppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return $this->coba2()->get();
        $kppdatas = $this->coba2()->paginate(10);
        
        $kabupaten=alldistrict::whereIn('kode_kab', explode(', ', str_replace(array('["',  '"]'),'', DB::table('work_zones')
            ->where('id', function($query){
                $query->select('work_zone_id')
                      ->from('job_descs')
                      ->where('user_id', Auth::user()->id)
                      ->get()
                      ->pluck('work_zone_id');
            })->get()
              ->pluck('zone')            
            )))->get();
              
              
        //return $kabupaten;
//        $kppdatas = $this->kppdata()->paginate(10);

        return view('kpp.index', compact(['kabupaten', 'kppdatas']));
    }


    public function create(Request $request)
    {
        $kelurahan=allvillage::get();
        $kabupaten=alldistrict::whereIn('kode_kab', explode(', ', str_replace(array('["',  '"]'),'', DB::table('work_zones')
            ->where('id', function($query){
                $query->select('work_zone_id')
                      ->from('job_descs')
                      ->where('user_id', Auth::user()->id)
                      ->get()
                      ->pluck('work_zone_id');
            })->get()
              ->pluck('zone')            
        )))->get();
        $kppdatas=kppdata::get();
        $bkmdatas=bkmdata::get();
        $user=User::get();
        
        if (kppdata::where('kode_desa', $request->kelurahan)->doesntExist()) {
            return view('kpp.create', compact(['request', 'bkmdatas', 'kelurahan', 'kabupaten']));
        } else {
            $id=kppdata::where('kode_desa', $request->kelurahan)->get()[0]['id'];
            return redirect('/kpp/'.$id);
        }
    }


    public function store(Request $request)
    {
        kppdata::create([
            'kode_desa'=>$request->kelurahan,
            'lokasi_bdi_bpm'=>$request->lokasi_bdi,
            'nama_kpp'=>$request->nama_kpp,
            'anggota_pria'=>$request->anggota_pria,
            'anggota_wanita'=>$request->anggota_wanita,
            'anggota_miskin'=>$request->anggota_miskin,
            'user_id' => Auth::user()->id
        ]);

        pengurus_kpp::create([
            'kelurahan_id'=>$request->kelurahan,
        ]);

        $id=kppdata::where('kode_desa', $request->kelurahan)->get()[0]['id'];
        return redirect('/kpp/'.$id);
    }


    public function show($id)
    {
		if (Gate::denies('input-data')) {
            return redirect(route('kpp.index'));
        }

        
		$kabupaten=alldistrict::whereIn('kode_kab', explode(', ', str_replace(array('["',  '"]'),'', DB::table('work_zones')
            ->where('id', function($query){
                $query->select('work_zone_id')
                      ->from('job_descs')
                      ->where('user_id', Auth::user()->id)
                      ->get()
                      ->pluck('work_zone_id');
            })->get()
              ->pluck('zone')            
        )))->get();
        
        $kppdata=kppdata::where('id', $id)->get()[0];
        $kelurahan=allvillage::where('KD_KEL', $kppdata->kode_desa)->get()[0];
        $bkmdata=bkmdata::where('kelurahan_id', $kppdata->kode_desa)->get()[0];
        $kpp_pertemuans=kpp_pertemuan::where('kelurahan_id', $kppdata->kode_desa)->get();
        $pengurus_kpp=pengurus_kpp::where('kelurahan_id', $kppdata->kode_desa)->get()->first();        
        $kpp_operating_funds=kpp_operating_fund::where('kelurahan_id', $kppdata->kode_desa)->get();
        $data_pengecekan_fisiks=data_pengecekan_fisik::where('kelurahan_id', $kppdata->kode_desa)->get();
        $infrastruktures_maintenances = infrastruktures_maintenance::where('kelurahan_id', $kppdata->kode_desa)->get();
        $user=User::get();
        
        $jumlah = DB::table('kpp_operating_funds')->select(DB::raw('SUM(jumlah) as jumlah'))->get();

        return view('kpp.show', compact(['kppdata', 'kelurahan', 'bkmdata', 'kabupaten', 'pengurus_kpp', 'kpp_pertemuans', 'kpp_operating_funds', 'user', 'data_pengecekan_fisiks', 'infrastruktures_maintenances', 'jumlah']));
    }


    public function edit($id)
    {
        $kppdata=kppdata::find($id);
        $kelurahan=allvillage::where('KD_KEL', $kppdata->kode_desa)->get();
        $bkmdata=bkmdata::where('kelurahan_id', $kppdata->kode_desa)->get();
        $kabupaten=alldistrict::whereIn('kode_kab', explode(', ', str_replace(array('["',  '"]'),'', DB::table('work_zones')
            ->where('id', function($query){
                $query->select('work_zone_id')
                      ->from('job_descs')
                      ->where('user_id', Auth::user()->id)
                      ->get()
                      ->pluck('work_zone_id');
            })->get()
              ->pluck('zone')            
        )))->get();
        return view('kpp.edit', compact(['kppdata', 'bkmdata', 'kelurahan', 'kabupaten']));
    }

    
    public function update(Request $request, $id)
    {
        kppdata::where('id', $id)->update([
            'lokasi_bdi_bpm'=>$request->lokasi_bdi,
            'nama_kpp'=>$request->nama_kpp,
            'anggota_pria'=>$request->anggota_pria,
            'anggota_wanita'=>$request->anggota_wanita,
            'anggota_miskin'=>$request->anggota_miskin,
        ]);

        return redirect ('/kpp/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function export()
    {
		return Excel::download(new UsersExport, 'Data_KPP.xlsx');
	}
	
	public function rekap_all()
	{
		
		$kppdatas = $this->rekap()->groupBy('KD_KAB')->get();
		
		$kabupaten=alldistrict::whereIn('kode_kab', explode(', ', str_replace(array('["',  '"]'),'', DB::table('work_zones')
            ->where('id', function($query){
                $query->select('work_zone_id')
                      ->from('job_descs')
                      ->where('user_id', Auth::user()->id)
                      ->get()
                      ->pluck('work_zone_id');
            })->get()
              ->pluck('zone')            
            )))->get();
              

        return view('kpp.rekap.kabupaten', compact(['kabupaten', 'kppdatas']));
	}
	
	public function rekap_kecamatan($KD_KAB)
	{
		
		$kppdatas = $this->rekap()->groupBy('KD_KEC')->where('KD_KAB', $KD_KAB)->get();
		
		$kabupaten=alldistrict::whereIn('kode_kab', explode(', ', str_replace(array('["',  '"]'),'', DB::table('work_zones')
            ->where('id', function($query){
                $query->select('work_zone_id')
                      ->from('job_descs')
                      ->where('user_id', Auth::user()->id)
                      ->get()
                      ->pluck('work_zone_id');
            })->get()
              ->pluck('zone')            
            )))->get();
              

        return view('kpp.rekap.kecamatan', compact(['kabupaten', 'kppdatas']));
	}
	
	public function rekap_kelurahan($KD_KEC)
	{
		
		$kppdatas = $this->rekap()->groupBy('KD_KEL')->where('KD_KEC', $KD_KEC)->get();
		
		$kabupaten=alldistrict::whereIn('kode_kab', explode(', ', str_replace(array('["',  '"]'),'', DB::table('work_zones')
            ->where('id', function($query){
                $query->select('work_zone_id')
                      ->from('job_descs')
                      ->where('user_id', Auth::user()->id)
                      ->get()
                      ->pluck('work_zone_id');
            })->get()
              ->pluck('zone')            
            )))->get();
              

        return view('kpp.rekap.kelurahan', compact(['kabupaten', 'kppdatas']));
	}
	
    public function rekap()
	{
			return DB::table('kpp_data_view')->selectRaw('*, count(*) as jml_kpp,
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
		');
    
    }

		
	
	
	
	
	
	
	
	
    
// ====================================== custom function ===============================================================

    public function kppdata()
    {
    return  kppdata::join('allvillages', 'kppdatas.kode_desa', '=', 'allvillages.KD_KEL')
            ->join('bkmdatas', 'kppdatas.kode_desa', '=', 'bkmdatas.kelurahan_id')
            ->join('pengurus_kpps', 'kppdatas.kode_desa', '=', 'pengurus_kpps.kelurahan_id')
            ->join('users', 'kppdatas.user_id', '=', 'users.id')
            ->select('kppdatas.id', 'allvillages.KD_KAB', 'allvillages.NAMA_KAB', 'allvillages.NAMA_KEC', 'allvillages.KD_KEL', 'allvillages.NAMA_DESA',
                'kppdatas.lokasi_bdi_bpm', 'kppdatas.nama_kpp', 'kppdatas.anggota_pria', 'kppdatas.anggota_wanita', 'kppdatas.anggota_miskin', 
                'kppdatas.struktur_organisasi', 'kppdatas.scan_struktur_organisasi', 'kppdatas.anggaran_dasar', 'kppdatas.scan_anggaran_dasar', 
                'kppdatas.anggaran_rumah_tangga', 'kppdatas.scan_anggaran_rumah_tangga', 'kppdatas.surat_keputusan', 'kppdatas.scan_surat_keputusan', 
                'kppdatas.rencana_kerja', 'kppdatas.scan_rencana_kerja', 'kppdatas.pertemuan_rutin', 'kppdatas.administrasi_rutin', 
                'kppdatas.scan_administrasi_rutin', 'kppdatas.buku_inventaris_kegiatan', 'kppdatas.scan_buku_inventaris_kegiatan', 'kppdatas.kegiatan_pengecekan',
                'kppdatas.keterangan_lain_lain', 'users.name',
                'bkmdatas.bkm', 'pengurus_kpps.ketua_kpp', 'pengurus_kpps.ketua_kpp_hp'
                )
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

    public function coba()
    {
        return DB::select('select *,
         CASE WHEN 
            (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) + 
            (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) + 
            (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan) >= 2 
                THEN 1 ELSE 0 END As Awal,
         CASE WHEN
            (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2
                THEN 1 ELSE 0 END As Terbangun,
         CASE WHEN
            (select skor_kpp.scor from skor_kpp where skor_kpp.items = "administrasi_rutin" AND skor_kpp.criteria = kppdatas.administrasi_rutin) + 
            (select skor_kpp.scor from skor_kpp where skor_kpp.items = "buku_inventaris_kegiatan" AND skor_kpp.criteria = kppdatas.buku_inventaris_kegiatan) + 
            (select skor_kpp.scor from skor_kpp where skor_kpp.items = "pertemuan_rutin" AND skor_kpp.criteria = kppdatas.pertemuan_rutin) +
            (select skor_kpp.scor from skor_kpp where skor_kpp.items = "bop" AND skor_kpp.criteria = kppdatas.bop) = 8
                THEN 1 ELSE 0 END As Berdaya,
         CASE WHEN
            (select skor_kpp.scor from skor_kpp where skor_kpp.items = "kegiatan_pengecekan" AND skor_kpp.criteria = kppdatas.kegiatan_pengecekan) +
            CASE WHEN (select count(*) from infrastruktures_maintenances) > 0 THEN 1 ELSE 0 END  > 2
                 THEN 1 ELSE 0 END As Mandiri
        from kppdatas
        JOIN bkmdatas ON kppdatas.kode_desa = bkmdatas.kelurahan_id
        JOIN allvillages ON kppdatas.kode_desa = allvillages.KD_KEL
        JOIN pengurus_kpps ON kppdatas.kode_desa = pengurus_kpps.kelurahan_id
        JOIN users ON kppdatas.user_id = users.id');

    }

    public function coba1()
    {
        return kppdata::select("*", 'kppdatas.id', \DB::raw('
			CASE WHEN 
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) + 
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) + 
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan) > 1 
					THEN 1 ELSE 0 END As Awal,  
			CASE WHEN
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2
					THEN 1 ELSE 0 END As Terbangun,
			 CASE WHEN
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "administrasi_rutin" AND skor_kpp.criteria = kppdatas.administrasi_rutin) + 
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "buku_inventaris_kegiatan" AND skor_kpp.criteria = kppdatas.buku_inventaris_kegiatan) + 
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "pertemuan_rutin" AND skor_kpp.criteria = kppdatas.pertemuan_rutin) +
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "bop" AND skor_kpp.criteria = kppdatas.bop) = 8
					THEN 1 ELSE 0 END As Berdaya,
			CASE WHEN
				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "kegiatan_pengecekan" AND skor_kpp.criteria = kppdatas.kegiatan_pengecekan) +
				CASE WHEN (select count(*) from infrastruktures_maintenances) > 0 THEN 1 ELSE 0 END  > 2
					 THEN 1 ELSE 0 
			END As Mandiri'))
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
    
    public function coba2()
    {
        return kppdata::select("*", 'kppdatas.id', \DB::raw('
			CASE
            WHEN
                IF(
			    	(select skor_kpp.scor from skor_kpp where skor_kpp.items = "kegiatan_pengecekan" AND skor_kpp.criteria = kppdatas.kegiatan_pengecekan) +
                    CASE WHEN (select count(*) from infrastruktures_maintenances) > 0 THEN 2 ELSE 0 END  > 3, 2, 0)
                +
                IF(
    				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "administrasi_rutin" AND skor_kpp.criteria = kppdatas.administrasi_rutin) + 
	    			(select skor_kpp.scor from skor_kpp where skor_kpp.items = "buku_inventaris_kegiatan" AND skor_kpp.criteria = kppdatas.buku_inventaris_kegiatan) + 
		    		(select skor_kpp.scor from skor_kpp where skor_kpp.items = "pertemuan_rutin" AND skor_kpp.criteria = kppdatas.pertemuan_rutin) +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "bop" AND skor_kpp.criteria = kppdatas.bop) = 8, 2, 0)
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0)
                +
                IF(
		    		(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) + 
	    			(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) + 
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan) >= 2, 2, 0)
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0)
                    = 10

					     THEN "Mandiri"
            WHEN
                IF(
    				(select skor_kpp.scor from skor_kpp where skor_kpp.items = "administrasi_rutin" AND skor_kpp.criteria = kppdatas.administrasi_rutin) + 
	    			(select skor_kpp.scor from skor_kpp where skor_kpp.items = "buku_inventaris_kegiatan" AND skor_kpp.criteria = kppdatas.buku_inventaris_kegiatan) + 
		    		(select skor_kpp.scor from skor_kpp where skor_kpp.items = "pertemuan_rutin" AND skor_kpp.criteria = kppdatas.pertemuan_rutin) +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "bop" AND skor_kpp.criteria = kppdatas.bop) = 8, 2, 0)
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0)
                +
                IF(
		    		(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) + 
	    			(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) + 
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan) >= 2, 2, 0)
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0)
                    = 8 

				    	THEN "Berdaya"
            WHEN
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0)
                +
                IF(
		    		(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) + 
	    			(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) + 
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan) >= 2, 2, 0)
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0)
                    = 6            
                THEN "Terbangun"
            WHEN 
                IF( 
		    		(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) + 
	    			(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) + 
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan) > 1, 2, 0)
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0)
                    = 4                
                        THEN "Awal" 
            WHEN 
                (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2
                THEN "Perlu Perhatian"
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

    public function coba3()
    {
        return kppdata::select("*", 'kppdatas.id', \DB::raw('
			CASE
            WHEN 
                (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2
                THEN "Perlu Perhatian"
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

    public function test()
    {
        return $this->coba3()->get();
    }

    public function backup()
    {
	return $kppdatas = DB::table('kpp_data_view')->groupBy('KD_KAB')->selectRaw('*, count(*) as jml_kpp,
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
                SUM(CASE WHEN buku_inventaris_kegiatan = "Ada" THEN 1 ELSE 0 END) as jml_buku_inventaris_kegiatan,
                SUM(CASE WHEN bop = "Ada" THEN 1 ELSE 0 END) as jml_bop,
                count(*) - SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) -
 				SUM(CASE WHEN kegiatan_pengecekan = "sudah_dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_pernah,
                SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_dilakukan,
				SUM(CASE WHEN kegiatan_pengecekan = "sudah_dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_sudah_dilakukan
		')->get();

        $kabupaten=alldistrict::whereIn('kode_kab', explode(', ', str_replace(array('["',  '"]'),'', DB::table('work_zones')
            ->where('id', function($query){
                $query->select('work_zone_id')
                      ->from('job_descs')
                      ->where('user_id', Auth::user()->id)
                      ->get()
                      ->pluck('work_zone_id');
            })->get()
              ->pluck('zone')            
            )))->get();
              

        return view('kpp.rekap', compact(['kabupaten', 'kppdatas']));


    }

}
