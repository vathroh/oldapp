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
        $documents = Document::where('kode_kab', $kab)->get();
        $kelurahan = village::where('KD_KAB', $kab)->get();
        $jmlkel = $kelurahan->count();
        for ($k = 0; $k < $jmlkel; $k++) {
            $kodekel = $kelurahan[$k]['KD_KEL'];
            $jmlkegkel = 0;
            $ksm = ksm::where('KD_KEL', $kodekel)->get();
            $jmlksm = $ksm->count();
            $jmlfotomp2kkel = 0;
            $jmlfotoojtkel = 0;
            $jmlfotopelatihanksmkel = 0;
            $jmlfoto0ksm = 0;
            $jmlfoto25ksm = 0;
            $jmlfoto50ksm = 0;
            $jmlfoto75ksm = 0;
            $jmlfoto100ksm = 0;
            for ($j = 0; $j < $jmlksm; $j++) {
                $kodeksm = $ksm[$j]['KD_KSM'];
                $kegiatan = kegiatanksm::where('KD_KSM', $kodeksm)->get();
                $jmlkeg = $kegiatan->count();
                $jmlfotomp2k = $documents->where('KD_KSM', $kodeksm)->where('jenis_dokumen', 'MP2K')->count();
                $jmlfotoojt = $documents->where('KD_KSM', $kodeksm)->where('jenis_dokumen', 'OJT')->count();
                $jmlfotopelatihan = $documents->where('KD_KSM', $kodeksm)->where('jenis_dokumen', 'PELATIHAN')->count();
                $jmlfoto0keg = 0;
                $jmlfoto25keg = 0;
                $jmlfoto50keg = 0;
                $jmlfoto75keg = 0;
                $jmlfoto100keg = 0;
                for ($i = 0; $i < $jmlkeg; $i++) {
                    $kodekeg = $kegiatan[$i]['KD_KEGIATAN'];
                    $jmlfoto0 = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 0%')->count();
                    $jmlfoto25 = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 25%')->count();
                    $jmlfoto50 = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 50%')->count();
                    $jmlfoto75 = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 75%')->count();
                    $jmlfoto100 = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 100%')->count();
                    if ($jmlfoto0 > 0) {
                        $a = 1;
                    } else {
                        $a = 0;
                    }
                    $jmlfoto0keg += $a;

                    if ($jmlfoto25 > 0) {
                        $b = 1;
                    } else {
                        $b = 0;
                    }
                    $jmlfoto25keg += $b;

                    if ($jmlfoto50 > 0) {
                        $c = 1;
                    } else {
                        $c = 0;
                    }
                    $jmlfoto50keg += $c;

                    if ($jmlfoto75 > 0) {
                        $d = 1;
                    } else {
                        $d = 0;
                    }
                    $jmlfoto75keg += $d;

                    if ($jmlfoto100 > 0) {
                        $e = 1;
                    } else {
                        $e = 0;
                    }
                    $jmlfoto100keg += $b;

                    if ($jmlfotomp2k > 0) {
                        $jmlfotomp2kksm = 1;
                    } else {
                        $jmlfotomp2kksm = 0;
                    }

                    if ($jmlfotoojt > 0) {
                        $jmlfotoojtksm = 1;
                    } else {
                        $jmlfotoojtksm = 0;
                    }

                    if ($jmlfotopelatihan > 0) {
                        $jmlfotopelatihanksm = 1;
                    } else {
                        $jmlfotopelatihanksm = 0;
                    }
                }

                $jmlfotomp2kkel += $jmlfotomp2kksm;
                $jmlfotoojtkel += $jmlfotoojtksm;
                $jmlfotopelatihanksmkel += $jmlfotopelatihanksm;
                $jmlfoto0ksm += $jmlfoto0keg;
                $jmlfoto25ksm += $jmlfoto25keg;
                $jmlfoto50ksm += $jmlfoto50keg;
                $jmlfoto75ksm += $jmlfoto75keg;
                $jmlfoto100ksm += $jmlfoto100keg;
                $jmlkegkel += $jmlkeg;
            }

            $kelurahan[$k]['MP2K'] = $jmlfotomp2kkel;
            $kelurahan[$k]['OJT'] = $jmlfotoojtkel;
            $kelurahan[$k]['PELATIHAN_KSM'] = $jmlfotopelatihanksmkel;
            $kelurahan[$k]['FOTO_0'] = $jmlfoto0ksm;
            $kelurahan[$k]['FOTO_25'] = $jmlfoto25ksm;
            $kelurahan[$k]['FOTO_50'] = $jmlfoto50ksm;
            $kelurahan[$k]['FOTO_75'] = $jmlfoto75ksm;
            $kelurahan[$k]['FOTO_100'] = $jmlfoto100ksm;
            $kelurahan[$k]['JML_KSM'] = $jmlksm;
            $kelurahan[$k]['JML_KEG'] = $jmlkegkel;
        }

        return view('rekap.kelurahan', compact(['documents', 'kelurahan', 'kegiatan']));
    }
    public function rekapKelCentangcad($kab)
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
            // $jmlfoto0ksm = $kegiatan->where('KD_KSM', $kodeksm)->where('FOTO_0', '1')->count();
            // $jmlfoto25ksm = $kegiatan->where('KD_KSM', $kodeksm)->where('FOTO_25', '1')->count();
            // $jmlfoto50ksm = $kegiatan->where('KD_KSM', $kodeksm)->where('FOTO_50', '1')->count();
            // $jmlfoto75ksm = $kegiatan->where('KD_KSM', $kodeksm)->where('FOTO_75', '1')->count();
            // $jmlfoto100ksm = $kegiatan->where('KD_KSM', $kodeksm)->where('FOTO_100', '1')->count();

            $jmlfotomp2kksm = $documents->where('kode_ksm', $kodeksm)->where('jenis_dokumen', 'DOKUMENTASI MP2K')->count();
            $jmlfotoojtksm = $documents->where('kode_ksm', $kodeksm)->where('jenis_dokumen', 'DOKUMENTASI OJT')->count();
            $jmlfotopelatihanksm = $documents->where('kode_ksm', $kodeksm)->where('jenis_dokumen', 'DOKUMENTASI PELATIHAN')->count();

            // if ($jmlfoto0ksm >= $jmlkegiatanperksm) {
            //     $ksm[$j]['FOTO_0'] = 1;
            // } else {
            //     $ksm[$j]['FOTO_0'] = 0;
            // }
            // if ($jmlfoto25ksm >= $jmlkegiatanperksm) {
            //     $ksm[$j]['FOTO_25'] = 1;
            // } else {
            //     $ksm[$j]['FOTO_25'] = 0;
            // }
            // if ($jmlfoto50ksm >= $jmlkegiatanperksm) {
            //     $ksm[$j]['FOTO_50'] = 1;
            // } else {
            //     $ksm[$j]['FOTO_50'] = 0;
            // }
            // if ($jmlfoto75ksm >= $jmlkegiatanperksm) {
            //     $ksm[$j]['FOTO_75'] = 1;
            // } else {
            //     $ksm[$j]['FOTO_75'] = 0;
            // }
            // if ($jmlfoto100ksm >= $jmlkegiatanperksm) {
            //     $ksm[$j]['FOTO_100'] = 1;
            // } else {
            //     $ksm[$j]['FOTO_100'] = 0;
            // }
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
        $jmlksm = $ksm->count();

        for ($j = 0; $j < $jmlksm; $j++) {
            $kodeksm = $ksm[$j]['KD_KSM'];
            $kegiatan = kegiatanksm::where('KD_KSM', $kodeksm)->get();
            $jmlkeg = $kegiatan->count();
            $jmlfoto0keg = 0;
            $jmlfoto25keg = 0;
            $jmlfoto50keg = 0;
            $jmlfoto75keg = 0;
            $jmlfoto100keg = 0;
            for ($i = 0; $i < $jmlkeg; $i++) {
                $kodekeg = $kegiatan[$i]['KD_KEGIATAN'];
                $jmlfoto0 = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 0%')->count();
                $jmlfoto25 = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 25%')->count();
                $jmlfoto50 = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 50%')->count();
                $jmlfoto75 = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 75%')->count();
                $jmlfoto100 = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 100%')->count();
                if ($jmlfoto0 > 0) {
                    $a = 1;
                } else {
                    $a = 0;
                }
                $jmlfoto0keg += $a;

                if ($jmlfoto25 > 0) {
                    $b = 1;
                } else {
                    $b = 0;
                }
                $jmlfoto25keg += $b;

                if ($jmlfoto50 > 0) {
                    $c = 1;
                } else {
                    $c = 0;
                }
                $jmlfoto50keg += $c;

                if ($jmlfoto75 > 0) {
                    $d = 1;
                } else {
                    $d = 0;
                }
                $jmlfoto75keg += $d;

                if ($jmlfoto100 > 0) {
                    $e = 1;
                } else {
                    $e = 0;
                }
                $jmlfoto100keg += $e;
            }

            $ksm[$j]['FOTO_0'] = $jmlfoto0keg;
            $ksm[$j]['FOTO_25'] = $jmlfoto25keg;
            $ksm[$j]['FOTO_50'] = $jmlfoto50keg;
            $ksm[$j]['FOTO_75'] = $jmlfoto75keg;
            $ksm[$j]['FOTO_100'] = $jmlfoto100keg;
            $ksm[$j]['JML_KEG'] = $jmlkeg;
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

        $jmlkegiatan = $kegiatan->count();

        for ($i = 0; $i < $jmlkegiatan; $i++) {
            $kodekeg = $kegiatan[$i]['KD_KEGIATAN'];
            $jmlfoto0 = $documents->where('kode_kegiatan', $kodekeg)->where('jenis_dokumen', 'FOTO 0%')->count();
            if ($jmlfoto0 > 0) {
                $kegiatan[$i]['FOTO_0'] = 1;
            } else {
                $kegiatan[$i]['FOTO_0'] = 0;
            }
        }

        return view('rekap.kegiatan', compact(['documents', 'kegiatan', 'kelurahan', 'ksm']));
    }
}
