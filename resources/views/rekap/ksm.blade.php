@extends('layouts.app')

@section('content')


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/rekapKab">All</a></li>
        <li class="breadcrumb-item"><a href="/rekapKel/{{$kelurahan[0]['KD_KAB']}}">{{ $kelurahan[0]['NAMA_KAB'] }}</a></li>
        <li class="breadcrumb-item active" aria-current="page"> {{ $kelurahan[0]['NAMA_DESA'] }} </li>
    </ol>
</nav>

<table class="table table-striped table-dark table-bordered mt-3">
    <thead>
        <tr class="text-center">
            <th rowspan="2">NO</th>
            <th rowspan="2">KSM</th>

            <th colspan="8">FOTO</th>
        </tr>
        <tr class="text-center">
            <th scope="col">MP2K</th>
            <th scope="col">OJT</th>
            <th scope="col">PELATIHAN KSM</th>
            <th scope="col">FOTO 0%</th>
            <th scope="col">FOTO 25%</th>
            <th scope="col">FOTO 50%</th>
            <th scope="col">FOTO 75%</th>
            <th scope="col">FOTO 100%</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ksm as $ksm1)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td><a href="/rekapKegiatan/{{$ksm1->KD_KSM}}">{{$ksm1->NAMA_KSM}}</a></td>
            <td>{{$documents->where('kode_ksm', $ksm1->KD_KSM)->where('jenis_dokumen', 'DOKUMENTASI MP2K')->count()}} </td>
            <td>{{$documents->where('kode_ksm', $ksm1->KD_KSM)->where('jenis_dokumen', 'DOKUMENTASI OJT')->count()}} </td>
            <td>{{$documents->where('kode_ksm', $ksm1->KD_KSM)->where('jenis_dokumen', 'DOKUMENTASI PELATIHAN')->count()}} </td>
            <td>{{ $kegiatan->where('KD_KSM',$ksm1->KD_KSM)->where('FOTO_0','1')->count() }} dari {{ $kegiatan->where('KD_KSM',$ksm1->KD_KSM)->count() }}</td>
            <td>{{ $kegiatan->where('KD_KSM',$ksm1->KD_KSM)->where('FOTO_25','1')->count() }} dari {{ $kegiatan->where('KD_KSM',$ksm1->KD_KSM)->count() }}</td>
            <td>{{ $kegiatan->where('KD_KSM',$ksm1->KD_KSM)->where('FOTO_50','1')->count() }} dari {{ $kegiatan->where('KD_KSM',$ksm1->KD_KSM)->count() }}</td>
            <td>{{ $kegiatan->where('KD_KSM',$ksm1->KD_KSM)->where('FOTO_75','1')->count() }} dari {{ $kegiatan->where('KD_KSM',$ksm1->KD_KSM)->count() }}</td>
            <td>{{ $kegiatan->where('KD_KSM',$ksm1->KD_KSM)->where('FOTO_100','1')->count() }} dari {{ $kegiatan->where('KD_KSM',$ksm1->KD_KSM)->count() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection