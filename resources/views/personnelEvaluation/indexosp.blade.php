@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Evaluasi Kinerja</h4>
        <p class="card-category"></p>
    </div>
    <div class="card-body">
        @include('personnelEvaluation.navbar')


        @if($status['isAssessor'])
        <div class="table-responsive tableFixHead">
            <table class="table table-bordered">
                <thead class=" text-primary text-center">
                    <tr class="text-center" style="background-color: purple; color:white;">
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

                    @foreach( $data['being_assessed_by_me']->unique('job_title_id') as $jobTitle) 
                    
                    @php
                        $fasilitators = $data['being_assessed_by_me']->where('job_title_id', $jobTitle['job_title_id']);
                        $values = $data['value_assessed_by_me']->whereIn('userId', $fasilitators->pluck('user_id')) ;
                    @endphp

                    <tr>
                        <td>{{ $jobTitle['job_title'] }}</td>

                        <td class="text-center">
                            <a href="/personnel-evaluation/assessor/personnels/allpersonnels/{{ $jobTitle['job_title_id'] }}">
                                {{ $fasilitators->count() }}
                            </a>
                        </td>
                        
                        <td class="text-center">
							<a href="/personnel-evaluation/assessor/personnels/belummengisi/{{ $jobTitle['job_title_id'] }}">
                                {{ $fasilitators->count()-$values->count() }}
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="/personnel-evaluation/assessor/personnels/prosesmengisi/{{ $jobTitle['job_title_id'] }}">
                                {{ $values->where('ok_by_user', 0 )->count() }}
                            </a>
                        </td>

                        <td class="text-center">
							<a href="/personnel-evaluation/assessor/personnels/selesaimengisi/{{ $jobTitle['job_title_id'] }}">
                                {{ $values->where('ok_by_user', 1 )->count() }}
                            </a>
                        </td>

                        <td class="text-center"> 
							<a href="/personnel-evaluation/assessor/personnels/siapevaluasi/{{ $jobTitle['job_title_id'] }}">
                                {{ $values->where('ok_by_user', 1 )->where('totalScore', '0.00')->count() }}
                            </a>
                        </td>

                        <td class="text-center">
							<a href="/personnel-evaluation/assessor/personnels/prosesevaluasi/{{ $jobTitle['job_title_id'] }}">
                                {{ $values->where('ok_by_user', 1 )->where('totalScore','!=', '0.00')->where('ready', 0)->count() }}
                            </a>
                        </td>

                        <td class="text-center">
							<a href="/personnel-evaluation/assessor/personnels/selesaievaluasi/{{ $jobTitle['job_title_id'] }}">
                                {{ $values->where('ok_by_user', 1 )->where('totalScore','!=', '0.00')->where('ready', 1)->count() }}
                            </a>
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
        @endif

    </div>

    @endsection
