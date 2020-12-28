<?php

namespace App\Http\Controllers\kpp;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\infrastruktures_maintenance;
use App\Http\Controllers\Controller;
use App\kppdata;
use App\alldistrict;

class kegiatanPemeliharaanFisikController extends Controller
{
	public function store(Request $request)
	{
		$id = kppdata::where('kode_desa', $request->kelurahan_id)->get()->pluck('id')[0];
		$foto_id = infrastruktures_maintenance::max('id') + 1;
		
		infrastruktures_maintenance::create([		
			'kelurahan_id' => $request->kelurahan_id,
			'tanggal_mulai' => $request->tanggal_mulai_perbaikan,
			'tanggal_selesai' => $request->tanggal_selesai_perbaikan,
			'sumber_dana' => $request->sumber_dana_perbaikan,
			'jumlah' => $request->jumlah_dana,
			'inputby_id' => Auth::user()->id
		]);
				
		if ($request->hasFile('foto_sebelum_perbaikan')) 
		{
			$ldate = date('Y-m-d_H:i:s');
			$extension = $request->foto_sebelum_perbaikan->getClientOriginalExtension();
			$fileName=$request->kelurahan_id . '_' . 'foto_sebelum_perbaikan' . '_' . $foto_id . '.' . $extension;
        
			Storage::disk('public')->putFileAs('kpp', $request->foto_sebelum_perbaikan, $fileName);
        
			infrastruktures_maintenance::get()->last()->update([
				'foto_sebelum_perbaikan' => $fileName
			]);
		}
		
		if ($request->hasFile('foto_perbaikan')) 
		{
			$ldate = date('Y-m-d_H:i:s');
			$extension = $request->foto_perbaikan->getClientOriginalExtension();
			$fileName=$request->kelurahan_id . '_' . 'foto_perbaikan' . '_' . $foto_id . '.' . $extension;
        
			Storage::disk('public')->putFileAs('kpp', $request->foto_perbaikan, $fileName);
        
			infrastruktures_maintenance::get()->last()->update([
				'foto_perbaikan' => $fileName
			]);
		}
		
		if ($request->hasFile('foto_sesudah_perbaikan')) 
		{
			$ldate = date('Y-m-d_H:i:s');
			$extension = $request->foto_sesudah_perbaikan->getClientOriginalExtension();
			$fileName=$request->kelurahan_id . '_' . 'foto_sesudah_perbaikan' . '_' . $foto_id . '.' . $extension;
        
			Storage::disk('public')->putFileAs('kpp', $request->foto_sesudah_perbaikan, $fileName);
        
			infrastruktures_maintenance::get()->last()->update([
				'foto_sesudah_perbaikan' => $fileName
			]);
		}
		
		return redirect ('/kpp/' . $id);
	}
	
	public function edit($id)
	{
		$kabupaten=alldistrict::get();
		$infrastruktures_maintenance = infrastruktures_maintenance::where('id', $id)->get()->first();
		
		return view('kpp.edit.kegiatan_pemeliharaan_fisik', compact(['kabupaten', 'infrastruktures_maintenance']));
	}
	
	public function update(Request $request, $id)
    {
//		$nilai_perbaikan = str_replace(',', '', $request->nilai_perbaikan);
        //		$nilai_perbaikan1 = str_replace('.', '', $nilai_perbaikan);
        $kelurahan_id = infrastruktures_maintenance::select('kelurahan_id')->where('id', $id)->get()->pluck('kelurahan_id')[0];
        
        infrastruktures_maintenance::find($id)->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'sumber_dana' => $request->sumber_dana,
            'jumlah' => $request->jumlah_dana,
            'editedby_id' => Auth::user()->id
        ]);

		if ($request->hasFile('foto_sebelum_perbaikan')) 
		{
			$extension = $request->foto_sebelum_perbaikan->getClientOriginalExtension();
			$fileName = $kelurahan_id . '_' . 'foto_sebelum_perbaikan' . '_' . $id. '.' . $extension;
        
			Storage::disk('public')->putFileAs('kpp', $request->foto_sebelum_perbaikan, $fileName);
        
			infrastruktures_maintenance::find($id)->update([
				'foto_sebelum_perbaikan' => $fileName
			]);
		}
		
		if ($request->hasFile('foto_perbaikan')) 
		{
			$extension = $request->foto_perbaikan->getClientOriginalExtension();
			$fileName=$kelurahan_id . '_' . 'foto_perbaikan' . '_' . $id . '.' . $extension;
        
			Storage::disk('public')->putFileAs('kpp', $request->foto_perbaikan, $fileName);
        
			infrastruktures_maintenance::find($id)->update([
				'foto_perbaikan' => $fileName
			]);
		}
		
		if ($request->hasFile('foto_sesudah_perbaikan')) 
        {
			$extension = $request->foto_sesudah_perbaikan->getClientOriginalExtension();
			$fileName=$kelurahan_id . '_' . 'foto_sesudah_perbaikan' . '_' . $id . '.' . $extension;
        
			Storage::disk('public')->putFileAs('kpp', $request->foto_sesudah_perbaikan, $fileName);
        
			infrastruktures_maintenance::find($id)->update([
				'foto_sesudah_perbaikan' => $fileName
			]);
		}

        $kpp_id = kppdata::where('kode_desa', infrastruktures_maintenance::select('kelurahan_id')
            ->where('id', $id)
            ->get()
            ->pluck('kelurahan_id')
        )->get()->pluck('id')[0];

        return redirect ('/kpp/'.$kpp_id); 
	}
}
