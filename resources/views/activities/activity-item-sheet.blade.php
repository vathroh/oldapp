@extends('layouts.MaterialDashboard')

@section('content')


<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>
	</div>
	@include('activities.navbar')
	<div class="card-body">

		<div class="mt-3">
			<span style="font-weight:bold;">Lembar evaluasi yang belum diisi:</span>
			@foreach($noSubjects as $noSubject)
			<div>{{ $loop->iteration }}. <a href="/training-evaluation/{{$noSubject->activity_id}}/{{$noSubject->id}}">{{ $noSubject->subject }}</a></div>
			@endforeach

			@if($activityQuestion < 0 ) <div>{{ $noSubjects->count() + 1 }}. <a href="/activity-evaluation/{{ $isActivityQuestions[0]->activity_id }}">Evaluasi Pelaksanaan Pelatihan</a>
		</div>
		@endif
	</div>
	<div class="mt-3">
		<span style="font-weight:bold;">Lembar evaluasi yang sudah diisi:</span>
		@foreach($isSubjects as $isSubject)
		<div>{{ $loop->iteration }}. {{ $isSubject->subject }}</div>
		@endforeach

		@if($activityQuestion > 0 )
		<div>{{ $noSubjects->count() + 1 }}. Evaluasi Pelaksanaan Pelatihan</div>
		@endif
	</div>
</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection