<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\data_pengecekan_fisik;
use App\kppdata;

class dataPengecekanFisikController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {
		$request->validate([
		'tanggal_pengecekan_fisik' => 'required',
		'foto_pengecekan_fisik' => 'required|mimes:jpeg,png,jpg,gif,svg',
		]);
		
		$id = kppdata::where('kode_desa', $request->kelurahan_id)->get()[0]['id'];
		$ldate = date('Y-m-d_H:i:s');
		$extension = $request->foto_pengecekan_fisik->getClientOriginalExtension();
        $fileName=$request->kelurahan_id . '_' . 'foto_pengecekan_fisik' . '_' . $ldate . '.' . $extension;
        
        Storage::disk('public')->putFileAs('kpp', $request->foto_pengecekan_fisik, $fileName);
        data_pengecekan_fisik::create([
			'kelurahan_id' => $request->kelurahan_id,
			'tanggal' => $request->tanggal_pengecekan_fisik,
			'keterangan' => $request->keterangan_pengecekan_fisik,
			'foto_pengecekan_fisik' => $fileName,
			'inputby_id' => Auth::user()->id
        ]);
        return redirect('/kpp/' . $id);
	}
}
