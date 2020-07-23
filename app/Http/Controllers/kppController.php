<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\kabupaten;
use App\kppdata;

class kppController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kabupaten=kabupaten::get();
        return view('kpp.input', compact('kabupaten'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kabupaten=kabupaten::get();
        return view('kpp.input', compact('kabupaten'));
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
            'lokasi_bdi/bpm'=>$request->lokasi_bdi,
            'kode_kpp'=>$request->kode_kpp,
            'nama_kpp'=>$request->nama_kpp,
            'anggota_laki-laki'=>$request->anggota_laki-laki,
            'anggota_perempuan'=>$request->anggota_perempuan,
            'anggota_miskin'=>$request->anggota_miskin,
            'tanggal_pembentukan/revitalisasi'=>$request->tanggal_pembentukan/revitalisasi,


            'scan_dok_pembentukan/revitalisasi'=>$request->dok_pembentukan/revitalisasi,
            'struktur_organisasi'=>$request->struktur_organisasi,
            'scan_struktur_organisasi'=>$struktur_organisasi,
            'ad-art/sk'=>$request->scan_ad-art/sk,
            'scan_ad-art/sk'=>$request->scan_ad-art/sk,


            
            'rencana_kerja'=>$request->rencana_kerja,
            
            'scan_rencana_kerja'=>$request->kelurahan,
            'pertemuan_rutin'=>$request->kelurahan,
            'foto_pertemuan_rutin'=>$request->kelurahan,
            'buku_inventaris_kegiatan'=>$request->kelurahan,
            'scan_buku_inventaris_kegiatan'=>$request->kelurahan,
            'administrasi_rutin'=>$request->kelurahan,
            'scan_administrasi_rutin'=>$request->kelurahan,
            'sumber_dana_operasional'=>$request->kelurahan,
            'nilai_bop'=>$request->kelurahan,
            'kegiatan_pengecekan'=>$request->kelurahan,
            'foto_kegiatan_pengecekan'=>$request->kelurahan,
            'kegiatan_perbaikan'=>$request->kelurahan,
            'sumber_dana_perbaikan'=>$request->kelurahan,
            'nilai_perbaikan'=>$request->kelurahan,
            'keterangan_lain_lain'=>$request->kelurahan
            ]);
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
