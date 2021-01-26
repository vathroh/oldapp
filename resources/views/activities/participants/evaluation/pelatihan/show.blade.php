@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">{{ $activity->name }} </h4>
    </div>
    @include('activities.participants.navbar')
    <div class="card-body">
        <a href=" /kegiatan/peserta/evaluasi/pelatihan">dfdf</a>
        <form method="post" action="/kegiatan/peserta/evaluasi/pelatihan/{{$activity->id}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="activity_id" value="{{ $activity->id }}">

            @foreach($activity->quiz->where('for_all_subjects', 0) as $quiz)

            <div class="form-group row">
                <div class="col-1 text-right">
                    <label for="answer">{{ $loop->iteration }}</label>
                </div>
                <div class="col-md-11">
                    <input type="hidden" name="question{{ $loop->iteration }}" value="{{ $quiz->id }}">
                    <p>{{ $quiz->question }}</p>

                    @for($i=0; $i<$quiz->answer->count();$i++ )
                        <div class="check" style=" margin-left: 30px;">
                            <input class="form-check-input" type="radio" name="answer{{ $loop->iteration }}" id="answer{{ $loop->iteration }}{{$i}}" value="{{ $quiz->answer[$i]->id }}">
                            <label class="form-check-label" for="answer{{ $loop->iteration }}{{$i}}">
                                {{ $quiz->answer[$i]->answer }}
                            </label>
                        </div>
                        @endfor

                </div>
            </div>

            @endforeach

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection