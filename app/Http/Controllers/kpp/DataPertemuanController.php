<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\kpp_pertemuan;
use App\kppdata;

class DataPertemuanController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {	
		$request->validate([
			'kelurahan_id' => 'required',
			'tanggal' => 'required',
			'foto_pertemuan_rutin' => 'required|mimes:jpeg,png,jpg,gif,svg',
			'tanggal' => 'required',
		]);
		
		$id = kppdata::where('kode_desa', $request->kelurahan_id)->get()[0]['id'];
		$ldate = date('Y-m-d_H:i:s');
		$extension = $request->foto_pertemuan_rutin->getClientOriginalExtension();
        $fileName=$request->kelurahan_id . '_' . 'foto_pertemuan_rutin' . '_' . $ldate . '.' . $extension;
        
        Storage::disk('public')->putFileAs('kpp', $request->foto_pertemuan_rutin, $fileName);
        
		kpp_pertemuan::create([
			'kelurahan_id' => $request->kelurahan_id,
			'tanggal' => $request->tanggal_pertemuan_rutin,
			'pokok_bahasan' => $request->pokok_bahasan,
			'keterangan' => $request->keterangan,
			'foto' => $fileName,
			'inputby_id' => Auth::user()->id
		]);
		
		return redirect('/kpp/' . $id);
	}
		
}
