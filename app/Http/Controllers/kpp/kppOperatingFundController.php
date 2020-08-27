<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\kpp_operating_fund;
use App\kppdata;

class kppOperatingFundController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {
		$id = kppdata::where('kode_desa', $request->kelurahan_id)->get()[0]['id'];
		$nilai_bop = str_replace('Rp. ', '', $request->nilai_bop);
		$nilai_bop1 = str_replace('.', '', $nilai_bop);
		
		/*
		$request->validate([
			'kelurahan_id' => 'required',
			'tanggal' => 'required',
			'sumber_dana' => 'required',
			'jumlah' => 'required',
		]);
		*/
				
		kpp_operating_fund::create([
			'kelurahan_id' => $request->kelurahan_id,
			'tanggal' => $request->tanggal,
			'sumber_dana' => $request->sumber_dana,
			'jumlah' => $nilai_bop1,
			'inputby_id' => Auth::user()->id
		]);		
		
		return redirect('/kpp/' . $id);		
	}
	
	public function update(Request $request, $id)
     {
         kpp_operating_fund::find($id)->update([
            'tanggal'       => $request->tanggal, 
            'sumber_dana'   => $request->sumber_dana,
            'jumlah'        => $request->jumlah_dana,
            'edited_by'     => Auth::user()->id  
         ]);
         
         $kpp_id = kppdata::where('kode_desa', kpp_operating_fund::where('id', $id)->pluck('kelurahan_id')[0])->pluck('id')[0];
         
         return redirect('/kpp/' . $kpp_id);
     } 

}
