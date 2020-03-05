<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomFunctions\Rekap;
use App\Document;
use App\kabupaten;
use App\kegiatanksm;
use App\village;
use App\ksm;

class RekapController extends Controller
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
        $documents = Document::All();
        $kabupaten = kabupaten::all();
        $kelurahan = village::all();
        $ksm = ksm::all();
        return view('rekap.index', compact(['documents', 'kabupaten', 'kelurahan', 'ksm']));
        // $itung = new Rekap;
        // echo $itung->RekapKegiatan();
    }

    public function rekapKab()
    {
        $documents = Document::All();
        $kabupaten = kabupaten::all();
        return view('rekap.kabupaten', compact(['documents', 'kabupaten']));
        // $itung = new Rekap;
        // echo $itung->RekapKegiatan();
    }

    public function rekapKel($kab)
    {
        $documents = Document::All();
        $kabupaten = kabupaten::all();
        $kelurahan = village::where('KD_KAB', $kab)->get();
        return view('rekap.kelurahan', compact(['documents', 'kabupaten', 'kelurahan']));
        // $itung = new Rekap;
        // echo $itung->RekapKegiatan();
    }

    public function rekapKSM($kel)
    {
        $documents = Document::All();
        $kabupaten = kabupaten::all();
        $kelurahan = village::all();
        $ksm = ksm::where('KD_KEL', $kel)->get();
        return view('rekap.ksm', compact(['documents', 'kabupaten', 'kelurahan', 'ksm']));
        // $itung = new Rekap;
        // echo $itung->RekapKegiatan();
    }

    public function rekapKegiatan($ksm)
    {
        $documents = Document::All();
        $kabupaten = kabupaten::all();
        $kelurahan = village::all();
        $ksm_ = ksm::all();
        $kegiatan = kegiatanksm::where('KD_KSM', $ksm)->get();
        return view('rekap.kegiatan', compact(['documents', 'kabupaten', 'kelurahan', 'ksm_', 'kegiatan']));
        // $itung = new Rekap;
        // echo $itung->RekapKegiatan();
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
