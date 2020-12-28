<?php

namespace App\Http\Controllers\kpp;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\kppdata;
use App\kpp_operating_fund;
use App\alldistrict;

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


    public function edit($id)
    {
        $kabupaten = alldistrict::get();
        $bop = kpp_operating_fund::find($id);
        return view('kpp.edit.biaya_operasional', compact(['bop', 'kabupaten']));
    }

    public function store(Request $request, $id)
    {

    }
}
