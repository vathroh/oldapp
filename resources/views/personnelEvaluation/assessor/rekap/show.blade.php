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
                <h5 class="mb-5 text-center">TRIWULAN {{$quarter}} TAHUN {{$year}}</h5>

                <table class="table-bordered table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Posisi</th>
                            <th scope="col">Tim</th>
                            <th scope="col">Kabupaten/Kota</th>
                            <th scope="col">Nilai (%)</th>
                            <th scope="col">Kualifikasi</th>
                            <th scope="col">Isu</th>
                            <th scope="col">Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users->unique('kode_kab') as $district)
                        <tr>
                            <td colspan="9">{{ $district['kab'] }}</td>
                        </tr>
                        @foreach($users->where('kode_kab', $district['kode_kab']) as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['job_title'] }}</td>
                            <td>{{ $user['tim'] }}</td>
                            <td>{{ $user['kab'] }}</td>
                            <td>{{ $values->where('userId', $user['user_id'])->first()->totalScore ??  '' }}</td>
                            <td>{{ $values->where('userId', $user['user_id'])->first()->finalResult ?? ''}}</td>
                            <td>{{ $values->where('userId', $user['user_id'])->first()->issue ??'' }}</td>
                            <td>{{ $values->where('userId', $user['user_id'])->first()->recommendation ?? '' }}</td>
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
