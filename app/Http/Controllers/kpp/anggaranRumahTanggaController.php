<?php

namespace App\Http\Controllers\kpp;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kppdata;
use App\alldistrict;

class anggaranRumahTanggaController extends Controller
{
    public function show($id){
        $kabupaten=alldistrict::get();
        $kppdata = kppdata::where('id', $id)->get();
        return view('kpp.view.anggaran_rumah_tangga', compact(['kabupaten', 'kppdata']));
    }

    public function update(Request $request, $id)
    {
    	
        $kppdata=kppdata::where('id', $id)->get()[0];

        kppdata::where('id', $id)->update([
            'anggaran_rumah_tangga'=>$request->anggaran_rumah_tangga,
        ]);


        if ($request->hasFile('scan_anggaran_rumah_tangga')) {

            $extension = $request->scan_anggaran_rumah_tangga->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . ' ' . 'scan_anggaran_rumah_tangga' . '.' . $extension;

            kppdata::where('id', $id)->update([
            'scan_anggaran_rumah_tangga' => $fileName
            ]);

            Storage::disk('public')->putFileAs('kpp', $request->scan_anggaran_rumah_tangga, $fileName);

            return redirect ('/kpp/'.$id); 

        } else {

            return redirect ('/kpp/'.$id); 

        }

    }
}
