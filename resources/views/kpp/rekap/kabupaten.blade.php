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
                <th>{{ $kppdata->perlu_perhatian }}</th>
                <th>{{ $kppdata->awal }}</th>
                <th>{{ $kppdata->terbangun }}</th>
                <th>{{ $kppdata->berdaya }}</th>
                <th>{{ $kppdata->mandiri }}</th>
                <th>{{ $kppdata->jml_pria }}</th>
                <th>{{ $kppdata->jml_wanita }}</th>
                <th>{{ $kppdata->jml_miskin }}</th>
                <th>{{ $kppdata->jml_struktur_organisasi }}</th>
                <th>{{ $kppdata->jml_anggaran_dasar }}</th>
                <th>{{ $kppdata->jml_anggaran_rumah_tangga }}</th>
                <th>{{ $kppdata->jml_surat_keputusan }}</th>
                <th>{{ $kppdata->jml_rencana_kerja }}</th>
                <th>{{ $kppdata->jml_pertemuan_rutin_setiap_bulan }}</th>
                <th>{{ $kppdata->jml_pertemuan_rutin_setiap_tiga_bulan }}</th>
                <th>{{ $kppdata->jml_pertemuan_rutin_setiap_enam_bulan }}</th>
                <th>{{ $kppdata->jml_pertemuan_rutin_insidentil }}</th>
                <th>{{ $kppdata->jml_pertemuan_rutin_tidak_pernah }}</th>
                <th>{{ $kppdata->jml_administrasi_bulanan_lengkap }}</th>
                <th>{{ $kppdata->jml_administrasi_bulanan_minimalis }}</th>
                <th>{{ $kppdata->jml_administrasi_triwulan }}</th>
                <th>{{ $kppdata->jml_administrasi_tidak_ada }}</th>
                <th>{{ $kppdata->jml_buku_inventaris_kegiatan }}</th>
                <th>{{ $kppdata->jml_bop  }}</th>
                <th>{{ $kppdata->jml_dana_bop }}</th>
                <th>{{ $kppdata->jml_pengecekan_belum_pernah }}</th>
                <th>{{ $kppdata->jml_pengecekan_belum_dilakukan }}</th>
                <th>{{ $kppdata->jml_pengecekan_sudah_dilakukan }}</th>
                <th>{{ $kppdata->jml_kegiatan_perbaikan }}</th>
                <th>{{ $kppdata->jml_dana_perbaikan }}</th>
            </tr>
            @endforeach
            <tr>
                <th colspan="2">JUMLAH</th>
                <th>{{ $rekapkpp[0]->jml_kpp }}</th>
                <th>{{ $rekapkpp[0]->perlu_perhatian }}</th>
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
