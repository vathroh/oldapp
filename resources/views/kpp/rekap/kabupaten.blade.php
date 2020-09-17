@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">KPP</h4>
    <p class="card-category"> Data KPP yang sudah diinput </p>
  </div>
  <div class="card-body">
	<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active" aria-current="page">SEMUA KABUPATEN</li>
	  </ol>
	</nav>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class=" text-primary text-center">
          <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">KABUPATEN/KOTA</th>
            <th rowspan="2">JUMLAH KPP</th>
            <th colspan="5">STATUS KPP</th>
            <th colspan="3">JUMLAH ANGGOTA</th>
            <th rowspan="2">STRUKTUR ORGANISASI</th>
            <th colspan="3">DASAR LEMBAGA</th>
            <th rowspan="2">RENCANA KERJA</th>
            <th colspan="5">PERTEMUAN RUTIN</th>
            <th colspan="4">ADMINISTRASI RUTIN</th>
            <th rowspan="2">BUKU ADMINISTRASI KEGIATAN</th>
            <th colspan="2">BOP</th>
            <th colspan="3">PENGECEKAN FISIK</th>
            <th colspan="2">KEGIATAN PEMELIHARAAN</th>
          </tr>
          <tr class="text-center">
			<th>PERLU PERHATIAN</th>
			<th>AWAL</th>
			<th>TERBANGUN</th>
			<th>BERDAYA</th>
			<th>MANDIRI</th>
            <th scope="row">PRIA</th>
            <th scope="row">WANITA</th>
            <th scope="row">MISKIN</th>
            <th scope="row">AD</th>
            <th scope="row">ART</th>
            <th scope="row">SK</th>
            <th scope="row">SETIAP BULAN</th>
            <th scope="row">SETIAP TIGA BULAN</th>
            <th scope="row">SETIAP ENAM BULAN</th>
            <th scope="row">INSIDENTIL (sesuai kebutuhan)</th>
            <th scope="row">TIDAK PERNAH (dalam satu tahun)</th>
            <th scope="row">ADMINISTRASI BULANAN LENGKAP</th>
            <th scope="row">ADMINISTRASI BULANAN MINIMALIS</th>
            <th scope="row">ADMINISTRASI TRIWULAN / SELEBIHNYA</th>
            <th scope="row">TIDAK ADA</th>
            <th scope="row">KETER SEDIAAN</th>
            <th scope="row">JUMLAH</th>
            <th scope="row">BELUM PERNAH</th>
            <th scope="row">BELUM DILAKUKAN</th>
            <th scope="row">SUDAH DILAKUKAN</th>
            <th scope="row">JUMLAH KEGIATAN</th>
            <th scope="row">JUMLAH DANA</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kppdatas as $kppdata)
            <tr>
				<th>{{ $loop->iteration }}</th>
                <th><a href = "/kpp-rekap-data-kecamatan/{{$kppdata->KD_KAB}}">{{ $kppdata->NAMA_KAB }}</a></th>
                <th>{{ $kppdata->jml_kpp }}</th>
                <th><a href = "/rekap-kpp/Status/Perlu Perhatian/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->perlu_perhatian }}</a></th>
                <th><a href = "/rekap-kpp/Status/Awal/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->awal }}</a></th>
                <th><a href = "/rekap-kpp/Status/Terbangun/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->terbangun }}</a></th>
                <th><a href = "/rekap-kpp/Status/Berdaya/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->berdaya }}</a></th>
                <th><a href = "/rekap-kpp/Status/Mandiri/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->mandiri }}</a></th>
                <th>{{ $kppdata->jml_pria }}</th>
                <th>{{ $kppdata->jml_wanita }}</th>
                <th>{{ $kppdata->jml_miskin }}</th>
                <th><a href = "/rekap-kpp/struktur_organisasi/Ada/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_struktur_organisasi }}</a></th>
                <th><a href = "/rekap-kpp/anggaran_dasar/Ada/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_anggaran_dasar }}</a></th>
                <th><a href = "/rekap-kpp/anggaran_rumah_tangga/Ada/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_anggaran_rumah_tangga }}</a></th>
                <th><a href = "/rekap-kpp/surat_keputusan/Ada/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_surat_keputusan }}</a></th>
                <th><a href = "/rekap-kpp/rencana_kerja/Ada/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_rencana_kerja }}</a></th>
                <th><a href = "/rekap-kpp/pertemuan_rutin/Setiap Bulan/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_pertemuan_rutin_setiap_bulan }}</a></th>
                <th><a href = "/rekap-kpp/pertemuan_rutin/Setiap Tiga Bulan/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_pertemuan_rutin_setiap_tiga_bulan }}</a></th>
                <th><a href = "/rekap-kpp/pertemuan_rutin/Setiap Enam Bulan/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_pertemuan_rutin_setiap_enam_bulan }}</a></th>
                <th><a href = "/rekap-kpp/pertemuan_rutin/Insidentil/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_pertemuan_rutin_insidentil }}</a></th>
                <th><a href = "/rekap-kpp/pertemuan_rutin/Tidak Pernah/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_pertemuan_rutin_tidak_pernah }}</a></th>
                <th><a href = "/rekap-kpp/administrasi_rutin/Administrasi Bulanan Lengkap/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_administrasi_bulanan_lengkap }}</a></th>
                <th><a href = "/rekap-kpp/administrasi_rutin/Administrasi Bulanan Minimalis/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_administrasi_bulanan_minimalis }}</a></th>
                <th><a href = "/rekap-kpp-administrasi-tiga-bulan/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_administrasi_triwulan }}</a></th>
                <th><a href = "/rekap-kpp/administrasi_rutin/Tidak Ada/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_administrasi_tidak_ada }}</a></th>
                <th><a href = "/rekap-kpp/buku_inventaris_kegiatan/Ada/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_buku_inventaris_kegiatan }}</a></th>
                <th><a href = "/rekap-kpp/bop/Ada/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_bop  }}</a></th>
                <th>{{ $kppdata->jml_dana_bop }}</th>
                <th><a href = "/rekap-kpp/kegiatan_pengecekan/Belum Pernah/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_pengecekan_belum_pernah }}</a></th>
                <th><a href = "/rekap-kpp/kegiatan_pengecekan/Belum Dilakukan/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_pengecekan_belum_dilakukan }}</a></th>
                <th><a href = "/rekap-kpp/kegiatan_pengecekan/Sudah Dilakukan/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_pengecekan_sudah_dilakukan }}</a></th>
                <th><a href = "/rekap-kpp/jumlah_kegiatan_perbaikan/0/KD_KAB/{{$kppdata->KD_KAB}}">{{ $kppdata->jml_kegiatan_perbaikan }}</th>
                <th>{{ $kppdata->jml_dana_perbaikan }}</th>
            </tr>
            @endforeach
            <tr>
                <th colspan="2">JUMLAH</th>
                <th>{{ $rekapkpp[0]->jml_kpp }}</th>
                <th><a href = "/rekap-kpp/Status/Perlu Perhatian">{{ $rekapkpp[0]->perlu_perhatian }}</a></th>
                <th>{{ $rekapkpp[0]->awal }}</th>
                <th>{{ $rekapkpp[0]->terbangun }}</th>
                <th>{{ $rekapkpp[0]->berdaya }}</th>
                <th>{{ $rekapkpp[0]->mandiri }}</th>
                <th>{{ $rekapkpp[0]->jml_pria }}</th>
                <th>{{ $rekapkpp[0]->jml_wanita }}</th>
                <th>{{ $rekapkpp[0]->jml_miskin }}</th>
                <th>{{ $rekapkpp[0]->jml_struktur_organisasi }}</th>
                <th>{{ $rekapkpp[0]->jml_anggaran_dasar }}</th>
                <th>{{ $rekapkpp[0]->jml_anggaran_rumah_tangga }}</th>
                <th>{{ $rekapkpp[0]->jml_surat_keputusan }}</th>
                <th>{{ $rekapkpp[0]->jml_rencana_kerja }}</th>
                <th>{{ $rekapkpp[0]->jml_pertemuan_rutin_setiap_bulan }}</th>
                <th>{{ $rekapkpp[0]->jml_pertemuan_rutin_setiap_tiga_bulan }}</th>
                <th>{{ $rekapkpp[0]->jml_pertemuan_rutin_setiap_enam_bulan }}</th>
                <th>{{ $rekapkpp[0]->jml_pertemuan_rutin_insidentil }}</th>
                <th>{{ $rekapkpp[0]->jml_pertemuan_rutin_tidak_pernah }}</th>
                <th>{{ $rekapkpp[0]->jml_administrasi_bulanan_lengkap }}</th>
                <th>{{ $rekapkpp[0]->jml_administrasi_bulanan_minimalis }}</th>
                <th>{{ $rekapkpp[0]->jml_administrasi_triwulan }}</th>
                <th>{{ $rekapkpp[0]->jml_administrasi_tidak_ada }}</th>
                <th>{{ $rekapkpp[0]->jml_buku_inventaris_kegiatan }}</th>
                <th>{{ $rekapkpp[0]->jml_bop  }}</th>
                <th>{{ $rekapkpp[0]->jml_dana_bop }}</th>
                <th>{{ $rekapkpp[0]->jml_pengecekan_belum_pernah }}</th>
                <th>{{ $rekapkpp[0]->jml_pengecekan_belum_dilakukan }}</th>
                <th>{{ $rekapkpp[0]->jml_pengecekan_sudah_dilakukan }}</th>
                <th>{{ $rekapkpp[0]->jml_kegiatan_perbaikan }}</th>
                <th>{{ $rekapkpp[0]->jml_dana_perbaikan }}</th>
            </tr>
        </tbody>
      </table>
    </div>
    <div class="row text-center">
      <div class="col justify-content-center">
        <a href = "/kpp-download-rekap-kabupaten"><button class = "btn btn-primary">Download</button></a>
      </div>
    </div>
  </div>
</div>


  <script src="{{ asset('js/cleave.js') }}"></script>
<script>

var cleave = new Cleave('.nomer2', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});

var cleave = new Cleave('.nomer3', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});

</script>
  @endsection
