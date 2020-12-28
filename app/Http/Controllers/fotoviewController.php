<?php

namespace App\Http\Controllers;

use App\Document;
use App\kegiatanksm;
use App\ksm;
use Illuminate\Http\Request;



class fotoviewController extends Controller
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
        return view('fotoviews.kegiatan');
    }

    public function kegiatan($kdkegiatan)
    {
        $documents = Document::where('kode_kegiatan', $kdkegiatan)->paginate(9);
        $kegiatan = kegiatanksm::where('KD_KEGIATAN', $kdkegiatan)->get();
        $kodeksm = $kegiatan[0]['KD_KSM'];
        $ksm = ksm::where('KD_KSM', $kodeksm)->get();

        return view('fotoviews.kegiatan', compact(['documents', 'kegiatan', 'ksm']));
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
