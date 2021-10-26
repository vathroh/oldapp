<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\kppdata;
use App\allvillage;
use App\bkmdata;
use App\alldistrict;

class rencanaKerjaController extends Controller
{
	public function show($id){
        $kabupaten=alldistrict::get();
        $kppdata = kppdata::where('id', $id)->get();
        return view('kpp.view.rencana_kerja', compact(['kabupaten', 'kppdata']));
    }
    
    public function update(Request $request, $id)
    {
        $kppdata=kppdata::where('id', $id)->get()[0];

        kppdata::where('id', $id)->update([
            'rencana_kerja'=>$request->rencana_kerja,
        ]);

        $time = \Carbon\Carbon::now()->timestamp;

        if ($request->hasFile('scan_rencana_kerja')) {
            $extension = $request->scan_rencana_kerja->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . ' ' . 'scan_rencana_kerja' . $time . '.' . $extension;
            kppdata::where('id', $id)->update([
                'scan_rencana_kerja' => $fileName
            ]);
            Storage::disk('public')->putFileAs('kpp', $request->scan_rencana_kerja, $fileName);
            return redirect ('/kpp/'.$id); 

        } else {

            return redirect ('/kpp/'.$id); 

        }
    }
}
