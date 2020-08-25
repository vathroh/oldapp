<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
        $kabupaten=alldistrict::get();
        $kppdatas = $this->kppdata()->paginate(10);

        return view('kpp.index', compact(['kabupaten', 'kppdatas']));
    }


    public function create(Request $request)
    {
        $kelurahan=allvillage::get();
        $kabupaten=alldistrict::get();
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
		$kabupaten=alldistrict::get();
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
        $kabupaten=alldistrict::get();

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

    public function coba1()
    {
/*        return $this->kppdata()
                    ->select('struktur_organisasi', 
                         \DB::raw("(CASE
                         WHEN kppdatas.anggaran_dasar + kppdatas.anggaran_rumah_tangga + kppdatas.surat_keputusan >= 1 THEN 'Awal'
                         WHEN kppdatas.rencana_kerja = 1 THEN 'Terbangun'
                         WHEN kppdatas.pertemuan_rutin +  kppdatas.administrasi_rutin + kppdatas.buku_inventaris_kegiatan + kppdatas.bop = 4 THEN 'Berdaya'
                         WHEN kppdatas.anggaran_dasar + kppdatas.anggaran_rumah_tangga + kppdatas.surat_keputusan >= 1 THEN 'Awal'                         
                         WHEN kppdatas.anggaran_dasar + kppdatas.anggaran_rumah_tangga + kppdatas.surat_keputusan >= 1 THEN 'Awal'                        
                         ELSE 'Perlu Perhatian' 
                         END) As Status"
                         ))->get();
 */
return \DB::raw("SELECT id, (SELECT scor FROM skor_kpp WHERE items = 'anggaran_rumah_tangga' AND criteria = anggaran_rumah_tangga) as SKOR FROM `kppdatas`");
    
    }

}
