<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\kppdata;
use App\allvillage;
use App\bkmdata;
use App\alldistrict;

class bukuInventarisKegiatanController extends Controller
{
	public function show($id){
        $kabupaten=alldistrict::get();
        $kppdata = kppdata::where('id', $id)->get();
        return view('kpp.view.buku_inventaris_kegiatan', compact(['kabupaten', 'kppdata']));
    }
    
    public function update(Request $request, $id)
    {
        $kppdata=kppdata::where('id', $id)->get()[0];

        kppdata::where('id', $id)->update([
            'buku_inventaris_kegiatan'=>$request->buku_inventaris_kegiatan,
        ]);


        if ($request->hasFile('scan_buku_inventaris_kegiatan')) {
            $extension = $request->scan_buku_inventaris_kegiatan->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . ' ' . 'scan_buku_inventaris_kegiatan' . '.' . $extension;

            kppdata::where('id', $id)->update([
                'scan_buku_inventaris_kegiatan' => $fileName
            ]);

            Storage::disk('public')->putFileAs('kpp', $request->scan_buku_inventaris_kegiatan, $fileName);

            return redirect ('/kpp/'.$id); 

        } else {

            return redirect ('/kpp/'.$id); 

        }
    }
}
