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
		$nilai_bop = str_replace(',', '', $request->nilai_bop);
		$nilai_bop1 = str_replace('.', '', $nilai_bop);

		kppdata::where('id', $id)->update([
			'bop'=>$request->biaya_operasional
		]);

		return redirect ('/kpp/'.$id); 
	}
}
