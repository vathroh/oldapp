@extends('layouts.MaterialDashboard')

@section('search')
<form class="navbar-form">
    <div class="input-group no-border">
        <input type="text" id="search" value="" class="form-control" placeholder="Cari...">
            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                <i class="material-icons">search</i>
            <div class="ripple-container"></div>
        </button>
    </div>
</form>
@endsection

@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">KPP</h4>
    <p class="card-category"> Data KPP yang sudah diinput</p>
  </div>
  <div class="card-body">
    <div class="table-responsive tableFixHead">
      <table class="table table-bordered" style = "display: block; position: relative" >
        <thead class=" text-primary text-center">
          <tr>
            <td width = "10%" rowspan="2">NO</td>
            <td rowspan="2">KABUPATEN/KOTA</td>
            <td rowspan="2">KECAMATAN</td>
            <td rowspan="2">KELURAHAN/DESA</td>
            <td rowspan="2">NAMA BKM</td>
            <td rowspan="2">LOKASI BDI/BPM</td>
            <td rowspan="2">NAMA KPP</td>
            <td rowspan="2">STATUS KPP</td>
            <td rowspan="2">KETUA KPP</td>
            <td rowspan="2">KONTAK KETUA KPP</td>
            <td colspan="3">JUMLAH ANGGOTA</td>
            <td rowspan="2">STRUKTUR ORGANISASI</td>
            <td colspan="3">DASAR LEMBAGA</td>
            <td rowspan="2">RENCANA KERJA</td>
            <td rowspan="2">PERTEMUAN RUTIN</td>
            <td rowspan="2">ADMINISTRASI RUTIN</td>
            <td rowspan="2">BUKU ADMINISTRASI KEGIATAN</td>
            <td colspan="2">BOP</td>
            <td rowspan="2">PENGECEKAN FISIK</td>
            <td colspan="3">KEGIATAN PEMELIHARAAN TERAKHIR</td>
            <td rowspan="2">KETERANGAN</td>
            <td rowspan="2">DIUPLOAD OLEH</td>
          </tr>
          <tr class="text-center">
            <td scope="row">PRIA</td>
            <td scope="row">WANITA</td>
            <td scope="row">MISKIN</td>
            <td scope="row">AD</td>
            <td scope="row">ART</td>
            <td scope="row">SK</td>
            <td scope="row">SUMBER DANA</td>
            <td scope="row">JUMLAH</td>
            <td scope="row">TANGGAL</td>
            <td scope="row">SUMBER DANA</td>
            <td scope="row">JUMLAH DANA</td>
          </tr>
        </tdead>
        <tbody style = "height : 300px; overflow-y: scroll;">
            @if($kppdatas->count() > 0)
            @foreach($kppdatas as $kppdata)
            <tr>
                <td scope="row">{{ (($kppdatas->currentPage()-1) *10 ) + $loop->iteration }}</td>
                <td>{{ $kppdata->NAMA_KAB }}</td>
                <td>{{ $kppdata->NAMA_KEC }}</td>
                <td><a href = "/kpp/{{ $kppdata->id }}">{{ $kppdata->NAMA_DESA }}</a></td>
                <td>{{ $kppdata->bkm }}</td>
                <td>{{ $kppdata->lokasi_bdi_bpm }}</td>
                <td>{{ $kppdata->nama_kpp }}</td>
                <td>{{ $kppdata->Status }}</td>
                <td>{{ $kppdata->ketua_kpp }}</td>
                <td>{{ $kppdata->ketua_kpp_hp }}</td>
                <td>{{ $kppdata->anggota_pria }}</td>
                <td>{{ $kppdata->anggota_wanita }}</td>
                <td>{{ $kppdata->anggota_miskin }}</td>
                <td>{{ $kppdata->struktur_organisasi }}
                       @php
                       if(is_null($kppdata->scan_struktur_organisasi)){
                       }else{
                       @endphp
                       <a href="/kpp/struktur-organisasi/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </td>
                <td>{{ $kppdata->anggaran_dasar }}
                       @php
                       if(is_null($kppdata->scan_anggaran_dasar)){
                       }else{
                       @endphp
                       <a href="/kpp/anggaran-dasar/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </td>
                <td>{{ $kppdata->anggaran_rumah_tangga }}
                       @php
                       if(is_null($kppdata->scan_anggaran_rumah_tangga)){
                       }else{
                       @endphp
                       <a href="/kpp/anggaran-rumah-tangga/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </td>
                <td>{{ $kppdata->surat_keputusan }}
                       @php
                       if(is_null($kppdata->scan_surat_keputusan)){
                       }else{
                       @endphp
                       <a href="/kpp/surat-keputusan/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </td>
                <td>{{ $kppdata->rencana_kerja }}
                       @php
                       if(is_null($kppdata->scan_rencana_kerja)){
                       }else{
                       @endphp
                       <a href="/kpp/rencana-kerja/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </td>
                <td>{{ $kppdata->pertemuan_rutin }}</td>
                <td>{{ $kppdata->administrasi_rutin }}
                       @php
                       if(is_null($kppdata->scan_administrasi_rutin)){
                       }else{
                       @endphp
                       <a href="/kpp/administrasi-rutin/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </td>
                <td>{{ $kppdata->buku_inventaris_kegiatan }}
                       @php
                       if(is_null($kppdata->scan_buku_inventaris_kegiatan)){
                       }else{
                       @endphp
                       <a href="/kpp/buku-inventaris-kegiatan/{{ $kppdata->id }}">Lihat</a></td>
                       @php                
                       }
                       @endphp
                </td>
                <td>
					@php
						foreach($BOPs->where('kelurahan_id', $kppdata->kode_desa) as $BOP)
						{
							echo "$BOP->sumber_dana,";
						}
					@endphp
                </td>
                <td>{{ $BOPs->where('kelurahan_id', $kppdata->kode_desa)->sum('jumlah') }}</td>
                <td>{{ $kppdata->kegiatan_pengecekan }}</td>
                <td>{{ $kppdata->tanggal_mulai }}</td>
                <td>{{ $kppdata->sumber_dana }}</td>
                <td>{{ $kppdata->jumlah }}</td>
                <td>{{ $kppdata->keterangan_lain_lain }}</td>
                <td>{{ $kppdata->name }}</td>
            </tr> 
            @endforeach
            @endif
        </tbody>
      </table>
    </div>
    <div id="indexKPPpagination" class="row text-center">
      <div class="col justify-content-center">
        @if($kppdatas->count() > 0)
        <span>{{ $kppdatas->links() }}</span>
        @endif
        <a href = "/kpp-download-excel"><button class = "btn btn-primary">Download Data KPP</button></a>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('js/kpp/searchIndexKPP.js') }}"></script>
@endsection
