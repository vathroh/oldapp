@extends('layouts.MaterialDashboard')

@section('content')
@php
$activity = $activity_id
@endphp




<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id',$activity_id)->pluck('name')->first() }} </h4>
	</div>
	@include('activities.navbar')
	<div class="card-body">

		<form method="post" action="/activity-evaluation/{{ $activity_id }}" enctype="multipart/form-data">
			@csrf
			<div class="form-group row mt-5">
				<div class="col-md-2 text-md-right">
					<label>Kegiatan</label>
				</div>
				<div class="col-md-10">
					<input id="activity" type="text" class="form-control" name="activity" value="{{ $activities->where('id',$activity_id)->pluck('name')->first() }}" readonly style="border:none;">
				</div>
			</div>

			@foreach($questions as $question)

			<div class="form-group row">
				<div class="col-1 text-right">
					<label for="answer">{{ $loop->iteration }} </label>
				</div>
				<div class="col-md-11">
					<input id="answer" readonly type="text" class="form-control" name="question{{ $loop->iteration }}" value="{{ $question->question }}" style="border:none;">
					@php
					$count = $answers->where('evaluation_question_id', $question->id)->count();
					@endphp
					@for ($i = 0; $i < $count; $i++) <div class="check" style=" margin-left: 30px;">
						<input class="form-check-input" type="radio" name="answer{{ $loop->iteration }}" id="answer{{ $loop->iteration }}{{$i}}" value="{{ $answers->where('evaluation_question_id', $question->id)->where('scale', $i+1)->pluck('id')->first()}}">
						<label class="form-check-label" for="answer{{ $loop->iteration }}{{$i}}">
							{{ $answers->where('evaluation_question_id', $question->id)->where('scale', $i+1)->pluck('answer')->first() }}
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