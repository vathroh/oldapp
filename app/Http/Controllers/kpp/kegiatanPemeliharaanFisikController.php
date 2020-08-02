<?php

namespace App\Http\Controllers\kpp;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kppdata;

class kegiatanPemeliharaanFisikController extends Controller
{
    public function update(Request $request, $id)
	{
		kppdata::where('id', $id)->update([
			'tanggal_kegiatan_perbaikan'=>$request->tanggal_kegiatan_perbaikan,
			'sumber_dana_perbaikan'=>$request->sumber_dana_perbaikan,
			'nilai_perbaikan' => $request->nilai_perbaikan
		]);

		return redirect ('/kpp/'.$id); 
	}
}
