@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Evaluasi Kinerja</h4>
        <p class="card-category"></p>
    </div>
    <div class="card-body">
        @include('personnelEvaluation.navbar')

        <div class="table-responsive tableFixHead">
            <table class="table table-bordered">
                <thead class=" text-primary text-center">
                    <tr class="text-center" style="background-color: purple; color:white;">
                        <!-- <th rowspan="2">Kuartal | Tahun</th> -->
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Posisi Yang Dievaluasi</th>
                        <th rowspan="2">Jumlah Personil</th>
                        <th colspan="3">Personil</th>
                        <th colspan="3">Tim Penilai</th>
                    </tr>
                    <tr class="text-center" style="background-color: purple; color:white;">
                        <th>Belum Mengisi</th>
                        <th>Proses</th>
                        <th>Selesai Mengisi</th>
                        <th>Siap Dievaluasi</th>
                        <th>Sedang Dievaluasi</th>
                        <th>Selesai Dievaluasi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($data['fasilitators']->unique('job_title_id')->sortBy('job_title_sort') as $jobTitle)

                    @php
                        $fasilitators = $data['fasilitators']->where('job_title_id', $jobTitle['job_title_id']);
                        $values = $data['values']->whereIn('userId', $fasilitators->pluck('user_id'));
                    @endphp

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $jobTitle['job_title'] }}
                        </td>
                            
                        <td class="text-center">
                            <a href="/personnel-evaluation/hrm/personnels/allpersonnels/{{ $jobTitle['job_title_id'] }}">
                                {{ $fasilitators->count() }}
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="/personnel-evaluation/hrm/personnels/belummengisi/{{ $jobTitle['job_title_id'] }}">
                                {{ $fasilitators->count() - $values->count() }}
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="/personnel-evaluation/hrm/personnels/prosesmengisi/{{ $jobTitle['job_title_id'] }}">
                                {{ $values->where('ok_by_user', 0)->count() }}
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="/personnel-evaluation/hrm/personnels/selesaimengisi/{{ $jobTitle['job_title_id'] }}">
                                {{ $values->where('ok_by_user', 1)->count() }}
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="/personnel-evaluation/hrm/personnels/siapevaluasi/{{ $jobTitle['job_title_id'] }}">
                                {{ $values->where('ok_by_user', 1)->where('totalScore', '0.00')->count() }}
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="/personnel-evaluation/hrm/personnels/prosesevaluasi/{{ $jobTitle['job_title_id'] }}">
                                {{ $values->where('ready', 0)->where('totalScore', '!=', '0.00')->count() }}
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="/personnel-evaluation/hrm/personnels/selesaievaluasi/{{ $jobTitle['job_title_id'] }}">
                                {{ $values->where('ready', 1)->count() }}
                            </a>
                        </td>

                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    @endsection
