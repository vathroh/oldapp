@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/rekapKab">All</a></li>
        <li class="breadcrumb-item active" aria-current="page"> {{ $kelurahan[0]['NAMA_KAB'] }} </li>
    </ol>
</nav>
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