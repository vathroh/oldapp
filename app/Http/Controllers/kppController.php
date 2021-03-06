<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ZoneController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimeController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Exports\Rekap_kpp_per_kabupaten;
use App\Exports\Rekap_kpp_per_kecamatan;
use App\Exports\Rekap_kpp_per_kelurahan;
use App\infrastruktures_maintenance;
use Illuminate\Support\Arr;
use App\alldistrict;
use App\allsubdistrict;
use App\allvillage;
use App\kppdata;
use App\bkmdata;
use App\pengurus_kpp;
use App\User;
use App\kpp_pertemuan;
use App\kpp_operating_fund;
use App\data_pengecekan_fisik;
use App\kpp_data_model;
use Gate;

class kppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function user(){
        return new UserController;
    }

    public function zone()
    {
        return new ZoneController;
    }

    public function myzone()
    {
        return Arr::pluck($this->zone()->my_zone_now(Auth::user()->id)['wilayah'], 'kode_kab');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = $this->myzone();

        $kppdatas = DB::table('kpp_data_view')->leftjoin('infrastruktures_maintenances', 'infrastruktures_maintenances.kelurahan_id', '=', 'kpp_data_view.kode_desa')->groupBy('kpp_data_view.kode_desa')->leftjoin('bkmdatas', 'bkmdatas.kelurahan_id', '=', 'kpp_data_view.kode_desa')->leftjoin('users', 'users.id', '=', 'kpp_data_view.user_id')->orderBy('kpp_data_view.updated_at', 'desc')->whereIn('KD_KAB', $districts)->select('*','kpp_data_view.id as kpp_id')->paginate(10);

        $BOPs = kpp_operating_fund::get();

        return view('kpp.index', compact(['kppdatas', 'BOPs']));
    }

    public function find()
    {
        $kabupaten = alldistrict::whereIn('kode_kab', $this->myzone())->get();

        return view('kpp.find', compact('kabupaten'));
    }

    public function create(Request $request)
    {
        switch (Auth::user()->hasAnyRoles(['admin', 'fasilitator'])) {
            case true:

                $kelurahan = allvillage::get();
                $kabupaten = $this->myzone();
                $kppdatas = kppdata::get();
                $bkmdatas = bkmdata::get();
                $user = User::get();

                if (kppdata::where('kode_desa', $request->kelurahan)->doesntExist()) {
                    return view('kpp.create', compact(['request', 'bkmdatas', 'kelurahan', 'kabupaten']));
                } else {
                    $id = kppdata::where('kode_desa', $request->kelurahan)->get()[0]['id'];
                    return redirect('/kpp/' . $id);
                }

                break;
            default:
                return redirect(route('kpp.index'));
                break;
        }
    }


    public function store(Request $request)
    {
        kppdata::create([
            'kode_desa' => $request->kelurahan,
            'lokasi_bdi_bpm' => $request->lokasi_bdi,
            'nama_kpp' => $request->nama_kpp,
            'anggota_pria' => $request->anggota_pria,
            'anggota_wanita' => $request->anggota_wanita,
            'anggota_miskin' => $request->anggota_miskin,
            'user_id' => Auth::user()->id
        ]);

        pengurus_kpp::create([
            'kelurahan_id' => $request->kelurahan,
        ]);

        $id = kppdata::where('kode_desa', $request->kelurahan)->get()[0]['id'];
        return redirect('/kpp/' . $id);
    }


    public function show($id)
    {
            $kabupaten = $this->myzone();
            $kppdata = kppdata::where('id', $id)->get()[0];
            $kelurahan = allvillage::where('KD_KEL', $kppdata->kode_desa)->get()[0];
            $bkmdata = bkmdata::where('kelurahan_id', $kppdata->kode_desa)->get()[0];
            $kpp_pertemuans = kpp_pertemuan::where('kelurahan_id', $kppdata->kode_desa)->get();
            $pengurus_kpp = pengurus_kpp::where('kelurahan_id', $kppdata->kode_desa)->get()->first();
            $kpp_operating_funds = kpp_operating_fund::where('kelurahan_id', $kppdata->kode_desa)->get();
            $data_pengecekan_fisiks = data_pengecekan_fisik::where('kelurahan_id', $kppdata->kode_desa)->get();
            $infrastruktures_maintenances = infrastruktures_maintenance::where('kelurahan_id', $kppdata->kode_desa)->get();
            $user = User::get();

            $jumlah = DB::table('kpp_operating_funds')->select(DB::raw('SUM(jumlah) as jumlah'))->get();

            return view('kpp.show', compact(['kppdata', 'kelurahan', 'bkmdata', 'kabupaten', 'pengurus_kpp', 'kpp_pertemuans', 'kpp_operating_funds', 'user', 'data_pengecekan_fisiks', 'infrastruktures_maintenances', 'jumlah']));
    }

    public function edit($id)
    {
        if (Auth::user()->hasAnyRoles(['admin', 'fasilitator'])) {
            $kppdata = kppdata::find($id);
            $kelurahan = allvillage::where('KD_KEL', $kppdata->kode_desa)->get();
            $bkmdata = bkmdata::where('kelurahan_id', $kppdata->kode_desa)->get();
            $kabupaten = $this->myzone();
            return view('kpp.edit', compact(['kppdata', 'bkmdata', 'kelurahan', 'kabupaten']));
        } else {
            return redirect('/kpp');
        }
    }


    public function update(Request $request, $id)
    {
        kppdata::where('id', $id)->update([
            'lokasi_bdi_bpm' => $request->lokasi_bdi,
            'nama_kpp' => $request->nama_kpp,
            'anggota_pria' => $request->anggota_pria,
            'anggota_wanita' => $request->anggota_wanita,
            'anggota_miskin' => $request->anggota_miskin,
        ]);

        return redirect('/kpp/' . $id);
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



    public function monitoring()
    {
        $kppExist = DB::table('kpp_data_view');
        $bdiVillages = DB::table('bdi_villages');
        $BDIs = $bdiVillages->get();
        $bdiKPP = DB::table('kpp_data_view')->join('bdi_villages', 'kpp_data_view.KD_KEL', '=', 'bdi_villages.KD_KEL')->pluck('kpp_data_view.KD_KEL');
        $noBDI = $kppExist->whereNotIn('KD_KEL', $bdiKPP)->get();
        $noKPPs = $bdiVillages->whereNotIn('bdi_villages.KD_KEL', $bdiKPP)->join('allvillages', 'bdi_villages.KD_KEL', '=', 'allvillages.KD_KEL')->get();
        $PICs = DB::table('job_descs')->join('users', 'users.id', '=', 'job_descs.user_id')->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')->join('personalInformations', 'personalInformations.nik', '=', 'users.nik')->get();
        return view('kpp.monitoring', compact(['noKPPs', 'BDIs', 'PICs']));
    }



    public function spotCheck()
    {
        $spotChecks = DB::table('data_pengecekan_fisiks')->join('allvillages', 'allvillages.KD_KEL', '=', 'data_pengecekan_fisiks.kelurahan_id')->get();
        $kppdatas = kppdata::get();
        return view('kpp.SpotCheckKPP', compact(['spotChecks', 'kppdatas']));
    }


    public function maintenance()
    {
        $kppdatas = kppdata::get();
        $maintenances = infrastruktures_maintenance::join('allvillages', 'allvillages.KD_KEL', '=', 'infrastruktures_maintenances.kelurahan_id')->get();
        return view('kpp.KPPmaintenance', compact(['maintenances', 'kppdatas']));
    }


    public function bop()
    {
        $kppdatas = kppdata::get();
        $BOPs = kpp_operating_fund::join('allvillages', 'allvillages.KD_KEL', '=', 'kpp_operating_funds.kelurahan_id')->get();

        return view('kpp.KPPoperatingFund', compact(['BOPs', 'kppdatas']));
    }

    public function meeting()
    {
        $kppdatas = kppdata::get();
        $meetings = kpp_pertemuan::join('allvillages', 'allvillages.KD_KEL', '=', 'kpp_pertemuans.kelurahan_id')->get();
        return view('kpp.KPPmeeting', compact(['kppdatas', 'meetings']));
    }


    // ========================= EXPORT TO EXCEL ========================================


    public function export()
    {
        return Excel::download(new UsersExport(), 'Data_KPP_' . date('Y-m-d_H:i:s') . '.xlsx');
    }



    public function exportRekapKabupaten()
    {
        return Excel::download(new Rekap_kpp_per_kabupaten, 'Rekap_KPP_Per_Kabupaten_' . date('Y-m-d_H:i:s') . '.xlsx');
    }



    public function exportRekapKecamatan($KAB)
    {

        $kppdatas = $this->rekap1()->groupBy('KD_KEC')->where('KD_KAB', $KAB)->get();
        return Excel::download(new Rekap_kpp_per_kecamatan($kppdatas), 'Rekap_KPP_Per_Kecamatan_' . date('Y-m-d_H:i:s') . '.xlsx');
    }



    public function exportRekapKelurahan($KEC)
    {
        $kppdatas = $this->rekap2()->groupBy('KD_KEL')->where('KD_KEC', $KEC)->get();
        return Excel::download(new Rekap_kpp_per_kelurahan($kppdatas), 'Rekap_KPP_Per_Kelurahan_' . date('Y-m-d_H:i:s') . '.xlsx');
    }


    // ================== REKAP FUNCTION ==================



    public function rekap_all()
    {
        $kabupaten = $this->myzone();
        $rekapkpp =  $this->rekap1()->get();
        $kppdatas = $this->rekap()->whereIn('KD_KAB', $kabupaten)->groupBy('KD_KAB')->get();

        return view('kpp.rekap.kabupaten', compact(['kabupaten', 'kppdatas', 'rekapkpp']));
    }

    public function rekap_kecamatan($KD_KAB)
    {

        $kabupaten = $this->myzone();
        $rekapkpp =  $this->rekap1()->groupBy('KD_KAB')->where('KD_KAB', $KD_KAB)->get();
        $kppdatas = $this->rekap()->groupBy('KD_KEC')->where('KD_KAB', $KD_KAB)->get();

        return view('kpp.rekap.kecamatan', compact(['kabupaten', 'kppdatas', 'rekapkpp']));
    }

    public function rekap_kelurahan($KD_KEC)
    {
        $rekapkpp = $this->rekap1()->groupBy('KD_KEC')->where('KD_KEC', $KD_KEC)->get();
        $kppdatas = $this->rekap()->groupBy('KD_KEL')->where('KD_KEC', $KD_KEC)->get();
        $kabupaten = $this->myzone();

        return view('kpp.rekap.kelurahan', compact(['kabupaten', 'kppdatas', 'rekapkpp']));
    }

    public function rekap_item($column, $param)
    {
        return DB::table('kpp_data_view')->where($column, $param)->get();
    }

    public function rekap_item_zone($column, $param, $zone, $zone_id)
    {
        $nothing = DB::table('kpp_data_view')->where($zone, $zone_id)
            ->where($column, '!=', 'Ada')->get();
        $noPertemuanRutin = DB::table('kpp_data_view')->WhereNull($column)->where($zone, $zone_id)
            ->orWhereNotIn($column, ['Setiap Bulan', 'Setiap Tiga Bulan', 'Setiap Enam Bulan', 'Insidentil'])
            ->where($zone, $zone_id)->get();

        $noAdministrasiRutin = DB::table('kpp_data_view')
            ->WhereNull($column)->where($zone, $zone_id)
            ->orWhereNotIn($column, ['Administrasi Bulanan Lengkap', 'Administrasi Bulanan Minimalis', 'Administrasi Triwulan/Selebihnya'])
            ->where($zone, $zone_id)->get();

        $noKegiatanPengecekan = DB::table('kpp_data_view')
            ->WhereNull($column)->where($zone, $zone_id)
            ->orWhereNotIn($column, ['Belum Dilakukan', 'Sudah Dilakukan'])
            ->where($zone, $zone_id)->get();

        $kegiatanPerbaikan = DB::table('kpp_data_view')
            ->where($column, '>', 0)
            ->where($zone, $zone_id)
            ->get();
        $kppdatas = DB::table('kpp_data_view')->where($zone, $zone_id)->where($column, $param)->get();
        return view('kpp.detail.index', compact(['kppdatas', 'noPertemuanRutin', 'nothing', 'zone_id', 'column', 'param', 'noAdministrasiRutin', 'noKegiatanPengecekan', 'kegiatanPerbaikan']));
    }


    public function rekap_administrasi_rutin($zone, $zone_id)
    {
        $column = 'administrasi_rutin';
        $param = 'Administrasi Triwulan/Selebihnya';
        $kppdatas = DB::table('kpp_data_view')->where($zone, $zone_id)->where('administrasi_rutin', 'Administrasi Triwulan/Selebihnya')->get();
        return view('kpp.detail.index', compact(['kppdatas', 'zone_id', 'column', 'param']));
    }

    public function rekap()
    {

        return DB::table('kpp_data_view')->selectRaw('*, count(*) as jml_kpp,
				SUM(CASE WHEN Status  = "Perlu Perhatian" Then 1 ELSE 0 END) as perlu_perhatian, 
				SUM(CASE WHEN Status  = "Awal" Then 1 ELSE 0 END) as awal, 
				SUM(CASE WHEN Status  = "Terbangun" Then 1 ELSE 0 END) as terbangun, 
				SUM(CASE WHEN Status  = "Berdaya" Then 1 ELSE 0 END) as berdaya, 
				SUM(CASE WHEN Status  = "Mandiri" Then 1 ELSE 0 END) as mandiri,
				SUM(anggota_pria) as jml_pria,
				SUM(anggota_wanita) as jml_wanita,
				SUM(anggota_miskin) as jml_miskin,
				SUM(CASE WHEN struktur_organisasi = "Ada" THEN 1 ELSE 0 END) as jml_struktur_organisasi,
				SUM(CASE WHEN anggaran_dasar = "Ada" THEN 1 ELSE 0 END) as jml_anggaran_dasar,
				SUM(CASE WHEN anggaran_rumah_tangga = "Ada" THEN 1 ELSE 0 END) as jml_anggaran_rumah_tangga,
				SUM(CASE WHEN surat_keputusan = "Ada" THEN 1 ELSE 0 END) as jml_surat_keputusan,
                SUM(CASE WHEN rencana_kerja = "Ada" THEN 1 ELSE 0 END) as jml_rencana_kerja,
				SUM(CASE WHEN pertemuan_rutin = "Setiap Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_bulan,
                SUM(CASE WHEN pertemuan_rutin = "Setiap Tiga Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_tiga_bulan,
			    SUM(CASE WHEN pertemuan_rutin = "Setiap Enam Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_enam_bulan,
				SUM(CASE WHEN pertemuan_rutin = "Insidentil (sesuai kebutuhan)" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_insidentil,
                count(*) - SUM(CASE WHEN pertemuan_rutin = "Setiap Bulan" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN pertemuan_rutin = "Setiap Tiga Bulan" THEN 1 ELSE 0 END) -
			    SUM(CASE WHEN pertemuan_rutin = "Setiap Enam Bulan" THEN 1 ELSE 0 END) -
				SUM(CASE WHEN pertemuan_rutin = "Insidentil (sesuai kebutuhan)" THEN 1 ELSE 0 END) jml_pertemuan_rutin_tidak_pernah,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 ELSE 0 END) as jml_administrasi_bulanan_lengkap,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 ELSE 0 END) as jml_administrasi_bulanan_minimalis,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END) as jml_administrasi_triwulan,
                count(*) - SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END) as jml_administrasi_tidak_ada,
                SUM(CASE WHEN buku_inventaris_kegiatan = "Ada" THEN 1 ELSE 0 END) as jml_buku_inventaris_kegiatan,
                SUM(CASE WHEN bop = "Ada" THEN 1 ELSE 0 END) as jml_bop,
                SUM(jumlah_bop) as jml_dana_bop,
                count(*) - SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) -
 				SUM(CASE WHEN kegiatan_pengecekan = "Sudah Dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_pernah, 				
                SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_dilakukan,
                SUM(CASE WHEN kegiatan_pengecekan = "Sudah Dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_sudah_dilakukan,
                SUM(jumlah_kegiatan_perbaikan) as jml_kegiatan_perbaikan,
                SUM(jumlah_dana_perbaikan) as jml_dana_perbaikan
		');
    }


    public function rekap1()
    {
        return DB::table('kpp_data_view')->selectRaw('NAMA_KAB, NAMA_KEC, count(*) as jml_kpp,
				SUM(CASE WHEN Status  = "Perlu Perhatian" Then 1 ELSE 0 END) as perlu_perhatian, 
				SUM(CASE WHEN Status  = "Awal" Then 1 ELSE 0 END) as awal, 
				SUM(CASE WHEN Status  = "Terbangun" Then 1 ELSE 0 END) as terbangun, 
				SUM(CASE WHEN Status  = "Berdaya" Then 1 ELSE 0 END) as berdaya, 
				SUM(CASE WHEN Status  = "Mandiri" Then 1 ELSE 0 END) as mandiri,
				SUM(anggota_pria) as jml_pria,
				SUM(anggota_wanita) as jml_wanita,
				SUM(anggota_miskin) as jml_miskin,
				SUM(CASE WHEN struktur_organisasi = "Ada" THEN 1 ELSE 0 END) as jml_struktur_organisasi,
				SUM(CASE WHEN anggaran_dasar = "Ada" THEN 1 ELSE 0 END) as jml_anggaran_dasar,
				SUM(CASE WHEN anggaran_rumah_tangga = "Ada" THEN 1 ELSE 0 END) as jml_anggaran_rumah_tangga,
				SUM(CASE WHEN surat_keputusan = "Ada" THEN 1 ELSE 0 END) as jml_surat_keputusan,
                SUM(CASE WHEN rencana_kerja = "Ada" THEN 1 ELSE 0 END) as jml_rencana_kerja,
				SUM(CASE WHEN pertemuan_rutin = "Setiap Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_bulan,
                SUM(CASE WHEN pertemuan_rutin = "Setiap Tiga Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_tiga_bulan,
			    SUM(CASE WHEN pertemuan_rutin = "Setiap Enam Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_enam_bulan,
				SUM(CASE WHEN pertemuan_rutin = "Insidentil (sesuai kebutuhan)" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_insidentil,
                count(*) - SUM(CASE WHEN pertemuan_rutin = "Setiap Bulan" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN pertemuan_rutin = "Setiap Tiga Bulan" THEN 1 ELSE 0 END) -
			    SUM(CASE WHEN pertemuan_rutin = "Setiap Enam Bulan" THEN 1 ELSE 0 END) -
				SUM(CASE WHEN pertemuan_rutin = "Insidentil (sesuai kebutuhan)" THEN 1 ELSE 0 END) jml_pertemuan_rutin_tidak_pernah,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 ELSE 0 END) as jml_administrasi_bulanan_lengkap,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 ELSE 0 END) as jml_administrasi_bulanan_minimalis,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END) as jml_administrasi_triwulan,
                count(*) - SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END) as jml_administrasi_tidak_ada,
                SUM(CASE WHEN buku_inventaris_kegiatan = "Ada" THEN 1 ELSE 0 END) as jml_buku_inventaris_kegiatan,
                SUM(CASE WHEN bop = "Ada" THEN 1 ELSE 0 END) as jml_bop,
                SUM(jumlah_bop) as jml_dana_bop,
                count(*) - SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) -
 				SUM(CASE WHEN kegiatan_pengecekan = "Sudah Dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_pernah,
                SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_dilakukan,
                SUM(CASE WHEN kegiatan_pengecekan = "sudah Dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_sudah_dilakukan,
                SUM(jumlah_kegiatan_perbaikan) as jml_kegiatan_perbaikan,
                SUM(jumlah_dana_perbaikan) as jml_dana_perbaikan
		');
    }


    public function rekap2()
    {
        return DB::table('kpp_data_view')->selectRaw('NAMA_KAB, NAMA_KEC, NAMA_DESA,  count(*) as jml_kpp, Status,
				SUM(anggota_pria) as jml_pria,
				SUM(anggota_wanita) as jml_wanita,
				SUM(anggota_miskin) as jml_miskin,
				SUM(CASE WHEN struktur_organisasi = "Ada" THEN 1 ELSE 0 END) as jml_struktur_organisasi,
				SUM(CASE WHEN anggaran_dasar = "Ada" THEN 1 ELSE 0 END) as jml_anggaran_dasar,
				SUM(CASE WHEN anggaran_rumah_tangga = "Ada" THEN 1 ELSE 0 END) as jml_anggaran_rumah_tangga,
				SUM(CASE WHEN surat_keputusan = "Ada" THEN 1 ELSE 0 END) as jml_surat_keputusan,
                SUM(CASE WHEN rencana_kerja = "Ada" THEN 1 ELSE 0 END) as jml_rencana_kerja,
				SUM(CASE WHEN pertemuan_rutin = "Setiap Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_bulan,
                SUM(CASE WHEN pertemuan_rutin = "Setiap Tiga Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_tiga_bulan,
			    SUM(CASE WHEN pertemuan_rutin = "Setiap Enam Bulan" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_setiap_enam_bulan,
				SUM(CASE WHEN pertemuan_rutin = "Insidentil (sesuai kebutuhan)" THEN 1 ELSE 0 END) as jml_pertemuan_rutin_insidentil,
                count(*) - SUM(CASE WHEN pertemuan_rutin = "Setiap Bulan" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN pertemuan_rutin = "Setiap Tiga Bulan" THEN 1 ELSE 0 END) -
			    SUM(CASE WHEN pertemuan_rutin = "Setiap Enam Bulan" THEN 1 ELSE 0 END) -
				SUM(CASE WHEN pertemuan_rutin = "Insidentil (sesuai kebutuhan)" THEN 1 ELSE 0 END) jml_pertemuan_rutin_tidak_pernah,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 ELSE 0 END) as jml_administrasi_bulanan_lengkap,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 ELSE 0 END) as jml_administrasi_bulanan_minimalis,
                SUM(CASE WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END) as jml_administrasi_triwulan,
                count(*) - SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 ELSE 0 END) -
                SUM(CASE WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END) as jml_administrasi_tidak_ada,
                SUM(CASE WHEN buku_inventaris_kegiatan = "Ada" THEN 1 ELSE 0 END) as jml_buku_inventaris_kegiatan,
                SUM(CASE WHEN bop = "Ada" THEN 1 ELSE 0 END) as jml_bop,
                SUM(jumlah_bop) as jml_dana_bop,
                count(*) - SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) -
 				SUM(CASE WHEN kegiatan_pengecekan = "sudah_dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_pernah,
                SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_dilakukan,
                SUM(CASE WHEN kegiatan_pengecekan = "sudah_dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_sudah_dilakukan,
                SUM(jumlah_kegiatan_perbaikan) as jml_kegiatan_perbaikan,
                SUM(jumlah_dana_perbaikan) as jml_dana_perbaikan
		');
    }


    // =========================================== AJAX =====================================================================

    public function searchIndex(Request $request)
    {
        $BOPs = kpp_operating_fund::get();
        $kppdatas = $this->coba2()->leftjoin('infrastruktures_maintenances', 'infrastruktures_maintenances.kelurahan_id', '=', 'kppdatas.kode_desa')->groupBy('kppdatas.kode_desa')->where('NAMA_DESA', 'like', '%' . $request->kelurahan . '%')->orderBy('kppdatas.updated_at', 'desc')->get();

        return response()->json([$kppdatas, $BOPs]);
    }



    // ====================================== custom function ===============================================================

    public function kppdata()
    {
        return  kppdata::join('allvillages', 'kppdatas.kode_desa', '=', 'allvillages.KD_KEL')
            ->join('bkmdatas', 'kppdatas.kode_desa', '=', 'bkmdatas.kelurahan_id')
            ->join('pengurus_kpps', 'kppdatas.kode_desa', '=', 'pengurus_kpps.kelurahan_id')
            ->join('users', 'kppdatas.user_id', '=', 'users.id')
            ->select(
                'kppdatas.id',
                'allvillages.KD_KAB',
                'allvillages.NAMA_KAB',
                'allvillages.NAMA_KEC',
                'allvillages.KD_KEL',
                'allvillages.NAMA_DESA',
                'kppdatas.lokasi_bdi_bpm',
                'kppdatas.nama_kpp',
                'kppdatas.anggota_pria',
                'kppdatas.anggota_wanita',
                'kppdatas.anggota_miskin',
                'kppdatas.struktur_organisasi',
                'kppdatas.scan_struktur_organisasi',
                'kppdatas.anggaran_dasar',
                'kppdatas.scan_anggaran_dasar',
                'kppdatas.anggaran_rumah_tangga',
                'kppdatas.scan_anggaran_rumah_tangga',
                'kppdatas.surat_keputusan',
                'kppdatas.scan_surat_keputusan',
                'kppdatas.rencana_kerja',
                'kppdatas.scan_rencana_kerja',
                'kppdatas.pertemuan_rutin',
                'kppdatas.administrasi_rutin',
                'kppdatas.scan_administrasi_rutin',
                'kppdatas.buku_inventaris_kegiatan',
                'kppdatas.scan_buku_inventaris_kegiatan',
                'kppdatas.kegiatan_pengecekan',
                'kppdatas.keterangan_lain_lain',
                'users.name',
                'bkmdatas.bkm',
                'pengurus_kpps.ketua_kpp',
                'pengurus_kpps.ketua_kpp_hp'
            )
            ->whereIn('KD_KAB', explode(', ', str_replace(
                array('["',  '"]'),
                '',
                DB::table('work_zones')
                    ->where('id', function ($query) {
                        $query->select('work_zone_id')
                            ->from('job_descs')
                            ->where('user_id', Auth::user()->id)
                            ->get()
                            ->pluck('work_zone_id');
                    })->get()
                    ->pluck('zone')
            )));
    }


    public function coba2()
    {
        return kppdata::select("*", 'kppdatas.id', \DB::raw('
            CASE
            WHEN
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "kegiatan_pengecekan" AND skor_kpp.criteria = kppdatas.kegiatan_pengecekan) = 2 THEN 2 ELSE 0 END
                    +
                    CASE WHEN (select count(*) from infrastruktures_maintenances) > 0 THEN 2 ELSE 0 END  
                    > 3, 2, 0)
                +
                IF(                    
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "administrasi_rutin" AND skor_kpp.criteria = kppdatas.administrasi_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "buku_inventaris_kegiatan" AND skor_kpp.criteria = kppdatas.buku_inventaris_kegiatan) = 2 THEN 2 ELSE 0 END
                    +
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "pertemuan_rutin" AND skor_kpp.criteria = kppdatas.pertemuan_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "bop" AND skor_kpp.criteria = kppdatas.bop) = 2 THEN 2 ELSE 0 END
                    = 8, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0
                )
                +
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 10  THEN "Mandiri" 

            WHEN
                IF(
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "administrasi_rutin" AND skor_kpp.criteria = kppdatas.administrasi_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "buku_inventaris_kegiatan" AND skor_kpp.criteria = kppdatas.buku_inventaris_kegiatan) = 2 THEN 2 ELSE 0 END
                    +
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "pertemuan_rutin" AND skor_kpp.criteria = kppdatas.pertemuan_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "bop" AND skor_kpp.criteria = kppdatas.bop) = 2 THEN 2 ELSE 0 END
                    = 8, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0
                )
                +
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 8  THEN "Berdaya" 
            WHEN
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0
                )
                +
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 6 THEN "Terbangun" 
            WHEN 
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 4 THEN "Awal" 
            WHEN 
                (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2
                THEN "Perlu Perhatian"
            ELSE "Perlu Perhatian" 
			END As Status
			'))
            ->join('allvillages', 'kppdatas.kode_desa', '=', 'allvillages.KD_KEL')
            ->join('bkmdatas', 'kppdatas.kode_desa', '=', 'bkmdatas.kelurahan_id')
            ->join('pengurus_kpps', 'kppdatas.kode_desa', '=', 'pengurus_kpps.kelurahan_id')
            ->join('users', 'kppdatas.user_id', '=', 'users.id')
            ->whereIn('KD_KAB', explode(', ', str_replace(
                array('["',  '"]'),
                '',
                DB::table('work_zones')
                    ->where('id', function ($query) {
                        $query->select('work_zone_id')
                            ->from('job_descs')
                            ->where('user_id', Auth::user()->id)
                            ->get()
                            ->pluck('work_zone_id');
                    })->get()
                    ->pluck('zone')
            )));
    }

    public function coba3()
    {
        return kppdata::select(
            "*",
            'kppdatas.id',
            \DB::raw('
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) as ad
                '),
            \DB::raw(' 
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) as art
                '),
            \DB::raw('
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) as struktur
                '),
            \DB::raw('
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan) as sk
                    '),
            \DB::raw('


                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                ) 


                   as skr_awal
                '),
            \DB::raw('
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )  as skr_str
                '),
            \DB::raw('


            CASE
            WHEN
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "kegiatan_pengecekan" AND skor_kpp.criteria = kppdatas.kegiatan_pengecekan) = 2 THEN 2 ELSE 0 END
                    +
                    CASE WHEN (select count(*) from infrastruktures_maintenances) > 0 THEN 2 ELSE 0 END  
                    > 3, 2, 0)
                +
                IF(                    
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "administrasi_rutin" AND skor_kpp.criteria = kppdatas.administrasi_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "buku_inventaris_kegiatan" AND skor_kpp.criteria = kppdatas.buku_inventaris_kegiatan) = 2 THEN 2 ELSE 0 END
                    +
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "pertemuan_rutin" AND skor_kpp.criteria = kppdatas.pertemuan_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "bop" AND skor_kpp.criteria = kppdatas.bop) = 2 THEN 2 ELSE 0 END
                    = 8, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0
                )
                +
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 10  THEN "Mandiri" 

            WHEN
                IF(
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "administrasi_rutin" AND skor_kpp.criteria = kppdatas.administrasi_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "buku_inventaris_kegiatan" AND skor_kpp.criteria = kppdatas.buku_inventaris_kegiatan) = 2 THEN 2 ELSE 0 END
                    +
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "pertemuan_rutin" AND skor_kpp.criteria = kppdatas.pertemuan_rutin) = 2 THEN 2 ELSE 0 END
                    +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "bop" AND skor_kpp.criteria = kppdatas.bop) = 2 THEN 2 ELSE 0 END
                    = 8, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0
                )
                +
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 8  THEN "Berdaya" 
            WHEN
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "rencana_kerja" AND skor_kpp.criteria = kppdatas.rencana_kerja) = 2, 2, 0
                )
                +
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 6 THEN "Terbangun" 


            WHEN 
                IF(
                    CASE
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) = 1 THEN 1 ELSE 0 END 
                +
                    CASE 
                        WHEN
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) = 1 THEN 1 ELSE 0 END
                +
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan)
                    > 1, 2, 0
                )
                +
                IF(
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2, 2, 0
                )
                 = 4 THEN "Awal" 
            WHEN 
                (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) = 2
                THEN "Perlu Perhatian"
            ELSE "Perlu Perhatian" 
			END As Status 
			')
        )
            ->join('allvillages', 'kppdatas.kode_desa', '=', 'allvillages.KD_KEL')
            ->join('bkmdatas', 'kppdatas.kode_desa', '=', 'bkmdatas.kelurahan_id')
            ->join('pengurus_kpps', 'kppdatas.kode_desa', '=', 'pengurus_kpps.kelurahan_id')
            ->join('users', 'kppdatas.user_id', '=', 'users.id')
            ->whereIn('KD_KAB', explode(', ', str_replace(
                array('["',  '"]'),
                '',
                DB::table('work_zones')
                    ->where('id', function ($query) {
                        $query->select('work_zone_id')
                            ->from('job_descs')
                            ->where('user_id', Auth::user()->id)
                            ->get()
                            ->pluck('work_zone_id');
                    })->get()
                    ->pluck('zone')
            )));
    }

    public function test()
    {
        return DB::table('kpp_view')->get();
    }

    public function backup()
    {
        return $kppdatas = DB::table('kpp_data_view')->groupBy('KD_KAB')->selectRaw('*, count(*) as jml_kpp,
				SUM(CASE WHEN Status  = "Perlu Perhatian" Then 1 ELSE 0 END) as perlu_perhatian, 
				SUM(CASE WHEN Status  = "Awal" Then 1 ELSE 0 END) as awal, 
				SUM(CASE WHEN Status  = "Terbangun" Then 1 ELSE 0 END) as terbangun, 
				SUM(CASE WHEN Status  = "Berdaya" Then 1 ELSE 0 END) as berdaya, 
				SUM(CASE WHEN Status  = "Mandiri" Then 1 ELSE 0 END) as mandiri,
				SUM(anggota_pria) as jml_pria,
				SUM(anggota_wanita) as jml_wanita,
				SUM(anggota_miskin) as jml_miskin,
				SUM(CASE WHEN struktur_organisasi = "Ada" THEN 1 ELSE 0 END) as jml_struktur_organisasi,
				SUM(CASE WHEN anggaran_dasar = "Ada" THEN 1 ELSE 0 END) as jml_anggaran_dasar,
				SUM(CASE WHEN anggaran_rumah_tangga = "Ada" THEN 1 ELSE 0 END) as jml_anggaran_rumah_tangga,
				SUM(CASE WHEN surat_keputusan = "Ada" THEN 1 ELSE 0 END) as jml_surat_keputusan,
				SUM(CASE WHEN rencana_kerja = "Ada" THEN 1 ELSE 0 END) as jml_rencana_kerja,
                SUM(CASE WHEN buku_inventaris_kegiatan = "Ada" THEN 1 ELSE 0 END) as jml_buku_inventaris_kegiatan,
                SUM(CASE WHEN bop = "Ada" THEN 1 ELSE 0 END) as jml_bop,
                count(*) - SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) -
 				SUM(CASE WHEN kegiatan_pengecekan = "sudah_dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_pernah,
                SUM(CASE WHEN kegiatan_pengecekan = "Belum Dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_belum_dilakukan,
				SUM(CASE WHEN kegiatan_pengecekan = "sudah_dilakukan" THEN 1 ELSE 0 END) as jml_pengecekan_sudah_dilakukan
		')->get();

        $kabupaten = alldistrict::whereIn('kode_kab', explode(', ', str_replace(
            array('["',  '"]'),
            '',
            DB::table('work_zones')
                ->where('id', function ($query) {
                    $query->select('work_zone_id')
                        ->from('job_descs')
                        ->where('user_id', Auth::user()->id)
                        ->get()
                        ->pluck('work_zone_id');
                })->get()
                ->pluck('zone')
        )))->get();

        return view('kpp.rekap', compact(['kabupaten', 'kppdatas']));
    }



    public function downloadFotoPengecekanFisik($id)
    {
        return Storage::disk('local')->directories('/storage/kpp');
        $file = data_pengecekan_fisik::find($id)->pluck('foto_pengecekan_fisik')->first();
        Storage::disk('public')->download('kpp/' . $file);
    }


    public function master()
    {
        return kppdata::join('allvillages', 'allvillages.KD_KEL', '=', 'kppdatas.kode_desa')->select(
            'kppdatas.id',
            'kppdatas.nama_kpp',
            'kppdatas.kode_desa',
            'allvillages.NAMA_DESA',
            'kppdatas.anggaran_dasar',
            'kppdatas.anggaran_rumah_tangga',
            'kppdatas.surat_Keputusan',
            \DB::raw('
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) as ad
                '),
            \DB::raw(' 
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "c" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) as art
                    
                '),
            \DB::raw('
                        (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan) as sk
                        '),
            \DB::raw('(select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_dasar" AND skor_kpp.criteria = kppdatas.anggaran_dasar) +   (select skor_kpp.scor from skor_kpp where skor_kpp.items = "anggaran_rumah_tangga" AND skor_kpp.criteria = kppdatas.anggaran_rumah_tangga) + (select skor_kpp.scor from skor_kpp where skor_kpp.items = "surat_keputusan" AND skor_kpp.criteria = kppdatas.surat_keputusan) as skor_awal'),
            \DB::raw('
                    (select skor_kpp.scor from skor_kpp where skor_kpp.items = "struktur_organisasi" AND skor_kpp.criteria = kppdatas.struktur_organisasi) as struktur
                '),
        )->get();
    }

    public function coba4()
    {
        return $this->master();
    }

    public function create_view()
    {
        /*
        CREATE VIEW tipe_nomor_data_kpp AS SELECT id, surat_keputusan, IF(surat_keputusan = "Ada", 2, 0) as skor_surat_keputusan  FROM kppdatas;

        =======================================================================================================================================

        CREATE OR REPLACE VIEW data_kpp_perbaikan AS SELECT kppdatas.id, kode_desa,
        COUNT(CASE WHEN infrastruktures_maintenances.kelurahan_id = kppdatas.kode_desa THEN infrastruktures_maintenances.jumlah END) AS jumlah_kegiatan,
        SUM(CASE WHEN infrastruktures_maintenances.kelurahan_id = kppdatas.kode_desa THEN infrastruktures_maintenances.jumlah END) AS jumlah_dana
        FROM kppdatas, infrastruktures_maintenances
        GROUP BY kppdatas.kode_desa

        =======================================================================================================================================

        CREATE OR REPLACE VIEW data_kpp_pengecekan AS SELECT kppdatas.id, kode_desa,
        COUNT(CASE WHEN data_pengecekan_fisiks.kelurahan_id = kppdatas.kode_desa THEN data_pengecekan_fisiks.tanggal END) AS jumlah_pengecekan
        FROM kppdatas, data_pengecekan_fisiks
        GROUP BY kppdatas.kode_desa

        =======================================================================================================================================

        CREATE OR REPLACE VIEW data_kpp_bop AS SELECT kppdatas.id, kode_desa, 
        SUM(CASE WHEN kpp_operating_funds.kelurahan_id = kppdatas.kode_desa THEN kpp_operating_funds.jumlah END) AS jumlah_bop
        FROM kppdatas, kpp_operating_funds
        GROUP BY kppdatas.kode_desa

        =======================================================================================================================================

        CREATE OR REPLACE VIEW kpp_data_view AS (
            SELECT KD_KAB, NAMA_KAB, KD_KEC, NAMA_KEC, NAMA_DESA, "1" as jumlah_kpp, kppdatas.kode_desa as KD_KEL, pengurus_kpps.ketua_kpp, pengurus_kpps.ketua_kpp_hp,  kppdatas.*, 
            IF(struktur_organisasi = "Ada", 4, 0) as skor_struktur_organisasi,
            IF(anggaran_dasar = "Ada", 4, 0) as skor_anggaran_dasar,
            IF(anggaran_rumah_tangga = "Ada", 4, 0) as skor_anggaran_rumah_tangga, 
            IF(surat_keputusan = "Ada", 4, 0) as skor_surat_keputusan,
            IF(rencana_kerja = "Ada", 4, 0) as skor_rencana_kerja,
            CASE WHEN pertemuan_rutin  = "Setiap Bulan" Then 1 WHEN pertemuan_rutin  = "Setiap Tiga Bulan" Then 1  WHEN pertemuan_rutin  = "Setiap Enam Bulan" Then 1 WHEN pertemuan_rutin  = "Insidentil (sesuai kebutuhan)" Then 0 WHEN pertemuan_rutin  = "Tidak Pernah (dalam satu tahun)" THEN 0 ELSE 0 END as skor_pertemuan_rutin,
            CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END as skor_administrasi_rutin,
            CASE WHEN buku_inventaris_kegiatan = "Ada" THEN 1 ELSE 0 END as skor_buku_inventaris_kegiatan, data_kpp_bop.jumlah_bop, data_kpp_pengecekan.jumlah_pengecekan, data_kpp_perbaikan.jumlah_kegiatan as jumlah_kegiatan_perbaikan, data_kpp_perbaikan.jumlah_dana as jumlah_dana_perbaikan,

            IF(struktur_organisasi = "Ada", 4, 0) as perlu_perhatian,
            CASE WHEN IF(anggaran_dasar = "Ada", 4, 0) + IF(anggaran_rumah_tangga = "Ada", 4, 0) + IF(surat_keputusan = "Ada", 4, 0) > 3 THEN 4 ELSE 0 END as Awal,
            IF(rencana_kerja = "Ada", 4, 0) as Terbangun,
            IF(CASE WHEN pertemuan_rutin  = "Setiap Bulan" Then 1 WHEN pertemuan_rutin  = "Setiap Tiga Bulan" Then 1  WHEN pertemuan_rutin  = "Setiap Enam Bulan" Then 1 WHEN pertemuan_rutin  = "Insidentil (sesuai kebutuhan)" Then 0 WHEN pertemuan_rutin  = "Tidak Pernah (dalam satu tahun)" THEN 0 ELSE 0 END + CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END + CASE WHEN buku_inventaris_kegiatan = "Ada" THEN 1 ELSE 0 END + IF( data_kpp_bop.jumlah_bop > 0, 1, 0) > 3, 4, 0) AS Berdaya,
            CASE WHEN IF(data_kpp_pengecekan.jumlah_pengecekan > 0, 2, 0) + IF(data_kpp_perbaikan.jumlah_kegiatan > 0, 2, 0)  > 3 THEN 4 ELSE 0 END AS Mandiri, 

            CASE 
            WHEN 
                IF(struktur_organisasi = "Ada", 4, 0) + 
                CASE WHEN IF(anggaran_dasar = "Ada", 4, 0) + IF(anggaran_rumah_tangga = "Ada", 4, 0) + IF(surat_keputusan = "Ada", 4, 0) > 3 THEN 4 ELSE 0 END + IF(rencana_kerja = "Ada", 4, 0) +  CASE WHEN pertemuan_rutin  = "Setiap Bulan" Then 1 WHEN pertemuan_rutin  = "Setiap Tiga Bulan" Then 1  WHEN pertemuan_rutin  = "Setiap Enam Bulan" Then 1 WHEN pertemuan_rutin  = "Insidentil (sesuai kebutuhan)" Then 0 WHEN pertemuan_rutin  = "Tidak Pernah (dalam satu tahun)" THEN 0 ELSE 0 END + CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END + CASE WHEN buku_inventaris_kegiatan = "Ada" THEN 1 ELSE 0 END + IF(data_kpp_bop.jumlah_bop > 0, 1, 0) + CASE WHEN IF(data_kpp_pengecekan.jumlah_pengecekan > 0, 2, 0) + IF(data_kpp_perbaikan.jumlah_kegiatan > 0, 2, 0)  > 3 THEN 4 ELSE 0 END = 20 THEN "Mandiri"
            WHEN 
                IF(struktur_organisasi = "Ada", 4, 0) + 
                CASE WHEN IF(anggaran_dasar = "Ada", 4, 0) + IF(anggaran_rumah_tangga = "Ada", 4, 0) + IF(surat_keputusan = "Ada", 4, 0) > 3 THEN 4 ELSE 0 END + IF(rencana_kerja = "Ada", 4, 0) +  CASE WHEN pertemuan_rutin  = "Setiap Bulan" Then 1 WHEN pertemuan_rutin  = "Setiap Tiga Bulan" Then 1  WHEN pertemuan_rutin  = "Setiap Enam Bulan" Then 1 WHEN pertemuan_rutin  = "Insidentil (sesuai kebutuhan)" Then 0 WHEN pertemuan_rutin  = "Tidak Pernah (dalam satu tahun)" THEN 0 ELSE 0 END + CASE WHEN administrasi_rutin = "Administrasi Bulanan Minimalis" THEN 1 WHEN administrasi_rutin = "Administrasi Bulanan Lengkap" THEN 1 WHEN administrasi_rutin = "Administrasi Triwulan/Selebihnya" THEN 1 ELSE 0 END + CASE WHEN buku_inventaris_kegiatan = "Ada" THEN 1 ELSE 0 END + IF(data_kpp_bop.jumlah_bop > 0, 1, 0) = 16 THEN "Berdaya" 
            WHEN 
                IF(struktur_organisasi = "Ada", 4, 0) + 
                CASE WHEN IF(anggaran_dasar = "Ada", 4, 0) + IF(anggaran_rumah_tangga = "Ada", 4, 0) + IF(surat_keputusan = "Ada", 4, 0) > 3 THEN 4 ELSE 0 END + IF(rencana_kerja = "Ada", 4, 0) = 12 THEN "Terbangun" 
            WHEN  
                IF(struktur_organisasi = "Ada", 4, 0) + 
                CASE WHEN IF(anggaran_dasar = "Ada", 4, 0) + IF(anggaran_rumah_tangga = "Ada", 4, 0) + IF(surat_keputusan = "Ada", 4, 0) > 3 THEN 4 ELSE 0 END = 8 THEN "Awal"
            ELSE "Perlu Perhatian" 
            END as Status            
            FROM kppdatas 
            LEFT JOIN  data_kpp_pengecekan
            ON kppdatas.kode_desa=data_kpp_pengecekan.kode_desa
            LEFT JOIN data_kpp_perbaikan 
            ON kppdatas.kode_desa=data_kpp_perbaikan.kode_desa
            LEFT JOIN data_kpp_bop
            ON kppdatas.kode_desa=data_kpp_bop.kode_desa
            LEFT JOIN allvillages
            ON kppdatas.kode_desa=allvillages.KD_KEL
            LEFT JOIN pengurus_kpps
            ON kppdatas.kode_desa=pengurus_kpps.kelurahan_id
            GROUP BY kppdatas.kode_desa
        )


        */
    }
}
