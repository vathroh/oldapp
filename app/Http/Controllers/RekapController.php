<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomFunctions\Rekap;
use App\Document;
use App\kabupaten;
use App\kegiatanksm;
use App\village;
use App\ksm;
use League\CommonMark\Block\Element\Document as ElementDocument;

class RekapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $documents = Document::All();
        $kabupaten = kabupaten::all();
        $kelurahan = village::all();
        $ksm = ksm::all();
        return view('rekap.index', compact(['documents', 'kabupaten', 'kelurahan', 'ksm']));
        // $itung = new Rekap;
        // echo $itung->RekapKegiatan();
    }

    public function rekapKab()
    {
        $documents = Document::All();
        $kabupaten = kabupaten::all();
        return view('rekap.kabupaten', compact(['documents', 'kabupaten']));
    }

    public function rekapKelCentang($kab)
    {
        $documents = Document::All();
        $kelurahan = village::where('KD_KAB', $kab)->get();
        $ksm = ksm::where('KD_KAB', $kab)->get();
        $jmlksm = $ksm->count();

        for ($j = 0; $j < $jmlksm; $j++) {
            $kegiatan = kegiatanksm::where('KD_KAB', $kab)->get();
            $jmlkeg = kegiatanksm::where('KD_KAB', $kab)->count();

            for ($i = 0; $i < $jmlkeg; $i++) {
                $kodekeg = $kegiatan[$i]['KD_KEGIATAN'];
                $jmlfoto0keg = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 0%')->count();
                if ($jmlfoto0keg > 0) {
                    $kegiatan[$i]['FOTO_0'] = 1;
                } else {
                    $kegiatan[$i]['FOTO_0'] = 0;
                }
            }

            $kodeksm = $ksm[$j]['KD_KSM'];
            $jmlkegiatanperksm = $kegiatan->where('KD_KSM', $kodeksm)->count();
            $jmlfoto0ksm = $kegiatan->where('KD_KSM', $kodeksm)->where('FOTO_0', '1')->count();

            if ($jmlfoto0ksm >= $jmlkegiatanperksm) {
                $ksm[$j]['FOTO_0'] = 1;
            } else {
                $ksm[$j]['FOTO_0'] = 0;
            }
        }

        return view('rekap.kelurahan', compact(['documents', 'kelurahan', 'ksm', 'kegiatan']));
    }

    public function rekapKSMCentang($kel)
    {
        $documents = Document::All();
        $ksm = ksm::where('KD_KEL', $kel)->get();
        $kegiatan = kegiatanksm::where('KD_KEL', $kel)->get();
        $jmlkeg = kegiatanksm::where('KD_KEL', $kel)->count();

        for ($i = 0; $i < $jmlkeg; $i++) {
            $kodekeg = $kegiatan[$i]['KD_KEGIATAN'];
            $jmlfoto0keg = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 0%')->count();
            if ($jmlfoto0keg > 0) {
                $kegiatan[$i]['FOTO_0'] = 1;
            } else {
                $kegiatan[$i]['FOTO_0'] = 0;
            }
        }

        return view('rekap.ksm', compact(['documents', 'ksm', 'kegiatan']));
    }

    public function rekapKegiatanCentang($ksm)
    {
        $documents = Document::All();
        $kegiatan = kegiatanksm::where('KD_KSM', $ksm)->get();
        return view('rekap.kegiatan', compact(['documents', 'kegiatan']));
    }
}
