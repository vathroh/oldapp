@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">KPP</h4>
    <p class="card-category"> Data KPP yang sudah diinput </p>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class=" text-primary text-center">
          <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">KABUPATEN/KOTA</th>
            <th rowspan="2">KECAMATAN</th>
            <th rowspan="2">DESA/KELURAHAN</th>
            <th rowspan="2">JUMLAH KPP</th>
            <th rowspan="2">STATUS KPP</th>
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
                <th>{{ $kppdata->NAMA_KAB }}</th>
                <th>{{ $kppdata->NAMA_KEC }}</th>
                <th>{{ $kppdata->NAMA_DESA }}</th>
                <th>{{ $kppdata->jml_kpp }}</th>
                <th>{{ $kppdata->Status }}</th>
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
        </tbody>
      </table>
    </div>
    <div class="row text-center">

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
