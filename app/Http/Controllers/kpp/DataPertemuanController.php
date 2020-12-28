<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\kpp_pertemuan;
use App\allvillage;
use App\kppdata;

class DataPertemuanController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {	
		
		
		/*
		$request->validate([
			'kelurahan_id' => 'required',
			'tanggal' => 'required',
			'foto_pertemuan_rutin' => 'required|mimes:jpeg,png,jpg,gif,svg',
			'tanggal' => 'required',
		]);
		*/
		
		$kpp_id = kppdata::where('kode_desa', $request->kelurahan_id)->get()[0]['id'];
		$foto_id = kpp_pertemuan::max('id') +1;
		
		$ldate = date('Y-m-d_H:i:s');
		$extension = $request->foto_pertemuan_rutin->getClientOriginalExtension();
        $fileName=$request->kelurahan_id . '_' . 'foto_pertemuan_rutin' . '_' . $foto_id . '.' . $extension;
        
        Storage::disk('public')->putFileAs('kpp', $request->foto_pertemuan_rutin, $fileName);
        
		kpp_pertemuan::create([
			'kelurahan_id' => $request->kelurahan_id,
			'tanggal' => $request->tanggal_pertemuan_rutin,
			'pokok_bahasan' => $request->pokok_bahasan,
			'keterangan' => $request->keterangan,
			'foto' => $fileName,
			'inputby_id' => Auth::user()->id
		]);
		
		return redirect('/kpp/' . $kpp_id);
    }


    public function edit($id)
    {
        $kpp_pertemuan = kpp_pertemuan::find($id);
        $kabupaten = allvillage::get();

        return view('kpp.edit.pertemuan-rutin', compact(['kabupaten', 'kpp_pertemuan']));
    }

    public function update(Request $request, $id)
    {
		$kelurahan_id = kpp_pertemuan::where('id', $id)->pluck('kelurahan_id')[0];
		$kpp_id = kppdata::where('kode_desa', $kelurahan_id)->pluck('id')[0];
		
		kpp_pertemuan::find($id)->update([
            'tanggal'       => $request->tanggal,
            'pokok_bahasan' => $request->pokok_bahasan,
            'keterangan'    => $request->keterangan
        ]);
        
        if ($request->hasFile('foto_pertemuan')) 
		{
			$extension = $request->foto_pertemuan->getClientOriginalExtension();
			$fileName=$request->kelurahan_id . '_' . 'foto_pertemuan' . '_' . $id . '.' . $extension;
        
			Storage::disk('public')->putFileAs('kpp', $request->foto_pertemuan, $fileName);
        
			kpp_pertemuan::find($id)->update([
				'foto' => $fileName
			]);
		}
		
		return redirect ('/kpp/' . $kpp_id);
    }
		
}
