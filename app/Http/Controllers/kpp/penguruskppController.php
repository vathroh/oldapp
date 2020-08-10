<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kppdata;
use App\pengurus_kpp;

class penguruskppController extends Controller
{
	public function update(Request $request, $id){

			pengurus_kpp::where('id', $id)->update([
				'ketua_kpp'=>$request->ketua_kpp,
				'ketua_kpp_hp'=>$request->ketua_kpp_hp,
				'sekretaris_kpp'=>$request->sekretaris_kpp,
				'sekretaris_kpp_hp'=>$request->sekretaris_kpp_hp,
				'bendahara_kpp'=>$request->bendahara_kpp,
				'bendahara_kpp_hp'=>$request->bendahara_kpp_hp,
			]);

			$kelurahan_id = pengurus_kpp::where('id', $id)->pluck('kelurahan_id')->first();
			$kpp_id = kppdata::where('kode_desa', $kelurahan_id)->pluck('id')->first();
		
		return redirect('/kpp/' . $kpp_id);
	}
}
