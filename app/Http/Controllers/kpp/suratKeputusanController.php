<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\kppdata;
use App\allvillage;
use App\bkmdata;

class suratKeputusanController extends Controller
{
	public function update(Request $request, $id)
    {
        $kppdata=kppdata::where('id', $id)->get()[0];

        kppdata::where('id', $id)->update([
            'surat_keputusan'=>$request->surat_keputusan,
        ]);


        if ($request->hasFile('scan_anggaran_rumah_tangga')) {
            $extension = $request->scan_surat_keputusan->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . ' ' . 'scan_surat_keputusan' . '.' . $extension;
            kppdata::where('id', $id)->update([
                'scan_surat_keputusan' => $fileName
            ]);
            Storage::disk('local')->putFileAs('kpp', $request->scan_surat_keputusan, $fileName);
            return redirect ('/kpp/'.$id); 

        } else {

            return redirect ('/kpp/'.$id); 

        }
    }
}
