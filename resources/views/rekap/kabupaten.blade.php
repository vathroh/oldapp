@extends('layouts.app')

@section('content')

<h3 class="text-center">Tahun 2019</h3>

<table class="table table-striped table-dark table-bordered mt-3">
    <thead>
        <tr class="text-center">
            <th rowspan="2">NO</th>
            <th rowspan="2">KABUPATEN</th>
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
        @foreach($kabupaten as $kab)
        <tr>
            @php
            $namakab=$kab->where('kode_kab', $kab->kode_kab)->get('nama_kab')[0]['nama_kab'];
            @endphp
            <th scope="row">{{$loop->iteration}}</th>
            <td><a href="/rekapKel/{{$kab->kode_kab}}">{{$namakab}}</a></td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'DOKUMENTASI MP2K')->count()}} file</td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'DOKUMENTASI OJT')->count()}} file</td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'DOKUMENTASI PELATIHAN')->count()}} file</td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'FOTO 0%')->count()}} file</td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'FOTO 25%')->count()}} file</td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'FOTO 50%')->count()}} file</td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'FOTO 75%')->count()}} file</td>
            <td class="text-center">{{$documents->where('kode_kab', $kab->kode_kab)->where('jenis_dokumen', 'FOTO 100%')->count()}} file</td>
        </tr>
        @endforeach
        <tr>
            <td class="text-center" colspan="2">JUMLAH</td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'DOKUMENTASI MP2K')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'DOKUMENTASI OJT')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'DOKUMENTASI PELATIHAN')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'FOTO 0%')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'FOTO 25%')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'FOTO 50%')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'FOTO 75%')->count()}} </td>
            <td class="text-center">{{$documents->where('jenis_dokumen', 'FOTO 100%')->count()}} </td>
        </tr>
    </tbody>
</table>


@endsection