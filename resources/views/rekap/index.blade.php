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

    <h1>REKAP UPLOAD FOTO KABUPATEN/KOTA OSP-1 JAWA TENGAH-1</h1>

    <table class="table table-striped table-dark table-bordered mt-3">
        <thead>
            <tr class="text-center">
                <th rowspan="2">NO</th>
                <th rowspan="2">KABUPATEN</th>
                <th colspan="8">FOTO KEGIATAN</th>
            </tr>
            <tr class="text-center">
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
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'DOKUMENTASI MP2K')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'DOKUMENTASI OJT')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'DOKUMENTASI PELATIHAN')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'DOKUMEN PENGADAAN')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'LPJ')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'FOTO 0%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'FOTO 25%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'FOTO 50%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'FOTO 75%')->count()}} </td>
                <td>{{$documents->where('kode_ksm', $ksma->KD_KSM)->where('jenis_dokumen', 'FOTO 100%')->count()}} </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2">JUMLAH</td>
                <td>{{$documents->where('jenis_dokumen', 'DOKUMEN TEKNIS')->count()}} </td>
                <td>{{$documents->where('jenis_dokumen', 'RENCANA KERJA')->count()}} </td>
                <td>{{$documents->where('jenis_dokumen', 'DOKUMENTASI MP2K')->count()}} </td>
                <td>{{$documents->where('jenis_dokumen', 'DOKUMENTASI OJT')->count()}} </td>
                <td>{{$documents->where('jenis_dokumen', 'DOKUMENTASI PELATIHAN')->count()}} </td>
                <td>{{$documents->where('jenis_dokumen', 'DOKUMEN PENGADAAN')->count()}} </td>
                <td>{{$documents->where('jenis_dokumen', 'LPJ')->count()}} </td>
                <td>{{$documents->where('jenis_dokumen', 'FOTO 0%')->count()}} </td>
                <td>{{$documents->where('jenis_dokumen', 'FOTO 25%')->count()}} </td>
                <td>{{$documents->where('jenis_dokumen', 'FOTO 50%')->count()}} </td>
                <td>{{$documents->where('jenis_dokumen', 'FOTO 75%')->count()}} </td>
                <td>{{$documents->where('jenis_dokumen', 'FOTO 100%')->count()}} </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection