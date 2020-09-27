@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>
		
	</div>
	@include('activities.navbar')
	<div class="card-body">
		
		<div class="mt-3">			
			<table class="table table-bordered">
				<thead>
					<tr  class="table-info">
					  <th scope="col">Waktu</th>
					  <th scope="col">Materi</th>
					  <th scope="col">Pemandu/Moderator</th>
					</tr>
				</thead>
				<tbody>
					@for($i=0; $i<$period; $i++)
					<tr class="table-warning">
						<td colspan="3">
							{{ Carbon\Carbon::parse($subjects[0]->date)->addDays($i)->format('l, d F Y')  }}
						</td>
					</tr>
					@foreach($subjects->where('date', Carbon\Carbon::parse($subjects[0]->date)->addDays($i)->format('Y-m-d') ) as $subject)
					<tr>
						<td>{{ $subject->start_time }} - {{ $subject->finish_time }}</td>
						<td>{{ $subject->subject }}</td>
						<td>{{ $users->where('id', $subject->instructor1_id)->pluck('name')->first() }}</td>
					</tr>
					@endforeach
					@endfor
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
