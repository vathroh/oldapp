@extends('layouts.app')

@section('content')
@if(session('status'))
<div class="alert alert-success">
    <h1>
        {{ session('status') }}
    </h1>
</div>
@endif

<table class="table table-striped table-dark table-bordered mt-3">
    <thead>
        <tr class="text-center">
            <th rowspan="2">NO</th>
            <th rowspan="2">KABUPATEN</th>
            <th rowspan="2">PRA DESAIN</th>
            <th rowspan="2">BA PEMAKETAN</th>
            <th rowspan="2">PEMBENTUKAN KPP</th>
            <th rowspan="2">RENCANA KERJA KPP</th>
            <th colspan="2">DOKUMEN PENCAIRAN</th>
            <th rowspan="2">LPJ BKM</th>

        </tr>
        <tr class="text-center">
            <th scope="col">TAHAP 1</th>
            <th scope="col">TAHAP 2</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kabupaten as $kab)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$kab->nama_kab}}</td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'PRA DESAIN')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'BA PEMAKETAN')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'PEMBENTUKAN KPP')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'RENCANA KERJA KPP')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'PENCAIRAN TAHAP 1')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'PENCAIRAN TAHAP 2')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'LPJ BKM')->count()}} </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2">JUMLAH</td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'PRA DESAIN')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'BA PEMAKETAN')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'PEMBENTUKAN KPP')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'RENCANA KERJA KPP')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'PENCAIRAN TAHAP 1')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'PENCAIRAN TAHAP 2')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'LPJ BKM')->count()}} </td>
        </tr>
    </tbody>
</table>


@endsection