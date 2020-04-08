<?php

namespace App\CustomFunctions;

use Illuminate\Support\Facades\DB;
use App\kegiatanksm;
use App\Document;

class Rekap
{
    private $tahun,
        $kd_kab,
        $kd_kel,
        $kd_ksm,
        $kd_keg,
        $item_keg,
        $ksm;

    public function RekapKab($tahun, $kd_kab)
    {
        $RekapKegiatan = DB::table('documents')
            ->where('tahun', $tahun)
            ->where('kabupaten', $kd_kab)
            ->count();
        echo $RekapKegiatan;
    }

    public function RekapKelurahan($tahun, $kd_kab, $kd_kel)
    {
        $RekapKegiatan = DB::table('documents')
            // ->where('tahun', $tahun)
            ->where('kabupaten', $kd_kab)
            ->where('desa', $kd_kel)
            ->count();
        echo $RekapKegiatan;
    }

    public function RekapKSM($tahun, $kd_kab, $kd_kel, $kd_ksm)
    {
        $RekapKegiatan = DB::table('documents')
            ->where('tahun', $tahun)
            ->where('kabupaten', $kd_kab)
            ->where('desa', $kd_kel)
            ->where('ksm', $kd_ksm)
            ->count();
        echo $RekapKegiatan;
    }

    public function RekapKegiatan($tahun, $kd_kab, $kd_kel, $kd_ksm, $kd_keg)
    {
        $RekapKegiatan = DB::table('documents')
            ->where('tahun', $tahun)
            ->where('kabupaten', $kd_kab)
            ->where('desa', $kd_kel)
            ->where('ksm', $kd_ksm)
            ->where('kegiatan', $kd_keg)
            ->count();
        echo $RekapKegiatan;
    }

    public function RekapItemKegiatan($tahun, $kd_kab, $kd_kel, $kd_ksm, $kd_keg, $item_keg)
    {
        $RekapKegiatan = DB::table('documents')
            ->where('tahun', $tahun)
            ->where('kabupaten', $kd_kab)
            ->where('desa', $kd_kel)
            ->where('ksm', $kd_ksm)
            ->where('kegiatan', $kd_keg)
            ->where('item_kegiatan', $item_keg)
            ->count();
        echo $RekapKegiatan;
    }
}
