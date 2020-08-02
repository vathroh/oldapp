<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\kppdata;
use App\allvillage;
use App\bkmdata;

class bukuInventarisKegiatanController extends Controller
{
    public function update(Request $request, $id)
    {
        $kppdata=kppdata::where('id', $id)->get()[0];

        kppdata::where('id', $id)->update([
            'buku_inventaris_kegiatan'=>$request->buku_inventaris_kegiatan,
        ]);


        if ($request->hasFile('scan_administrasi_rutin')) {
            $extension = $request->scan_buku_inventaris_kegiatan->getClientOriginalExtension();
            $fileName=$kppdata->kode_desa . ' ' . 'scan_buku_inventaris_kegiatan' . '.' . $extension;

            kppdata::where('id', $id)->update([
                'scan_buku_inventaris_kegiatan' => $fileName
            ]);

            Storage::disk('local')->putFileAs('kpp', $request->scan_buku_inventaris_kegiatan, $fileName);

            return redirect ('/kpp/'.$id); 

        } else {

            return redirect ('/kpp/'.$id); 

        }
    }
}
