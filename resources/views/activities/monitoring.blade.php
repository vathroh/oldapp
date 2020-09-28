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
				<h5>Sudah Mengisi Daftar Hadir</h5>		
				@for($i=0; $i<$period; $i++)
				<div>
					<div class="mt-3">
						@php
						$tanggal = Carbon\Carbon::parse($attendances[0]->date);
						@endphp
						{{ $tanggal->addDays($i)->format('l, d F Y') }}
					</div>					
					<div>
						<ol>				
						@foreach($attendances->where('tanggal',  $tanggal->addDays($i)->format('Y-m-d')) as $attendance)					
							<li>{{$attendance->name }}</li>						
						@endforeach
						</ol>
					</div>				
				</div>
				@endfor
			</div>
			
			<div style="border: 1px solid black; border-radius: 5px; padding: 20px; margin: 10px; width:50%;">
				<h5>Belum Mengisi Daftar Hadir</h5>		
				@for($i=0; $i<$period; $i++)
				<div>
					<div class="mt-3">
						@php
						$tanggal = Carbon\Carbon::parse($attendances[0]->date);
						
						@endphp
						{{ $tanggal->addDays($i)->format('l, d F Y') }}
					</div>					
					<div>
						<ol>				
						@foreach($noAttendances->whereNotIn('id', $attendances->where('tanggal',  $tanggal->addDays($i)->format('Y-m-d'))->pluck('id') )->groupBy('id') as $noAttendance)	
			
							<li>{{ $noAttendance->first()->name }}</li>						
						@endforeach
						</ol>
					</div>				
				</div>
				@endfor
			</div>
		</div>
		<div class="monitoring-container d-flex">
			<div style="border: 1px solid black; border-radius: 5px; padding: 20px; margin: 10px; width:50%;">
				<h5>Sudah Mengisi Evaluasi Topik Belajar</h5>
				
				@foreach($subjects as $subject)
				<div class="mt-3">{{ $subject->subject }}</div>
					@foreach($evaluations->where('subject_id', $subject->id)->unique('users.id') as $evaluation)
					<ol>
						<li><div>{{ $evaluation->name }}</div></li>
					</ol>				
					@endforeach
				@endforeach	
				
			</div>
			
			<div style="border: 1px solid black; border-radius: 5px; padding: 20px; margin: 10px; width:50%;">
				<h5>Belum Mengisi Evaluasi Topik Belajar</h5>	
				
				@foreach($subjects as $subject)
				<div class="mt-3">{{ $subject->subject }}</div>
										
					<ol>
						@foreach($participants->whereNotIn('id', $evaluations->where('subject_id', $subject->id)->unique('users.id')->pluck('id') ) as $participant)
						<li><div>{{ $participant->name }}</div></li>
						@endforeach	
					</ol>
					
					
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
