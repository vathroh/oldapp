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

                <h5 class="mt-3 text-center text-uppercase">DAFTAR PERSONIL {{ $data['job_title']['job_title'] }} </h5>
                <h5 class="text-center text-uppercase">DALAM PROSES EVALUASI</h5>
                <h5 class="mb-3 text-center">TRIWULAN {{ $data['thisQuarter'] }} TAHUN {{ $data['thisYear'] }}</h5>

                <table class=" table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Posisi</th>
                            <th scope="col">Tim</th>
                            <th scope="col">Kabupaten/Kota</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($data['fasilitators'] as $fasilitator)
                        <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td> {{ $fasilitator['name'] }} </td>
                            <td> {{ $fasilitator['job_title'] }} </td>
                            <td> {{ $fasilitator['tim'] }} </td>
                            <td> {{ $fasilitator['kab'] }} </td>
                            <td>
                                <a href="/personnel-evaluation/assessor/assessment/input/{{ $data['values']->where('userId', $fasilitator['user_id'])->first()->id }}">

                                    <button type="button" class="btn btn-primary">
                                        Lanjutkan Evaluasi
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
