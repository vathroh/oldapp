<?php

namespace App\Http\Controllers\kpp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\data_pengecekan_fisik;
use App\kppdata;
use App\allvillage;

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
		
		$kpp_id = kppdata::where('kode_desa', $request->kelurahan_id)->get()[0]['id'];
		$extension = $request->foto_pengecekan_fisik->getClientOriginalExtension();
		$foto_id = data_pengecekan_fisik::max('id') + 1;
        $fileName=$request->kelurahan_id . '_' . 'foto_pengecekan_fisik' . '_'  . $foto_id . '.' . $extension;
        
        Storage::disk('public')->putFileAs('kpp', $request->foto_pengecekan_fisik, $fileName);
        data_pengecekan_fisik::create([
			'kelurahan_id' => $request->kelurahan_id,
			'tanggal' => $request->tanggal_pengecekan_fisik,
			'keterangan' => $request->keterangan_pengecekan_fisik,
			'foto_pengecekan_fisik' => $fileName,
			'inputby_id' => Auth::user()->id
        ]);
        return redirect('/kpp/' . $kpp_id);
    }


    public function edit($id)
    {
        $data_pengecekan_fisik = data_pengecekan_fisik::find($id);
        $kabupaten = allvillage::get();
        
        return view('kpp.edit.pengecekan-fisik', compact(['data_pengecekan_fisik', 'kabupaten']));
    }


    public function update(Request $request, $id)
    {
        $kelurahan_id = data_pengecekan_fisik::where('id', $id)->get()->pluck('kelurahan_id')[0];
        $kpp_id = kppdata::where('kode_desa', $kelurahan_id)->pluck('id')[0];

        data_pengecekan_fisik::find($id)->update([
            'tanggal'       => $request->tanggal,
            'keterangan'    => $request->keterangan,
            'editedby_id'   => Auth::user()->id
        ]);

        if ($request->hasFile('foto_pengecekan_fisik')) 
        {
            $extension = $request->foto_pengecekan_fisik->getClientOriginalExtension();
            $fileName=$request->kelurahan_id . '_' . 'foto_pengecekan_fisik' . '_' . $id . '.' . $extension;
            
            Storage::disk('public')->putFileAs('kpp', $request->foto_pengecekan_fisik, $fileName);
                    
            data_pengecekan_fisik::find($id)->update([
               'foto_pengecekan_fisik' => $fileName                           
            ]);
        }

        return redirect('/kpp/' . $kpp_id);
    }
}
