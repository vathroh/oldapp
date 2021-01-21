@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>
	</div>
	@include('activities.navbar')
	<div class="card-body">
		<div class="monitoring-container d-flex">

			<div style="border: 1px solid black; border-radius: 5px; padding: 20px; margin: 10px; width:50%;">
				<h5>Sudah Mengisi Evaluasi Topik Belajar</h5>
				@foreach($evaluations->unique('subject')->where('evaluation_sheet', 1) as $evaluation)
				<div>
					<div class="mt-3">
						{{ $evaluation->subject }}
					</div>
					<div>
						<ol>
							@foreach($evaluations->where('subject_id', $evaluation->subject_id)->unique('id') as $evaluationPerSubject)
							<li>{{ $evaluationPerSubject->name }}</li>
							@endforeach
						</ol>
					</div>
				</div>
				@endforeach
			</div>

			<div style="border: 1px solid black; border-radius: 5px; padding: 20px; margin: 10px; width:50%;">
				<h5>Belum Mengisi Evaluasi Topik Belajar</h5>
				@foreach($evaluations->unique('subject')->where('evaluation_sheet', 1) as $evaluation)
				<div>
					<div class="mt-3">
						{{ $evaluation->subject }}
					</div>
					<div>
						<ol>
							@foreach($participants->whereNotIn('id', $evaluations->where('subject_id', $evaluation->subject_id)->unique('user_id')->pluck('user_id')) as $participant)
							<li>{{ $participant->name }}</li>
							@endforeach
						</ol>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection