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
            <th rowspan="2">KODE KPP</th>
            <th rowspan="2">NAMA KPP</th>
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

          @php
          $nama_desa=$kelurahan[0]->where('KD_KEL',$kppdata->kode_desa)->get()[0]['NAMA_DESA'];
          $nama_kecamatan = $kelurahan[0]->where('KD_KEL',$kppdata->kode_desa)->get()[0]['NAMA_KEC'];
          $nama_kabupaten = $kelurahan[0]->where('KD_KEL',$kppdata->kode_desa)->get()[0]['NAMA_KAB'];
		  $bkm_name = $bkmdatas[0]->where('kelurahan_id', $kppdata->kode_desa)->get()[0]['bkm'];
          $uploader=$user[0]->where('id', $kppdata->user_id)->get()[0]['name'];

          $no=1;  
          $pengurus_kpp = $pengurus_kpps[0]->where('kelurahan_id', $kppdata->kode_desa)->get()[0];
          @endphp

          <tr>
            <th scope="row">{{ (($kppdatas->currentPage()-1) *10 ) + $loop->iteration }}</th>
            <td>{{ $nama_kabupaten }}</td>
            <td>{{ $nama_kecamatan }}</td>
            <td><a href="/kpp/{{ $kppdata->id }}">{{ $nama_desa }} </a></td>
            <td>{{ $bkm_name }}</td>
            <td>{{ $kppdata->lokasi_bdi_bpm }}</td>
            <td></td>
            <td>{{ $kppdata->nama_kpp }}</td>
            <td>{{ $pengurus_kpp->ketua_kpp }}</td>
            <td>{{ $pengurus_kpp->ketua_kpp_hp }}</td>
            <td>{{ $kppdata->anggota_pria }} Orang</td>
            <td>{{ $kppdata->anggota_wanita }} Orang</td>
            <td>{{ $kppdata->anggota_miskin }} Orang</td>
            <td>{{ $kppdata->struktur_organisasi }} 
				@php
				if(is_null($kppdata->scan_struktur_organisasi)){
				}else{
				@endphp
				<a href="/kpp/struktur-organisasi/{{$kppdata->id}}">Lihat</a></td>
				@php
				}
				@endphp
            <td>{{ $kppdata->anggaran_dasar }}
				@php
				if(is_null($kppdata->scan_anggaran_dasar)){
				}else{
				@endphp
				<a href="/kpp/anggaran-dasar/{{$kppdata->id}}">Lihat</a></td>
				@php
				}
				@endphp
            </td>
            <td>{{ $kppdata->anggaran_rumah_tangga }}
				@php
				if(is_null($kppdata->scan_anggaran_rumah_tangga)){
				}else{
				@endphp
				<a href="/kpp/anggaran-rumah-tangga/{{$kppdata->id}}">Lihat</a></td>
				@php
				}
				@endphp
            </td>
            <td>{{ $kppdata->surat_keputusan }}
            	@php
				if(is_null($kppdata->scan_surat_keputusan)){
				}else{
				@endphp
				<a href="/kpp/surat-keputusan/{{$kppdata->id}}">Lihat</a></td>
				@php
				}
				@endphp
            </td>
            <td>{{ $kppdata->rencana_kerja }}
				@php
				if(is_null($kppdata->scan_rencana_kerja)){
				}else{
				@endphp
				<a href="/kpp/rencana-kerja/{{$kppdata->id}}">Lihat</a></td>
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
				<a href="/kpp/administrasi-rutin/{{$kppdata->id}}">Lihat</a></td>
				@php
				}
				@endphp
            </td>
            <td>{{ $kppdata->buku_inventaris_kegiatan }}
                @php
				if(is_null($kppdata->scan_buku_inventaris_kegiatan)){
				}else{
				@endphp
				<a href="/kpp/buku-inventaris-kegiatan/{{$kppdata->id}}">Lihat</a></td>
				@php
				}
				@endphp
            </td>
            <td>{{ $kppdata->sumber_dana_operasional }}</td>
            <td class="nomer2">{{ $kppdata->nilai_bop }}</td>
            <td>{{ $kppdata->kegiatan_pengecekan }}</td>
            <td>{{ $kppdata->tanggal_kegiatan_perbaikan }}</td>
            <td>{{ $kppdata->sumber_dana_perbaikan }}</td>
            <td>{{ $kppdata->nilai_perbaikan }}</td>
            <td>{{ $kppdata->keterangan_lain_lain }}</td>
            <td>{{ $uploader }}</td>
            </tr>
            @php
            $no++;
            @endphp
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="row text-center">
        <div class="col justify-content-center">
          <span>{{ $kppdatas->links() }}</span>
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
