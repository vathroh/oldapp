<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\kppdata;
use App\allvillage;
use App\bkmdata;


class keteranganLainController extends Controller
{
    public function update(Request $request, $id)
    {
        kppdata::where('id', $id)->update([
            'keterangan_lain_lain'=>$request->keterangan_tambahan
        ]);


        return redirect ('/kpp/'.$id); 
    }
}
