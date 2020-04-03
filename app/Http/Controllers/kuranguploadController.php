<?php

namespace App\Http\Controllers;

use App\Document;
use App\kabupaten;
use App\kegiatanksm;
use App\ksm;
use App\tahun;
use App\village;
use Illuminate\Http\Request;

class kuranguploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = tahun::all();
        $kabupaten = kabupaten::all();
        return view('kurangupload.index', compact(['tahun', 'kabupaten']));
    }
    public function perkegiatan(Request $request)
    {
        $documents = Document::where('kode_kab', $request->kabupaten)->get();
        $kegiatan = kegiatanksm::where('KD_KAB', $request->kabupaten)->get();
        $jmlkegiatan = $kegiatan->count();

        for ($i = 0; $i < $jmlkegiatan; $i++) {
            $kode_keg = $kegiatan[$i]['KD_KEGIATAN'];
            $kode_kab = $kegiatan[$i]['KD_KAB'];
            $kab = village::where('KD_KAB', $kode_kab)->get()[0]['NAMA_KAB'];
            $kel = village::where('KD_KAB', $kode_kab)->get()[0]['NAMA_DESA'];
            $kd_ksm = kegiatanksm::where('KD_KEGIATAN', $kode_keg)->get()[0]['KD_KSM'];
            $ksm = ksm::where('KD_KSM', $kd_ksm)->get()[0]['NAMA_KSM'];
            $foto0 = Document::where('kode_kegiatan', $kode_keg)->where('jenis_dokumen', 'FOTO 0%')->count();
            $foto25 = Document::where('kode_kegiatan', $kode_keg)->where('jenis_dokumen', 'FOTO 25%')->count();
            $foto50 = Document::where('kode_kegiatan', $kode_keg)->where('jenis_dokumen', 'FOTO 50%')->count();
            $foto75 = Document::where('kode_kegiatan', $kode_keg)->where('jenis_dokumen', 'FOTO 75%')->count();
            $foto100 = Document::where('kode_kegiatan', $kode_keg)->where('jenis_dokumen', 'FOTO 100%')->count();
            $kegiatan[$i]['NAMA_KAB'] = $kab;
            $kegiatan[$i]['NAMA_DESA'] = $kel;
            $kegiatan[$i]['KSM'] = $ksm;
            $kegiatan[$i]['FOTO_0'] = $foto0;
            $kegiatan[$i]['FOTO_25'] = $foto25;
            $kegiatan[$i]['FOTO_50'] = $foto50;
            $kegiatan[$i]['FOTO_75'] = $foto75;
            $kegiatan[$i]['FOTO_100'] = $foto100;
        }

        return view('kurangupload.kegiatan', compact(['kegiatan', 'documents']));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
