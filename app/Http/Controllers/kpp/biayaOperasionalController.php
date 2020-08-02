<?php

namespace App\Http\Controllers\kpp;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kppdata;

class biayaOperasionalController extends Controller
{
	public function update(Request $request, $id)
	{
		kppdata::where('id', $id)->update([
			'bop'=>$request->biaya_operasional,
			'sumber_dana_operasional'=>$request->sumber_dana,
			'nilai_bop' => $request->nilai_bop
		]);

		return redirect ('/kpp/'.$id); 
	}
}
