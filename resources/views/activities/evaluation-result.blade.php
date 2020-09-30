@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>
		
	</div>
	@include('activities.navbar')
	<div class="card-body">
		<div style="height: 60vh; overflow: auto;">
		
			@foreach($subjects as $subject)
			
			<h5 class="text-center mt-5" style="width:100%;">{{ $subject->subject }}</h5>
			
			<table class="table table-striped table-bordered">
				<thead class="thead-dark">
					<tr>
						<td class="text-center" rowspan="2">Pertanyaan</td>
						<td class="text-center" colspan="4">Jumlah Jawaban</td>
					</tr>
					<tr>
						<td class="text-center">1</td>
						<td class="text-center">2</td>
						<td class="text-center">3</td>
						<td class="text-center">4</td>						
					</tr>
				</thead>
				<tbody id="participants">	
					@foreach($questions as $question)	
					<tr>						
						<td>{{ $question->question }}</td>
						<td class="text-center">{{ $evaluations->where('subject_id', $subject->id)->where('question_id', $question->id)->where('scale', 1)->count() }}</td>
						<td class="text-center">{{ $evaluations->where('subject_id', $subject->id)->where('question_id', $question->id)->where('scale', 2)->count() }}</td>
						<td class="text-center">{{ $evaluations->where('subject_id', $subject->id)->where('question_id', $question->id)->where('scale', 3)->count() }}</td>
						<td class="text-center">{{ $evaluations->where('subject_id', $subject->id)->where('question_id', $question->id)->where('scale', 4)->count() }}</td>
					</tr>
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
