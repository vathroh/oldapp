@extends('layouts.app')

@section('content')
@if(session('status'))
<div class="alert alert-success">
    <h1>
        {{ session('status') }}
    </h1>
</div>
@endif
<div class="container">
    <div class="row">
        <div class="col text-center">
            <a class="btn btn-primary" href="/doc">. F o t o .</a>
            <a class="btn btn-primary" href="/table">.Dokumen.</a>
            <a class="btn btn-primary" href="/rekapKAb">.R e k a p.</a>
            <br><br>
            <a class="btn btn-primary" href="/create">Upload Dok BKM</a>
            <a class="btn btn-primary" href="/.">Upload Dok KSM</a>
            <a class="btn btn-primary" href="/foto">Upload Foto</a>
        </div>
    </div>


    <table class="table table-striped table-dark table-bordered mt-3">
        <thead>
            <tr class="text-center">
                <th rowspan="2">NO</th>
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
                <td><a href="/rekapKegiatanCentang/{{$keg->KD_KEGIATAN}}">{{$keg->KEGIATAN}}</a></td>
                <td>{{$keg->RTRW}}</a></td>
                <td>{{$documents->where('kode_kegiatan', $keg->KD_KEGIATAN)->where('jenis_dokumen', 'FOTO 0%')->count()}} </td>
                <td>{{$documents->where('kode_kegiatan', $keg->KD_KEGIATAN)->where('jenis_dokumen', 'FOTO 25%')->count()}} </td>
                <td>{{$documents->where('kode_kegiatan', $keg->KD_KEGIATAN)->where('jenis_dokumen', 'FOTO 50%')->count()}} </td>
                <td>{{$documents->where('kode_kegiatan', $keg->KD_KEGIATAN)->where('jenis_dokumen', 'FOTO 75%')->count()}} </td>
                <td>{{$documents->where('kode_kegiatan', $keg->KD_KEGIATAN)->where('jenis_dokumen', 'FOTO 100%')->count()}} </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3">JUMLAH</td>
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