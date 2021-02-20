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
                <h6 class="mb-3 text-center">Kuartal {{ $lastSetting->quarter }} Tahun {{ $lastSetting->year }}</h6>

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
                        @foreach ($lastSetting->jobDesc->whereIn('user_id', $users->pluck('id')) as $jobDesc )
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $jobDesc->user->name }}</td>
                            <td>{{ $jobDesc->posisi->job_title }}</td>
                            <td>{{ $jobDesc->kabupaten->first()->NAMA_KAB }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection