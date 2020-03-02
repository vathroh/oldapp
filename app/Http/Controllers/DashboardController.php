<?php

namespace App\Http\Controllers;

use App\tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\google_folder;
use App\Document;
use App\kegiatanksmnew;
use App\kegiatanksm;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = tahun::all();
        return view('dashboard.index', compact('tahun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.tahun');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Document $document)
    {
        $rootFolder = config('app.rootGoogleFolder');
        if (tahun::where('tahun', $request->tahun)->exists()) {
            return redirect('/dashboard');
        } else {
            Storage::disk('google')->makeDirectory($request->namablm . ' ' . $request->tahun);
            $tahun = new tahun;
            $tahun->tahun = $request->tahun;
            $tahun->nama_blm = $request->namablm;
            $tahun->nama_tahun = $request->namablm . ' ' . $request->tahun;
            $tahun->save();

            $f = Storage::disk('google')->directories($rootFolder);
            $g = count($f);


            for ($x = 0; $x < $g; $x++) {
                $idChildFolder = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $idChildFolder)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($f[$x]);

                    $google_folder = new google_folder;
                    google_folder::create([
                        'kode_folder' => $request->tahun,
                        'parent_folder' => $rootFolder,
                        'id_folder' => $idChildFolder,
                        'nama_folder' => $i["name"],
                        'path_folder' => 'OPT-1' . '/' . $i["name"]
                    ]);
                }
            }
        }
        return redirect('/dashboard');
    }

    public function coba()
    {
        $kegiatanksmnew = kegiatanksmnew::all();
        $kegiatanksm = kegiatanksm::all();
        return view('dashboard.coba', compact(['kegiatanksmnew', 'kegiatanksm']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function show(tahun $tahun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function edit(tahun $tahun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tahun $tahun)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function destroy(tahun $tahun)
    {
        //
    }
}
