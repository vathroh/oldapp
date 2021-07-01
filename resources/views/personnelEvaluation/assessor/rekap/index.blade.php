@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Evaluasi Kinerja</h4>
    </div>
    <div class="card-body">
        @include('personnelEvaluation.navbar')
        <div class="col-12">
            <ul>
                @foreach($evaluationSettings as $evaluationSetting)
                <li>
                    <a href="/personnel-evaluation/assessor/rekap/{{ $evaluationSetting->quarter }}/{{ $evaluationSetting->year }}">
                        Triwulan {{ $evaluationSetting->quarter }} Tahun {{ $evaluationSetting->year }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
