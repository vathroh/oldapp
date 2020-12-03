@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">{{ $zone_id }}</h4>
        <p class="card-category"> KPP dengan {{ $column }}  {{ $param }}  </p>
    </div>
    <div class="card-body">
    
    @if($column == "pertemuan_rutin" and $param == "Tidak Pernah")
        <ol>
        @foreach($noPertemuanRutin as $noPertemuan)
            <li><a href="/kpp/{{ $noPertemuan->id }}">{{ $noPertemuan->NAMA_DESA }} </a>  KECAMATAN {{ $noPertemuan->NAMA_KEC }}</li>
        @endforeach
        </ol>
    @elseif($column == "administrasi_rutin" and $param == "Tidak Ada")
        <ol>
        @foreach($noAdministrasiRutin as $noAdministrasi)
            <li><a href="/kpp/{{ $noAdministrasi->id }}">{{ $noAdministrasi->NAMA_DESA }} </a> KECAMATAN {{ $noAdministrasi->NAMA_KEC }}</li>
        @endforeach
        </ol>
    @elseif($column == "kegiatan_pengecekan" and $param == "Belum Pernah")
        <ol>
        @foreach($noKegiatanPengecekan as $noPengecekan)
            <li><a href="/kpp/{{ $noPengecekan->id }}">{{ $noPengecekan->NAMA_DESA }} </a> KECAMATAN {{ $noPengecekan->NAMA_KEC }}</li>
        @endforeach
        </ol>
    @elseif($column == "jumlah_kegiatan_perbaikan")
        <ol>
        @foreach($kegiatanPerbaikan as $Perbaikan)
            <li><a href="/kpp/{{ $Perbaikan->id }}">{{ $Perbaikan->NAMA_DESA }} </a> KECAMATAN {{ $Perbaikan->NAMA_KEC }}</li>
        @endforeach
        </ol>

    @else
        <ol>
        @foreach($kppdatas as $kppdata)
            <li><a href="/kpp/{{ $kppdata->id }}">{{ $kppdata->NAMA_DESA }} </a>KECAMATAN {{ $kppdata->NAMA_KEC }}</li>
        @endforeach
        </ol>
    @endif


    </div>
@endsection
