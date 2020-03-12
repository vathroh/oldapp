@extends('layouts.app')
@section('content')

<table class="table table-striped table-dark table-bordered mt-3">
    <thead>
        <tr class="text-center">
            <th rowspan="2">NO</th>
            <th rowspan="2">KABUPATEN</th>
            <th colspan="7">DOKUMEN</th>
        </tr>
        <tr class="text-center">
            <th scope="col">DOKUMEN TEKNIS</th>
            <th scope="col">RENCANA KERJA KSM</th>
            <th scope="col">MP2K</th>
            <th scope="col">OJT</th>
            <th scope="col">PELATIHAN KSM</th>
            <th scope="col">DOKUMEN PENGADAAN</th>
            <th scope="col">LPJ KSM</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kabupaten as $kab)
        <tr>

            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$kab->nama_kab}}</td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'DOKUMEN TEKNIS')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'RENCANA KERJA')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'MP2K')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'OJT')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'PELATIHAN')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'DOKUMEN PENGADAAN')->count()}} </td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'LPJ KSM')->count()}} </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2">JUMLAH</td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'DOKUMEN TEKNIS')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'RENCANA KERJA')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'MP2K')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'OJT')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'PELATIHAN')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'DOKUMEN PENGADAAN')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'LPJ KSM')->count()}} </td>
        </tr>
    </tbody>
</table>

@endsection