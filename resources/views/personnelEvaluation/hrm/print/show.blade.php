@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Evaluasi Kinerja</h4>
    </div>
    <div class="card-body">
        @include('personnelEvaluation.navbar')
        <ol>
            @foreach($evaluationSettings as $evaluationSetting)
            <li>
                <a href="/personnel-evaluation/hrm/cetak-perjabatan/{{$evaluationSetting->id}}">
                    {{ $evaluationSetting->jobTitle->job_title }}
                </a>
            </li>
            @endforeach
        </ol>
    </div>
</div>
@endsection