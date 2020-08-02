<?php

namespace App\Http\Controllers\kpp;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kppdata;
use App\allvillage;
use App\bkmdata;

class strukturOrganisasiController extends Controller
{

    public function update(Request $request, $id)
    {
        $kppdata=kppdata::where('id', $id)->get()[0];

        kppdata::where('id', $id)->update([
            'struktur_organisasi'=>$request->struktur_organisasi,
        ]);


        if ($request->hasFile('scan_anggaran_rumah_tangga')) {
            $extension = $request->scan_struktur_organisasi->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . ' ' . 'Scan_Struktur_Organisasi' . '.' . $extension;
            kppdata::where('id', $id)->update([
                'scan_struktur_organisasi' => $fileName
            ]);
            Storage::disk('local')->putFileAs('kpp', $request->scan_struktur_organisasi, $fileName);
            return redirect ('/kpp/'.$id); 

        } else {

            return redirect ('/kpp/'.$id); 

        }
    }
}
