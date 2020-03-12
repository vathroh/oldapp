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
            <a class="btn btn-primary" href="/rekapKab">.R e k a p.</a>
            <br><br>
            <a class="btn btn-primary" href="/create">Upload Dok BKM</a>
            <a class="btn btn-primary" href="/ksm">Upload Dok KSM</a>
            <a class="btn btn-primary" href="/foto">Upload Foto</a>
        </div>
    </div>


    <table class="table table-striped table-dark table-bordered mt-3">
        <thead>
            <tr class="text-center">
                <th rowspan="2">NO</th>
                <th rowspan="2">KELURAHAN</th>
                <th colspan="7">DOKUMEN</th>
                <th colspan="8">FOTO KEGIATAN</th>
            </tr>
            <tr class="text-center">
                <th scope="col">DOKUMEN TEKNIS</th>
                <th scope="col">RENCANA KERJA KSM</th>
                <th scope="col">MP2K</th>
                <th scope="col">OJT</th>
                <th scope="col">PELATIHAN KSM</th>
                <th scope="col">DOKUMEN PENGADAAN</th>
                <th scope="col">LPJ KSM</th>
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
            @foreach ($kelurahan as $kel)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td><a href="/rekapKSM/{{$kel->KD_KEL}}">{{$kel->NAMA_DESA}}</a></td>
                <td>{{$documents->where('kode_kel', $kel->KD_KEL)->where('jenis_dokumen', 'DOKUMEN TEKNIS')->count()}} </td>
                <td>{{$documents->where('kode_kel', $kel->KD_KEL)->where('jenis_dokumen', 'RENCANA KERJA')->count()}} </td>
                <td>{{$documents->where('kode_kel', $kel->KD_KEL)->where('jenis_dokumen', 'MP2K')->count()}} </td>
                <td>{{$documents->where('kode_kel', $kel->KD_KEL)->where('jenis_dokumen', 'OJT')->count()}} </td>
                <td>{{$documents->where('kode_kel', $kel->KD_KEL)->where('jenis_dokumen', 'PELATIHAN')->count()}} </td>
                <td>{{$documents->where('kode_kel', $kel->KD_KEL)->where('jenis_dokumen', 'DOKUMEN PENGADAAN')->count()}} </td>
                <td>{{$documents->where('kode_kel', $kel->KD_KEL)->where('jenis_dokumen', 'LPJ')->count()}} </td>

                <td>{{$ksm->where('KD_KEL',$kel->KD_KEL)->where('FOTO_MP2K','1')->count() }} dari {{ $ksm->where('KD_KEL',$kel->KD_KEL)->count()}} </td>
                <td>{{$ksm->where('KD_KEL',$kel->KD_KEL)->where('FOTO_OJT','1')->count() }} dari {{ $ksm->where('KD_KEL',$kel->KD_KEL)->count()}} </td>
                <td>{{$ksm->where('KD_KEL',$kel->KD_KEL)->where('FOTO_PELATIHAN','1')->count() }} dari {{ $ksm->where('KD_KEL',$kel->KD_KEL)->count()}} </td>
                <td>{{$ksm->where('KD_KEL',$kel->KD_KEL)->where('FOTO_0','1')->count() }} dari {{ $ksm->where('KD_KEL',$kel->KD_KEL)->count()}} </td>
                <td>{{$ksm->where('KD_KEL',$kel->KD_KEL)->where('FOTO_25','1')->count() }} dari {{ $ksm->where('KD_KEL',$kel->KD_KEL)->count()}} </td>
                <td>{{$ksm->where('KD_KEL',$kel->KD_KEL)->where('FOTO_50','1')->count() }} dari {{ $ksm->where('KD_KEL',$kel->KD_KEL)->count()}} </td>
                <td>{{$ksm->where('KD_KEL',$kel->KD_KEL)->where('FOTO_75','1')->count() }} dari {{ $ksm->where('KD_KEL',$kel->KD_KEL)->count()}} </td>
                <td>{{$ksm->where('KD_KEL',$kel->KD_KEL)->where('FOTO_100','1')->count() }} dari {{ $ksm->where('KD_KEL',$kel->KD_KEL)->count()}} </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection