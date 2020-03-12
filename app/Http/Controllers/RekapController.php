<?php

namespace App\Http\Controllers;

use App\Document;
use App\kabupaten;
use App\kegiatanksm;
use App\village;
use App\ksm;


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
                $jmlfoto25keg = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 25%')->count();
                $jmlfoto50keg = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 50%')->count();
                $jmlfoto75keg = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 75%')->count();
                $jmlfoto100keg = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 100%')->count();

                if ($jmlfoto0keg > 0) {
                    $kegiatan[$i]['FOTO_0'] = 1;
                } else {
                    $kegiatan[$i]['FOTO_0'] = 0;
                }
                if ($jmlfoto25keg > 0) {
                    $kegiatan[$i]['FOTO_25'] = 1;
                } else {
                    $kegiatan[$i]['FOTO_25'] = 0;
                }
                if ($jmlfoto50keg > 0) {
                    $kegiatan[$i]['FOTO_50'] = 1;
                } else {
                    $kegiatan[$i]['FOTO_50'] = 0;
                }
                if ($jmlfoto75keg > 0) {
                    $kegiatan[$i]['FOTO_75'] = 1;
                } else {
                    $kegiatan[$i]['FOTO_75'] = 0;
                }
                if ($jmlfoto100keg > 0) {
                    $kegiatan[$i]['FOTO_100'] = 1;
                } else {
                    $kegiatan[$i]['FOTO_100'] = 0;
                }
            }

            $kodeksm = $ksm[$j]['KD_KSM'];
            $jmlkegiatanperksm = $kegiatan->where('KD_KSM', $kodeksm)->count();
            $jmlfoto0ksm = $kegiatan->where('KD_KSM', $kodeksm)->where('FOTO_0', '1')->count();
            $jmlfoto25ksm = $kegiatan->where('KD_KSM', $kodeksm)->where('FOTO_25', '1')->count();
            $jmlfoto50ksm = $kegiatan->where('KD_KSM', $kodeksm)->where('FOTO_50', '1')->count();
            $jmlfoto75ksm = $kegiatan->where('KD_KSM', $kodeksm)->where('FOTO_75', '1')->count();
            $jmlfoto100ksm = $kegiatan->where('KD_KSM', $kodeksm)->where('FOTO_100', '1')->count();

            $jmlfotomp2kksm = $documents->where('kode_ksm', $kodeksm)->where('jenis_dokumen', 'DOKUMENTASI MP2K')->count();
            $jmlfotoojtksm = $documents->where('kode_ksm', $kodeksm)->where('jenis_dokumen', 'DOKUMENTASI OJT')->count();
            $jmlfotopelatihanksm = $documents->where('kode_ksm', $kodeksm)->where('jenis_dokumen', 'DOKUMENTASI PELATIHAN')->count();

            if ($jmlfoto0ksm >= $jmlkegiatanperksm) {
                $ksm[$j]['FOTO_0'] = 1;
            } else {
                $ksm[$j]['FOTO_0'] = 0;
            }
            if ($jmlfoto25ksm >= $jmlkegiatanperksm) {
                $ksm[$j]['FOTO_25'] = 1;
            } else {
                $ksm[$j]['FOTO_25'] = 0;
            }
            if ($jmlfoto50ksm >= $jmlkegiatanperksm) {
                $ksm[$j]['FOTO_50'] = 1;
            } else {
                $ksm[$j]['FOTO_50'] = 0;
            }
            if ($jmlfoto75ksm >= $jmlkegiatanperksm) {
                $ksm[$j]['FOTO_75'] = 1;
            } else {
                $ksm[$j]['FOTO_75'] = 0;
            }
            if ($jmlfoto100ksm >= $jmlkegiatanperksm) {
                $ksm[$j]['FOTO_100'] = 1;
            } else {
                $ksm[$j]['FOTO_100'] = 0;
            }
            if ($jmlfotomp2kksm >= $jmlkegiatanperksm) {
                $ksm[$j]['FOTO_MP2K'] = 1;
            } else {
                $ksm[$j]['FOTO_MP2K'] = 0;
            }
            if ($jmlfotoojtksm >= $jmlkegiatanperksm) {
                $ksm[$j]['FOTO_OJT'] = 1;
            } else {
                $ksm[$j]['FOTO_OJT'] = 0;
            }
            if ($jmlfotopelatihanksm >= $jmlkegiatanperksm) {
                $ksm[$j]['FOTO_PELATIHAN'] = 1;
            } else {
                $ksm[$j]['FOTO_PELATIHAN'] = 0;
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
            $jmlfoto25keg = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 25%')->count();
            $jmlfoto50keg = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 50%')->count();
            $jmlfoto75keg = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 75%')->count();
            $jmlfoto100keg = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 100%')->count();

            if ($jmlfoto0keg > 0) {
                $kegiatan[$i]['FOTO_0'] = 1;
            } else {
                $kegiatan[$i]['FOTO_0'] = 0;
            }
            if ($jmlfoto25keg > 0) {
                $kegiatan[$i]['FOTO_25'] = 1;
            } else {
                $kegiatan[$i]['FOTO_25'] = 0;
            }
            if ($jmlfoto50keg > 0) {
                $kegiatan[$i]['FOTO_50'] = 1;
            } else {
                $kegiatan[$i]['FOTO_50'] = 0;
            }
            if ($jmlfoto75keg > 0) {
                $kegiatan[$i]['FOTO_75'] = 1;
            } else {
                $kegiatan[$i]['FOTO_75'] = 0;
            }
            if ($jmlfoto100keg > 0) {
                $kegiatan[$i]['FOTO_100'] = 1;
            } else {
                $kegiatan[$i]['FOTO_100'] = 0;
            }
        }
        $kodekel = $kegiatan[0]['KD_KEL'];
        $kelurahan = village::where('KD_KEL',  $kodekel)->get();
        return view('rekap.ksm', compact(['documents', 'ksm', 'kegiatan', 'kelurahan']));
    }

    public function rekapKegiatanCentang($ksm1)
    {
        $documents = Document::All();
        $kegiatan = kegiatanksm::where('KD_KSM', $ksm1)->get();
        $ksm = ksm::where('KD_KSM', $ksm1)->get();
        $kodekel = $ksm[0]['KD_KEL'];
        $kelurahan = village::where('KD_KEL', $kodekel)->get();

        return view('rekap.kegiatan', compact(['documents', 'kegiatan', 'kelurahan', 'ksm']));
    }
}
