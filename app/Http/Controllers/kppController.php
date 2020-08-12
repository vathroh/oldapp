<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\alldistrict;
use App\allsubdistrict;
use App\allvillage;
use App\kppdata;
use App\bkmdata;
use App\pengurus_kpp;
use App\User;

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
        $user=User::get();
        $kelurahan=allvillage::get();
        $kabupaten=alldistrict::get();
        $bkmdatas=bkmdata::get();
        if(Auth::user()->id==3){
            $kppdatas=kppdata::orderByDesc('updated_at')->paginate(10);
        }else{
            $kppdatas=kppdata::where('user_id', Auth::user()->id)->orderByDesc('updated_at')->paginate(10);
        }
        $pengurus_kpps=pengurus_kpp::get();
        
        return view('kpp.index', compact(['kabupaten' ,'kelurahan', 'kppdatas', 'user', 'bkmdatas', 'pengurus_kpps']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kppdata=kppdata::where('id', $id)->get()[0];
        $kelurahan=allvillage::where('KD_KEL', $kppdata->kode_desa)->get()[0];
        $bkmdata=bkmdata::where('kelurahan_id', $kppdata->kode_desa)->get()[0];
        $kabupaten=alldistrict::get();
        $pengurus_kpp=pengurus_kpp::where('kelurahan_id', $kppdata->kode_desa)->get()->first();

        return view('kpp.show', compact(['kppdata', 'kelurahan', 'bkmdata', 'kabupaten', 'pengurus_kpp']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kppdata=kppdata::find($id);
        $kelurahan=allvillage::where('KD_KEL', $kppdata->kode_desa)->get();
        $bkmdata=bkmdata::where('kelurahan_id', $kppdata->kode_desa)->get();
        $kabupaten=alldistrict::get();

        return view('kpp.edit', compact(['kppdata', 'bkmdata', 'kelurahan', 'kabupaten']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    public function storebackup(Request $request)
    {

        // dd($request->anggaran_dasar);

        kppdata::create([

            'kode_desa'=>$request->kelurahan,
            'lokasi_bdi/bpm'=>$request->lokasi_bdi,
            'nama_kpp'=>$request->nama_kpp,
            'anggota_pria'=>$request->anggota_pria,
            'anggota_wanita'=>$request->anggota_wanita,
            'anggota_miskin'=>$request->anggota_miskin,
            'struktur_organisasi'=>$request->struktur_organisasi,
        // 'scan_struktur_organisasi'=>$request->struktur_organisasi,
            'anggaran_dasar'=>$request->anggaran_dasar,
        // 'scan_anggaran_dasar'=>$request->scan_anggaran_dasar,
            'anggaran_rumah_tangga'=>$request->anggaran_rumah_tangga,
        // 'scan_anggaran_rumah_tangga'=>$request->scan_anggaran_rumah_tangga,
            'surat_keputusan'=>$request->surat_keputusan,
        // 'scan_surat_keputusan'=>$request->scan_surat_keputusan,
            'rencana_kerja'=>$request->rencana_kerja,
        // 'scan_rencana_kerja'=>$request->scan_rencana_kerja,
            'pertemuan_rutin'=>$request->pertemuan_rutin,
        // 'foto_pertemuan_rutin'=>$request->foto_pertemuan_rutin,
            'administrasi_rutin'=>$request->administrasi_rutin,
        // 'scan_administrasi_rutin'=>$request->scan_administrasi_rutin, 
            'buku_inventaris_kegiatan'=>$request->buku_inventaris_kegiatan,
        // 'scan_buku_inventaris_kegiatan'=>$request->scan_buku_inventaris_kegiatan,
            'bop'=>$request->biaya_operasional,
            'sumber_dana_operasional'=>$request->sumber_dana,
            'nilai_bop'=>$request->nilai_bop,        
            'kegiatan_pengecekan'=>$request->pengecekan_fisik,
            'foto_kegiatan_pengecekan'=>$request->foto_pengecekan_fisik,
            'tanggal_kegiatan_perbaikan'=>$request->tanggal_kegiatan_pemeliharaan_fisik,
            'sumber_dana_perbaikan'=>$request->sumber_dana_kegiatan_pemeliharaan_fisik,
            'nilai_perbaikan'=>$request->jumlah_dana_kegiatan_pemeliharaan_fisik,
            'keterangan_lain_lain'=>$request->keterangan_tambahan,
            'user_id' => Auth::user()->id
        ]);

        return redirect('/kpp');
    }
}
