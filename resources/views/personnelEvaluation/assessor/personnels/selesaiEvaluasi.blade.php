@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Evaluasi Kinerja</h4>
        <p class="card-category">Kriteria</p>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col">
                <h5 class="mt-3 text-center text-uppercase">DAFTAR PERSONIL {{ $lastSetting->jobTitle->job_title }} </h5>
                <h5 class="text-center text-uppercase">SELESAI MENGISI EVALUASI KINERJA</h5>
                <h5 class="mb-3 text-center">TRIWULAN {{ $lastSetting->quarter }} TAHUN {{ $lastSetting->year }}</h5>

                <table class=" table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Posisi</th>
                            <th scope="col">Kabupaten/Kota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($values as $value )
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $value->user->name }}</td>
                            <td>{{ $value->user->posisi->job_title }}</td>
                            <td>{{ $value->user->job_desc ? $value->user->job_desc->kabupaten->first()->NAMA_KAB : '' }}</td>
                            <td><a href="/personnel-evaluation/assessor/assessment/input/{{$value->id}}">
                                    <button type="button" class="btn btn-primary">
                                        Lihat
                                    </button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
