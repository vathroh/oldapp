<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\kppdata;
use App\allvillage;
use App\bkmdata;

class pertemuanRutinController extends Controller
{
    public function update(Request $request, $id)
    {
        $ldate = date('Y-m-d H:i:s');
        $kppdata=kppdata::where('id', $id)->get()[0];

        kppdata::where('id', $id)->update([
            'pertemuan_rutin'=>$request->pertemuan_rutin,
        ]);


        if ($request->hasFile('scan_anggaran_rumah_tangga')) {
            $extension = $request->foto_pertemuan_rutin->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . ' ' . 'foto_pertemuan_rutin' . ' ' . $ldate . '.' . $extension;
            kppdata::where('id', $id)->update([
                'foto_pertemuan_rutin' => $fileName
            ]);
            Storage::disk('local')->putFileAs('kpp', $request->foto_pertemuan_rutin, $fileName);
            return redirect ('/kpp/'.$id); 

        } else {

            return redirect ('/kpp/'.$id); 

        }
    }
}
