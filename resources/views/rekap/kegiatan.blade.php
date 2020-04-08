@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/rekapKab">All</a></li>
            <li class="breadcrumb-item"><a href="#">Kabupaten</a></li>
            <li class="breadcrumb-item"><a href="/rekapKSM/{{$kelurahan[0]['KD_KEL']}}"> {{ $kelurahan[0]['NAMA_DESA'] }} </a></li>
            <li class="breadcrumb-item active" aria-current="page">KSM {{$ksm[0]['NAMA_KSM'] }} </li>
        </ol>
    </nav>
    <table class="table table-striped table-dark table-bordered mt-3">
        <thead>
            <tr class="text-center">
                <th rowspan="2">NO</th>
                <th rowspan="2">KSM</th>
                <th rowspan="2">KEGIATAN</th>
                <th rowspan="2">RT / RW</th>
                <th colspan="5">FOTO KEGIATAN</th>
            </tr>
            <tr class="text-center">
                <th scope="col">0%</th>
                <th scope="col">25%</th>
                <th scope="col">50%</th>
                <th scope="col">75%</th>
                <th scope="col">100%</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kegiatan as $keg)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$ksm[0]['NAMA_KSM']}}</a></td>
                <td>{{$keg->KEGIATAN}}</a></td>
                <td>{{$keg->RTRW}}</a></td>
                <td><a href="/viewfotokegiatan={{$keg->KD_KEGIATAN}}">{{$documents->where('kode_kegiatan', $keg->KD_KEGIATAN)->where('jenis_dokumen', 'FOTO 0%')->count()}} </a></td>
                <td><a href="/viewfotokegiatan={{$keg->KD_KEGIATAN}}">{{$documents->where('kode_kegiatan', $keg->KD_KEGIATAN)->where('jenis_dokumen', 'FOTO 25%')->count()}} </a></td>
                <td><a href="/viewfotokegiatan={{$keg->KD_KEGIATAN}}">{{$documents->where('kode_kegiatan', $keg->KD_KEGIATAN)->where('jenis_dokumen', 'FOTO 50%')->count()}} </a></td>
                <td><a href="/viewfotokegiatan={{$keg->KD_KEGIATAN}}">{{$documents->where('kode_kegiatan', $keg->KD_KEGIATAN)->where('jenis_dokumen', 'FOTO 75%')->count()}} </a></td>
                <td><a href="/viewfotokegiatan={{$keg->KD_KEGIATAN}}">{{$documents->where('kode_kegiatan', $keg->KD_KEGIATAN)->where('jenis_dokumen', 'FOTO 100%')->count()}} </a></td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4">JUMLAH</td>
                <td>{{$documents->where('kode_ksm', $keg->KD_KSM)->where('jenis_dokumen', 'FOTO 0%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $keg->KD_KSM)->where('jenis_dokumen', 'FOTO 25%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $keg->KD_KSM)->where('jenis_dokumen', 'FOTO 50%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $keg->KD_KSM)->where('jenis_dokumen', 'FOTO 75%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $keg->KD_KSM)->where('jenis_dokumen', 'FOTO 100%')->count()}} </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection