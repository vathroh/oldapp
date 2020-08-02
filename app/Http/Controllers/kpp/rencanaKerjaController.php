<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\kppdata;
use App\allvillage;
use App\bkmdata;

class rencanaKerjaController extends Controller
{
    public function update(Request $request, $id)
    {
        $kppdata=kppdata::where('id', $id)->get()[0];

        kppdata::where('id', $id)->update([
            'rencana_kerja'=>$request->rencana_kerja,
        ]);


        if ($request->hasFile('scan_anggaran_rumah_tangga')) {
            $extension = $request->scan_rencana_kerja->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . ' ' . 'scan_rencana_kerja' . '.' . $extension;
            kppdata::where('id', $id)->update([
                'scan_rencana_kerja' => $fileName
            ]);
            Storage::disk('local')->putFileAs('kpp', $request->scan_rencana_kerja, $fileName);
            return redirect ('/kpp/'.$id); 

        } else {

            return redirect ('/kpp/'.$id); 

        }
    }
}
