@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>
		
	</div>
	@include('activities.navbar')
	<div class="card-body">
		<div class="evaluation-container">
			@foreach($subjects as $subject)
			
			<h5>{{ $subject->subject }}</h5>
			<table class="table">
				<thead>
					<tr>
						<td rowspan="2">No</td>
						<td rowspan="2">Nama</td>
						<td rowspan="2">Posisi</td>
						@foreach($questions as $question)
						<td colspan="4">{{ $question->question }}</td>
						@endforeach
					</tr>
					<tr>
						@foreach($questions as $question)
						@foreach($answers->where('evaluation_question_id', $question->id)->sortBy('scale') as $answer)
						<td>{{ $answer->scale }}</td>
						@endforeach
						@endforeach
					</tr>
				</thead>
				<tbody>
					@foreach($participants->unique('KD_KAB') as $participant)
					<tr>
						<th colspan="10">{{ $participant->NAMA_KAB }}</th>
					</tr>
					@foreach($participants->where('KD_KAB', $participant->KD_KAB)->unique('KD_KAB') as $participantKAB)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>
						<td>{{ $participantKAB->name }}</td>
						<td>{{ $participantKAB->job_title }}</td>
						<td></td>
					</tr>
					@endforeach
					@endforeach
				  </tbody>
				</table>
				@endforeach	
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
