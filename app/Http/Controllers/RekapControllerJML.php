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
        // $itung = new Rekap;
        // echo $itung->RekapKegiatan();
    }

    public function rekapKel($kab)
    {
        $documents = Document::All();
        $kabupaten = kabupaten::all();
        $kelurahan = village::where('KD_KAB', $kab)->get();
        return view('rekap.kelurahan', compact(['documents', 'kabupaten', 'kelurahan']));
        // $itung = new Rekap;
        // echo $itung->RekapKegiatan();
    }

    public function rekapKSM($kel)
    {
        $documents = Document::All();
        $kabupaten = kabupaten::all();
        $kelurahan = village::all();
        $ksm = ksm::where('KD_KEL', $kel)->get();
        $kegiatan = kegiatanksm::all();
        return view('rekap.ksm', compact(['documents', 'kabupaten', 'kelurahan', 'ksm']));
        // $itung = new Rekap;
        // echo $itung->RekapKegiatan();
    }

    public function rekapKegiatan($ksm)
    {
        $documents = Document::All();
        $kabupaten = kabupaten::all();
        $kelurahan = village::all();
        $ksm_ = ksm::all();
        $kegiatan = kegiatanksm::where('KD_KSM', $ksm)->get();

        return view('rekap.kegiatan', compact(['documents', 'kabupaten', 'kelurahan', 'ksm_', 'kegiatan']));
    }



    public function jmlKegiatanKSM($keg)
    {
        $kodeKSM = substr($keg, 0, 14);
        $jmlKegiatan = kegiatanksm::where('KD_KSM', $kodeKSM)->count();
        return $jmlKegiatan;
    }

    public function rekapAllKegiatan($keg)
    {
        $kodeKSM = substr($keg, 0, 14);
        $jmlKegiatan = kegiatanksm::where('KD_KSM', $kodeKSM)->count();
        return $jmlKegiatan;
    }

    public function rekapKSMCentang($kel)
    {
        $jmlksm = ksm::where('KD_KEL', $kel)->count();

        for ($x = 0; $x < $jmlksm; $x++) {
            $ksm = Document::where('kode_kel', $kel)->get('kode_ksm')[$x]['kode_ksm'];
            $jmlkeg = kegiatanksm::where('KD_KSM', $ksm)->count();
            $kegiatan = kegiatanksm::where('KD_KSM', $ksm)->get();

            for ($i = 0; $i < $jmlkeg; $i++) {

                $ag = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 0%')->count();
                if ($ag > 0) {
                    $kegiatan[$i]["FOTO 0%"] = 1;
                } else {
                    $kegiatan[$i]["FOTO 0%"] = 0;
                }

                $ar = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 25%')->count();
                if ($ar > 0) {
                    $kegiatan[$i]["FOTO 25%"] = 1;
                } else {
                    $kegiatan[$i]["FOTO 25%"] = 0;
                }

                $at = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 50%')->count();
                if ($at > 0) {
                    $kegiatan[$i]["FOTO 50%"] = 1;
                } else {
                    $kegiatan[$i]["FOTO 50%"] = 0;
                }

                $au = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 75%')->count();
                if ($au > 0) {
                    $kegiatan[$i]["FOTO 75%"] = 1;
                } else {
                    $kegiatan[$i]["FOTO 75%"] = 0;
                }

                $av = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 100%')->count();
                if ($av > 0) {
                    $kegiatan[$i]["FOTO 100%"] = 1;
                } else {
                    $kegiatan[$i]["FOTO 100%"] = 0;
                }
            }
        }
        $kegiatan->where('FOTO 100%', '1')->count();
    }

    public function rekapKegiatanCentang($ksm)
    {
        $documents = Document::All();
        $kabupaten = kabupaten::all();
        $kelurahan = village::all();
        $ksm_ = ksm::all();
        $kegiatan = kegiatanksm::where('KD_KSM', $ksm)->get();
        $jmlkeg = kegiatanksm::where('KD_KSM', $ksm)->count();


        for ($i = 0; $i < $jmlkeg; $i++) {

            $ag = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 0%')->count();
            if ($ag > 0) {
                $kegiatan[$i]["sign0"] = "V";
            } else {
                $kegiatan[$i]["sign0"] = "-";
            }

            $ar = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 25%')->count();
            if ($ar > 0) {
                $kegiatan[$i]["sign25"] = "V";
            } else {
                $kegiatan[$i]["sign25"] = "-";
            }

            $at = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 50%')->count();
            if ($at > 0) {
                $kegiatan[$i]["sign50"] = "V";
            } else {
                $kegiatan[$i]["sign50"] = "-";
            }

            $au = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 75%')->count();
            if ($au > 0) {
                $kegiatan[$i]["sign75"] = "V";
            } else {
                $kegiatan[$i]["sign75"] = "-";
            }

            $av = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 100%')->count();
            if ($av > 0) {
                $kegiatan[$i]["sign100"] = "V";
            } else {
                $kegiatan[$i]["sign100"] = "-";
            }
        }

        return view('rekap.kegiatan', compact(['documents', 'kabupaten', 'kelurahan', 'ksm_', 'kegiatan']));
    }

    public function RekapPerKeg($ksm)
    {
        $kegiatan = kegiatanksm::where('KD_KSM', $ksm)->get();
        $jmlkeg = kegiatanksm::where('KD_KSM', $ksm)->count();
        for ($i = 0; $i < $jmlkeg; $i++) {

            $ag = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 0%')->count();
            if ($ag > 0) {
                $kegiatan[$i]["sign0"] = 1;
            } else {
                $kegiatan[$i]["sign0"] = 0;
            }

            $ar = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 25%')->count();
            if ($ar > 0) {
                $kegiatan[$i]["sign25"] = 1;
            } else {
                $kegiatan[$i]["sign25"] = 0;
            }

            $at = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 50%')->count();
            if ($at > 0) {
                $kegiatan[$i]["sign50"] = 1;
            } else {
                $kegiatan[$i]["sign50"] = 0;
            }

            $au = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 75%')->count();
            if ($au > 0) {
                $kegiatan[$i]["sign75"] = 1;
            } else {
                $kegiatan[$i]["sign75"] = 0;
            }

            $av = Document::where('kode_kegiatan', kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'])->where('jenis_dokumen', 'FOTO 100%')->count();
            if ($av > 0) {
                $kegiatan[$i]["sign100"] = 1;
            } else {
                $kegiatan[$i]["sign100"] = 0;
            }
        }
    }

    public function rekapPerKegiatan($ksm)
    {
        // $kegiatan = kegiatanksm::where('KD_KSM', $ksm)->get('KD_KEGIATAN');
        $jmlKegiatan = kegiatanksm::where('KD_KSM', $ksm)->count();
        $jenis_dokumen = 'FOTO 25%';

        $b = 0;
        for ($i = 0; $i < $jmlKegiatan; $i++) {
            $kode_kegiatan = kegiatanksm::where('KD_KSM', $ksm)->get()[$i]['KD_KEGIATAN'];
            $b += $this->centangKegiatanfoto0($kode_kegiatan, $jenis_dokumen);
        }
        echo $b;
    }

    public function centangKegiatanfoto0($kode_kegiatan, $jenis_dokumen)
    {
        $jmlfoto0 = Document::where('kode_kegiatan', $kode_kegiatan)->where('jenis_dokumen', $jenis_dokumen)->count();
        if ($jmlfoto0 > 0) {
            $foto0 = 1;
        } else {
            $foto0 = 0;
        }
        return $foto0;
    }

    public function centangKegiatanfoto25($keg)
    {
        $jmlfoto25 = Document::where('kode_kegiatan', $keg)->where('jenis_dokumen', 'FOTO 25%')->count();
        if ($jmlfoto25 > 0) {
            $foto25 = 1;
        } else {
            $foto25 = 0;
        }
        return $foto25;
    }

    public function centangKegiatanfoto50($keg)
    {
        $jmlfoto50 = Document::where('kode_kegiatan', $keg)->where('jenis_dokumen', 'FOTO 50%')->count();
        if ($jmlfoto50 > 0) {
            $foto50 = 1;
        } else {
            $foto50 = 0;
        }
        return $foto50;
    }

    public function centangKegiatanfoto75($keg)
    {
        $jmlfoto75 = Document::where('kode_kegiatan', $keg)->where('jenis_dokumen', 'FOTO 75%')->count();
        if ($jmlfoto75 > 0) {
            $foto75 = 1;
        } else {
            $foto75 = 0;
        }
        return $foto75;
    }

    public function centangKegiatanfoto100($keg)
    {
        $jmlfoto100 = Document::where('kode_kegiatan', $keg)->where('jenis_dokumen', 'FOTO 100%')->count();
        if ($jmlfoto100 > 0) {
            $foto100 = 1;
        } else {
            $foto100 = 0;
        }
        return $foto100;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
