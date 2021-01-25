@extends('layouts.MaterialDashboard')

@section('content')


<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">{{ $activity->name }}</h4>
    </div>
    @include('activities.participants.navbar')
    <div class="card-body">
        <div class="mt-3">
            <span style="font-weight:bold;">Lembar evaluasi yang belum diisi:</span>
            @foreach($uncompletedEvaluation->whereNotIn('id', $activity->evaluation->unique('subject_id')->pluck('subject_id')) as $material )
            <div><a href="/kegiatan/peserta/evaluasi/materi/{{$activity->id}}/{{ $material->id }}">{{ $loop->iteration }}. {{ $material->subject }}</a></div>
            @endforeach

            @foreach($activity->trainingEvaluation->where('for_all_subjects', 0)->unique('activity_id') as $question )
            @if( $activity->evaluation->where('subject_id', 0)->count() == 0)
            <div>
                <a href="/kegiatan/peserta/evaluasi/pelatihan/{{$activity->id}}">
                    {{ $uncompletedEvaluation->whereNotIn('id', $activity->evaluation->unique('subject_id')->pluck('subject_id'))->count() + 1}} Evaluasi Pelaksanaan Pelatihan
                </a>
            </div>
            @endif
            @endforeach
        </div>

        <div class="mt-3">
            <span style="font-weight:bold;">Lembar evaluasi yang sudah diisi:</span>
            @foreach($activity->evaluation->whereNotIn('subject_id', [0])->unique('subject_id') as $finishedEvaluation)
            <div>{{ $loop->iteration }}. {{ $finishedEvaluation }}
            </div>
            @endforeach

            @foreach($activity->evaluation->whereIn('subject_id', [0])->unique('subject_id') as $finishedEvaluation)
            <div>
                {{ $activity->evaluation->whereNotIn('subject_id', [0])->unique('subject_id')->count() + $loop->iteration }}. Evaluasi Pelaksanaan Pelatihan.
            </div>
            @endforeach


        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection