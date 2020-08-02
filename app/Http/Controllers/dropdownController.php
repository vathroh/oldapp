<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\allsubdistrict;
use App\allvillage;

class dropdownController extends Controller
{
    public function kecamatan(Request $request)
    {
        $kode_kab = $request->get('kode_kab');
        $kecamatan = allsubdistrict::where('kode_kab',  $kode_kab)->get(['kode_kec', 'nama_kec']);
        return response()->json($kecamatan);   
    }

    public function kelurahan(Request $request)
    {
        $kode_kec = $request->get('kode_kec');
        $kelurahan = allvillage::where('KD_KEC',  $kode_kec)->get(['KD_KEL', 'NAMA_DESA']);
        return response()->json($kelurahan);   
    }
}
