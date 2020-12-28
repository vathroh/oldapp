<?php

namespace App\Http\Controllers\kpp;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kppdata;
use App\allvillage;
use App\bkmdata;
use App\alldistrict;

class strukturOrganisasiController extends Controller
{
    public function show($id){
        $kabupaten=alldistrict::get();
        $kppdata = kppdata::where('id', $id)->get();
        return view('kpp.view.struktur_organisasi', compact(['kabupaten', 'kppdata']));
    }

    public function update(Request $request, $id)
    {
        $kppdata=kppdata::where('id', $id)->get()[0];

        kppdata::where('id', $id)->update([
            'struktur_organisasi'=>$request->struktur_organisasi,
        ]);


        if ($request->hasFile('scan_struktur_organisasi')) {
            $extension = $request->scan_struktur_organisasi->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . ' ' . 'Scan_Struktur_Organisasi' . '.' . $extension;
            kppdata::where('id', $id)->update([
                'scan_struktur_organisasi' => $fileName
            ]);
            Storage::disk('public')->putFileAs('kpp', $request->scan_struktur_organisasi, $fileName);
            return redirect ('/kpp/'.$id); 

        } else {

            return redirect ('/kpp/'.$id); 
        }
    }
}
