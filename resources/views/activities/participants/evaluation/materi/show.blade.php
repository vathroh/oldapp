@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">{{ $subject->activity->name }} </h4>
    </div>
    @include('activities.participants.navbar')
    <div class="card-body">
        <form method="post" action="/kegiatan/peserta/evaluasi/materi/{{$subject->activity_id}}" enctype="multipart/form-data">
            @csrf

            <h4 class="text-center my-4">{{ $subject->subject }}</h4>
            <input type="hidden" name="activity_id" value="{{ $subject->activity->id }}">
            <input type="hidden" name="subject_id" value="{{ $subject->id }}">

            @foreach( $activity->quiz->where('for_all_subjects', 1) as $quiz )
            <div class="form-group row">
                <div class="col-1 text-right">
                    <label for="answer">{{ $loop->iteration }} </label>
                </div>

                <div class="col-md-11">
                    <p>{{ $quiz->question }}</p>
                    <input type="hidden" id="custId" name="question{{ $loop->iteration }}" value="{{ $quiz->id }}">

                    @for($i = 0; $i < $quiz->answer->count(); $i++)
                        <div class="check" style=" margin-left: 30px;">
                            <input class="form-check-input" type="radio" name="answer{{ $loop->iteration }}" id="answer{{ $loop->iteration }}{{$i}}" value="{{ $quiz->answer[$i]->id }}">
                            <label class="form-check-label" for="answer{{ $loop->iteration }}{{$i}}">
                                {{ $quiz->answer[$i]->answer}}
                            </label>
                        </div>
                        @endfor
                </div>
            </div>
            @endforeach

            <button type=" submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection