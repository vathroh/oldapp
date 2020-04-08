<?php

namespace App\Http\Controllers;

use App\village;
use Illuminate\Http\Request;
use App\kabupaten;
use App\ksm;
use App\jenisDokumen;
use App\kegiatanksm;
use App\isidok;


class VillagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $kabupaten = village::all();
        // return view('document.folder')->with('kabupaten', $kabupaten);
        $kabupaten = kabupaten::all();
        $villages = village::all();
        $ksm = ksm::all();
        // $desa = village::where('NAMA_KAB', 'KENDAL')->get('NAMA_DESA');
        // $desa = village::where('NAMA_KAB', 'KENDAL')->get('NAMA_DESA');
        // $hitung = count($desa);
        // return $hitung;


        return view('document.folder', compact(['kabupaten', 'villages']));
    }

    public function kab(Request $request)
    {
        $kabupaten = kabupaten::all();
        $villages = village::all();
        $kode_kab = $request->get('kode_kab');
        $desa = village::where('KD_KAB',  $kode_kab)->get(['NAMA_DESA', 'KD_KEL']);
        return response()->json($desa);
    }

    public function ksm_kab(Request $request)
    {
        $kabupaten = kabupaten::all();
        $villages = village::all();
        $kode_kab = $request->get('kode_kab');
        $desa = village::where('KD_KAB',  $kode_kab)->get(['NAMA_DESA', 'KD_KEL']);

        return response()->json($desa);
    }

    public function ksm_ksm(Request $request)
    {
        $kabupaten = kabupaten::all();
        $villages = village::all();
        $ksm = ksm::all();
        $kode_kel = $request->get('kode_kel');
        $ksm = ksm::where('KD_KEL',  $kode_kel)->get(['NAMA_KSM', 'KD_KSM']);
        return response()->json($ksm);
    }

    public function foto_ksm(Request $request)
    {

        $kode_kel = $request->get('foto_kelurahan');
        $ksm = ksm::where('KD_KEL',  $kode_kel)->get(['KD_KSM', 'NAMA_KSM']);
        return response()->json($ksm);
    }
    public function fotokegiatan(Request $request)
    {

        $kode_ksm = $request->get('foto_ksm');
        $ksm = kegiatanksm::where('KD_KSM',  $kode_ksm)->get(['KD_KEGIATAN', 'KEGIATAN', 'RTRW']);
        return response()->json($ksm);
    }

    public function jenisDokumen(Request $request)
    {

        // $ksm = jenisDokumen::all();
        $kode_kel = $request->get('jenisDokumen_ksm');
        $ksm = isidok::where('parent',  $kode_kel)->get('JenisDokumen');
        return response()->json($ksm);
    }

    public function fotokab(Request $request)
    {

        $kode_kab = $request->get('foto_kabupaten');
        $desa = village::where('KD_KAB',  $kode_kab)->get(['NAMA_DESA', 'KD_KEL']);;
        return response()->json($desa);
    }

    public function foto(Request $request)
    {
        $kode_kel = $request->get('jenisDokumen_ksm');
        $ksm = jenisDokumen::where('parent',  $kode_kel)->get('JenisDokumen');
        return response()->json($ksm);
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
     * @param  \App\village  $village
     * @return \Illuminate\Http\Response
     */
    public function show(village $village)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\village  $village
     * @return \Illuminate\Http\Response
     */
    public function edit(village $village)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\village  $village
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, village $village)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\village  $village
     * @return \Illuminate\Http\Response
     */
    public function destroy(village $village)
    {
        //
    }
}
