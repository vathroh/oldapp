@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/rekapKab">All</a></li>
        <li class="breadcrumb-item active" aria-current="page"> {{ $kelurahan[0]['NAMA_KAB'] }} </li>
    </ol>
</nav>

<h3 class="text-center">{{ $kelurahan[0]['NAMA_KAB'] }} Tahun 2019</h3>

<table class="table table-striped table-dark table-bordered mt-3">
    <thead>
        <tr class="text-center">
            <th rowspan="2">NO</th>
            <th rowspan="2">KELURAHAN</th>
            <th colspan="8">FOTO KEGIATAN</th>
        </tr>
        <tr class="text-center">
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
            <td class="text-center">{{$kel->MP2K}} dari {{$kel->JML_KSM}}<br>KSM</td>
            <td class="text-center">{{$kel->OJT}} dari {{$kel->JML_KSM}}<br>KSM</td>
            <td class="text-center">{{$kel->PELATIHAN_KSM}} dari {{$kel->JML_KSM}}<br>KSM</td>
            <td class="text-center">{{$kel->FOTO_0}} dari {{$kel->JML_KEG}} <br>kegiatan</td>
            <td class="text-center">{{$kel->FOTO_25}} dari {{$kel->JML_KEG}} <br>kegiatan</td>
            <td class="text-center">{{$kel->FOTO_50}} dari {{$kel->JML_KEG}} <br>kegiatan</td>
            <td class="text-center">{{$kel->FOTO_75}} dari {{$kel->JML_KEG}} <br>kegiatan</td>
            <td class="text-center">{{$kel->FOTO_100}} dari {{$kel->JML_KEG}} <br>kegiatan</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

@endsection