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
            <th rowspan="2">KELURAHAN/DESA</th>
            <th rowspan="2">NAMA BKM</th>
            <th rowspan="2">LOKASI BDI/BPM</th>
            <th rowspan="2">NAMA KPP</th>
            <th rowspan="2">STATUS KPP</th>
            <th rowspan="2">KETUA KPP</th>
            <th rowspan="2">KONTAK KETUA KPP</th>
            <th colspan="3">JUMLAH ANGGOTA</th>
            <th rowspan="2">STRUKTUR ORGANISASI</th>
            <th colspan="3">DASAR LEMBAGA</th>
            <th rowspan="2">RENCANA KERJA</th>
            <th rowspan="2">PERTEMUAN RUTIN</th>
            <th rowspan="2">ADMINISTRASI RUTIN</th>
            <th rowspan="2">BUKU ADMINISTRASI KEGIATAN</th>
            <th colspan="2">BOP</th>
            <th rowspan="2">PENGECEKAN FISIK</th>
            <th colspan="3">KEGIATAN PEMELIHARAAN</th>
            <th rowspan="2">KETERANGAN</th>
            <th rowspan="2">DIUPLOAD OLEH</th>
          </tr>
          <tr class="text-center">
            <th scope="row">PRIA</th>
            <th scope="row">WANITA</th>
            <th scope="row">MISKIN</th>
            <th scope="row">AD</th>
            <th scope="row">ART</th>
            <th scope="row">SK</th>
            <th scope="row">SUMBER DANA</th>
            <th scope="row">JUMLAH</th>
            <th scope="row">TANGGAL</th>
            <th scope="row">SUMBER DANA</th>
            <th scope="row">JUMLAH DANA</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kppdatas as $kppdata)
            <tr>
                <th scope="row">{{ (($kppdatas->currentPage()-1) *10 ) + $loop->iteration }}</th>
                <th>{{ $kppdata->NAMA_KAB }}</th>
                <th>{{ $kppdata->NAMA_KEC }}</th>
                <th><a href = "/kpp/{{ $kppdata->id }}">{{ $kppdata->NAMA_DESA }}</a></th>
                <th>{{ $kppdata->bkm }}</th>
                <th>{{ $kppdata->lokasi_bdi_bpm }}</th>
                <th>{{ $kppdata->nama_kpp }}</th>
                <th>{{ $kppdata->Status }}</th>
                <th>{{ $kppdata->ketua_kpp }}</th>
                <th>{{ $kppdata->ketua_kpp_hp }}</th>
                <th>{{ $kppdata->anggota_pria }}</th>
                <th>{{ $kppdata->anggota_wanita }}</th>
                <th>{{ $kppdata->anggota_miskin }}</th>
                <th>{{ $kppdata->struktur_organisasi }}
                       @php
                       if(is_null($kppdata->scan_struktur_organisasi)){
                       }else{
                       @endphp
                       <a href="/kpp/struktur-organisasi/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </th>
                <th>{{ $kppdata->anggaran_dasar }}
                       @php
                       if(is_null($kppdata->scan_anggaran_dasar)){
                       }else{
                       @endphp
                       <a href="/kpp/anggaran-dasar/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </th>
                <th>{{ $kppdata->anggaran_rumah_tangga }}
                       @php
                       if(is_null($kppdata->scan_anggaran_rumah_tangga)){
                       }else{
                       @endphp
                       <a href="/kpp/anggaran-rumah-tangga/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </th>
                <th>{{ $kppdata->surat_keputusan }}
                       @php
                       if(is_null($kppdata->scan_surat_keputusan)){
                       }else{
                       @endphp
                       <a href="/kpp/surat-keputusan/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </th>
                <th>{{ $kppdata->rencana_kerja }}
                       @php
                       if(is_null($kppdata->scan_rencana_kerja)){
                       }else{
                       @endphp
                       <a href="/kpp/rencana-kerja/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </th>
                <th>{{ $kppdata->pertemuan_rutin }}</th>
                <th>{{ $kppdata->administrasi_rutin }}
                       @php
                       if(is_null($kppdata->scan_administrasi_rutin)){
                       }else{
                       @endphp
                       <a href="/kpp/administrasi-rutin/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </th>
                <th>{{ $kppdata->buku_inventaris_kegiatan }}
                       @php
                       if(is_null($kppdata->scan_buku_inventaris_kegiatan)){
                       }else{
                       @endphp
                       <a href="/kpp/buku-inventaris-kegiatan/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </th>
                <th></th>
                <th></th>
                <th>{{ $kppdata->kegiatan_pengecekan }}</th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ $kppdata->keterangan_lain_lain }}</th>
                <th>{{ $kppdata->name }}
            </tr> 
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="row text-center">
      <div class="col justify-content-center">
        <span>{{ $kppdatas->links() }}</span>
        <a href = "/kpp-download-excel"><button class = "btn btn-primary">Download Data KPP</button></a>
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
