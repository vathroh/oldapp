@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Evaluasi Kinerja</h4>
    </div>
    <div class="card-body">
        @include('personnelEvaluation.navbar')

        <div class="row">
            <div class="col">
                <h5 class="mt-5 text-center">REKAP EVALUASI KINERJA PERSONIL</h5>
                <h5 class="mb-5 text-center">TRIWULAN {{$evaluationSettings->first()->quarter}} TAHUN {{$evaluationSettings->first()->year}}</h5>

                <table class=" table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Posisi</th>
                            <th scope="col">Kabupaten/Kota</th>
                            <th scope="col">Nilai (%)</th>
                            <th scope="col">Kualifikasi</th>
                            <th scope="col">Isu</th>
                            <th scope="col">Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluationSettings as $key => $evaluationSetting)
                        <tr>
                            <td colspan="8" style="font-size:large; background-color: darkturquoise; font-weight:bold;">{{$evaluationSetting->jobTitle->job_title}}</td>
                        </tr>
                        @foreach($evaluationSetting->evaluationValue->where('ready', 1) as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->user->name }}</td>
                            <td>{{ $jobDesc->where('user_id', $value->user->id)->first()->posisi->job_title }}</td>
                            <td>{{ $jobDesc->where('user_id', $value->user->id)->first()->kabupaten->first()->NAMA_KAB }}</td>
                            <td>{{ $value->totalScore}}</td>
                            <td>{{ $value->finalResult}}</td>
                            <td>{{ $value->issue}}</td>
                            <td>{{ $value->recommendation}}</td>

                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
