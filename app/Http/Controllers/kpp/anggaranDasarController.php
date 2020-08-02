<?php

namespace App\Http\Controllers\kpp;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kppdata;

class anggaranDasarController extends Controller
{
    public function update(Request $request, $id)
    {
        $kppdata=kppdata::where('id', $id)->get()[0];
        
        kppdata::where('id', $id)->update([
            'anggaran_dasar'=>$request->anggaran_dasar,
        ]);


        if ($request->hasFile('scan_anggaran_dasar')) {

            $extension = $request->scan_anggaran_dasar->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . ' ' . 'scan_anggaran_dasar' . '.' . $extension;

            kppdata::where('id', $id)->update([
                'scan_anggaran_dasar' => $fileName
            ]);

            Storage::disk('local')->putFileAs('kpp', $request->scan_anggaran_dasar, $fileName);

            return redirect ('/kpp/'.$id); 

        } else {

            return redirect ('/kpp/'.$id); 

        }
    }
}
