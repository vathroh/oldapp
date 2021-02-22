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
                    @foreach($jobTitles as $jobTitle)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $jobTitle->job_title }} </td>
                        <td class="text-center">
                            @if($lastSetting->where('jobTitleId', $jobTitle->id)->count() != null )
                            <a href="/personnel-evaluation/hrm/personnels/allpersonnels/{{ $jobTitle->id }}">
                                {{ $jobTitle->jobDesc->count() }}
                            </a>
                            @else
                            {{ $jobTitle->jobDesc->count() }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if($lastSetting->where('jobTitleId', $jobTitle->id)->count() != null )
                            <a href="/personnel-evaluation/hrm/personnels/belummengisi/{{ $jobTitle->id }}">
                                {{ $lastSetting->where('jobTitleId', $jobTitle->id)->first()->jobDesc->whereNotIn('user_id', $lastSetting->where('jobTitleId', $jobTitle->id)->first()->evaluationValue->pluck('userId'))->count() }}
                            </a>
                            @else
                            Belum Diset
                            @endif
                        </td>
                        <td class="text-center">
                            @if($lastSetting->where('jobTitleId', $jobTitle->id)->count() != null )
                            <a href="/personnel-evaluation/hrm/personnels/prosesmengisi/{{ $jobTitle->id }}">
                                {{ $lastSetting->where('jobTitleId', $jobTitle->id)->first()->evaluationValue->where('ok_by_user', 0)->count() }}
                            </a>
                            @else
                            Belum Diset
                            @endif
                            </a>
                        </td>
                        <td class="text-center">
                            @if($lastSetting->where('jobTitleId', $jobTitle->id)->count() != null )
                            <a href="/personnel-evaluation/hrm/personnels/selesaimengisi/{{ $jobTitle->id }}">
                                {{ $lastSetting->where('jobTitleId', $jobTitle->id)->first()->evaluationValue->where('ok_by_user', 1)->count() }}
                            </a>
                            @else
                            Belum Diset
                            @endif
                            </a>
                        </td>
                        <td class="text-center">
                            @if($lastSetting->where('jobTitleId', $jobTitle->id)->count() != null )
                            <a href="/personnel-evaluation/hrm/personnels/siapevaluasi/{{ $jobTitle->id }}">
                                {{ $lastSetting->where('jobTitleId', $jobTitle->id)->first()->evaluationValue->where('ok_by_user', 1)->where('totalScore', '0.00')->count() }}
                            </a>
                            @else
                            Belum Diset
                            @endif
                            </a>
                        </td>
                        <td class=" text-center">
                            @if($lastSetting->where('jobTitleId', $jobTitle->id)->count() != null )
                            <a href="/personnel-evaluation/hrm/personnels/prosesevaluasi/{{ $jobTitle->id }}">
                                {{ $lastSetting->where('jobTitleId', $jobTitle->id)->first()->evaluationValue->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 0)->count() }}
                            </a>
                            @else
                            Belum Diset
                            @endif
                            </a>
                        </td>
                        <td class="text-center">
                            @if($lastSetting->where('jobTitleId', $jobTitle->id)->count() != null )
                            <a href="/personnel-evaluation/hrm/personnels/selesaievaluasi/{{ $jobTitle->id }}">
                                {{ $lastSetting->where('jobTitleId', $jobTitle->id)->first()->evaluationValue->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 1)->count() }}
                            </a>
                            @else
                            Belum Diset
                            @endif
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @endsection