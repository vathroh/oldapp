<?php

namespace App\Http\Controllers\kpp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\kppdata;
use App\allvillage;
use App\bkmdata;

class pengecekanFisikController extends Controller
{
    public function update(Request $request, $id)
    {
        $ldate = date('Y-m-d H:i:s');
        $kppdata=kppdata::where('id', $id)->get()[0];

        kppdata::where('id', $id)->update([
            'kegiatan_pengecekan'=>$request->pengecekan_fisik,
        ]);


        if ($request->hasFile('scan_administrasi_rutin')) {
            $extension = $request->foto_pengecekan_fisik->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . ' ' . 'foto_pengecekan_fisik' . ' ' . $ldate . '.' . $extension;

            kppdata::where('id', $id)->update([
                'foto_kegiatan_pengecekan' => $fileName
            ]);

            Storage::disk('local')->putFileAs('kpp', $request->foto_pengecekan_fisik, $fileName);

            return redirect ('/kpp/'.$id); 

        } else {
            
            return redirect ('/kpp/'.$id); 

        }
    }
}
