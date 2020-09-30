@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>
		
	</div>
	@include('activities.navbar')
	<div class="card-body">
		<div class="evaluation-container">

			<table class="table">
				<thead>
					<tr>
						<td rowspan="2">No</td>
						<td rowspan="2">Nama</td>
						<td rowspan="2">Posisi</td>
						<td rowspan="2">Kabupaten/Kota</td>
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
					@foreach($participants as $participant)				
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td> {{ $participant->name }}</td>
						<td> {{ $participant->job_title }}</td>
						<td> {{ $participant->NAMA_KAB }}</td>
					</tr>
					@endforeach
				  </tbody>
				</table>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
