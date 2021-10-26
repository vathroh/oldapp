<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\kppdata;
use App\allvillage;
use App\bkmdata;
use App\alldistrict;

class administrasiRutinController extends Controller
{
	public function show($id){
        $kabupaten=alldistrict::get();
        $kppdata = kppdata::where('id', $id)->get();
        return view('kpp.view.administrasi_rutin', compact(['kabupaten', 'kppdata']));
    }
    
    public function update(Request $request, $id)
    {
        $kppdata=kppdata::where('id', $id)->get()[0];

        $time = \Carbon\Carbon::now()->timestamp;

        kppdata::where('id', $id)->update([
            'administrasi_rutin'=>$request->administrasi_rutin,
        ]);


        if ($request->hasFile('scan_administrasi_rutin')) {


            $extension = $request->scan_administrasi_rutin->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . '_' . 'scan_administrasi_rutin' . $time . '.' . $extension;

            kppdata::where('id', $id)->update([
                'scan_administrasi_rutin' => $fileName
            ]);
            Storage::disk('public')->putFileAs('kpp', $request->scan_administrasi_rutin, $fileName);

            return redirect ('/kpp/'.$id); 

        } else {
                
            return redirect ('/kpp/'.$id); 

        }


    }
}
