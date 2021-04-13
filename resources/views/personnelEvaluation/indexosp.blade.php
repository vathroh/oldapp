@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Evaluasi Kinerja</h4>
        <p class="card-category"></p>
    </div>
    <div class="card-body">
        @include('personnelEvaluation.navbar')

        @if($evaluators->count() > 0)
        <div class="table-responsive tableFixHead">
            <table class="table table-bordered">
                <thead class=" text-primary text-center">
                    <tr class="text-center" style="background-color: purple; color:white;">
                        <!-- <th rowspan="2">Kuartal | Tahun</th> -->
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
                    @foreach($evaluators as $evaluator)
                    <tr>
                        @if($evaluator->setting->where('year', $lastYear)->where('quarter', $lastQuarter)->count() )
                        
                        @foreach($evaluator->setting->where('year', $lastYear)->where('quarter', $lastQuarter) as $setting)
                        <td>{{ $setting->jobTitle->job_title }} </td>
                        <td class="text-center">
                            <a href="/personnel-evaluation/assessor/personnels/allpersonnels/{{ $evaluator->jobId }}">
                                {{ $users->where('job_title_id', $setting->jobTitle->id )->count() }}
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="/personnel-evaluation/assessor/personnels/belummengisi/{{ $evaluator->jobId }}">
                                {{ $setting->jobDesc->whereIn('user_id', $users->pluck('id'))->whereNotIn('user_id', $setting->evaluationValue->pluck('userId') )->count() }}
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="/personnel-evaluation/assessor/personnels/prosesmengisi/{{ $evaluator->jobId }}">
                                {{ $setting->evaluationValue->where('ok_by_user', 0)->count() }}
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="/personnel-evaluation/assessor/personnels/selesaimengisi/{{ $evaluator->jobId }}">
                                {{ $setting->evaluationValue->where('ok_by_user', 1)->count() }}
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="/personnel-evaluation/assessor/personnels/siapevaluasi/{{ $evaluator->jobId }}">
                                {{ $setting->evaluationValue->where('ok_by_user', 1)->where('totalScore', '0.00')->count() }}
                            </a>
                        </td>
                        <td class=" text-center">
                            <a href="/personnel-evaluation/assessor/personnels/prosesevaluasi/{{ $evaluator->jobId }}">
                                {{ $setting->evaluationValue->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 0)->count() }}
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="/personnel-evaluation/assessor/personnels/selesaievaluasi/{{ $evaluator->jobId }}">
                                {{ $setting->evaluationValue->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 1)->count() }}
                            </a>
                        </td>
                        @endforeach
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    @endsection
