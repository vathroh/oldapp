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
            <a class="btn btn-primary" href="/rekap">.R e k a p.</a>
            <br><br>
            <a class="btn btn-primary" href="/create">Upload Dok BKM</a>
            <a class="btn btn-primary" href="/ksm">Upload Dok KSM</a>
            <a class="btn btn-primary" href="/foto">Upload Foto</a>
        </div>
    </div>


    <table class="table table-striped table-dark table-bordered mt-3">
        <thead>
            <tr class="justify-align-center">
                <th rowspan="2">NO</th>
                <th rowspan="2">KABUPATEN</th>
                <th rowspan="2">DESA</th>
                <th rowspan="2">KSM</th>
                <th rowspan="2">DOKUMEN TEKNIS</th>
                <th rowspan="2">RENCANA KERJA KSM</th>
                <th colspan="3">DOKUMEN PERSIAPAN</th>
                <th rowspan="2">DOKUMEN PENGADAAN</th>
                <th rowspan="2">LPJ KSM</th>
                <th colspan="5">FOTO KEGIATAN</th>
            </tr>
            <tr>
                <th scope="col">MP2K</th>
                <th scope="col">OJT</th>
                <th scope="col">PELATIHAN KSM</th>
                <th scope="col">0%</th>
                <th scope="col">25%</th>
                <th scope="col">50%</th>
                <th scope="col">75%</th>
                <th scope="col">100%</th>

            </tr>
        </thead>
        <tbody>
            @foreach($ksm as $ksma)
            <tr>
                @php
                $nama_desa=$kelurahan[0]->where('KD_KEL',$ksma->KD_KEL)->get('NAMA_DESA')[0]['NAMA_DESA'];
                $nama_kab=$kelurahan[0]->where('KD_KEL',$ksma->KD_KEL)->get('NAMA_KAB')[0]['NAMA_KAB'];
                $kode_ksm=$ksm[0]->where('');
                @endphp
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$nama_kab}}</td>
                <td>{{$nama_desa}}</td>
                <td>{{$ksma->NAMA_KSM}}</td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'DOKUMEN TEKNIS')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'RENCANA KERJA')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'MP2K')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'OJT')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'PELATIHAN')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'DOKUMEN PENGADAAN')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'LPJ')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'FOTO 0%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'FOTO 25%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'FOTO 50%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'FOTO 75%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'FOTO 100%')->count()}} </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection