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
						$tanggal = Carbon\Carbon::parse($start);
						$day = $tanggal->addDays($i);
						$day1 =  $day->format('Y-m-d');
						@endphp
						{{ $day->format('l, d F Y') }}
					</div>	


					<div>
						<ol>				
							@foreach($attendances->where('tanggal', $day1) as $attendance)					
							<li>								
								<tr>		
									<td>{{ $attendance->user()->first()->name }}</td>
									<td>{{ $attendance->user()->first()->posisi()->pluck('job_title')->first() }}</td>
									<td>{{$attendance->user()->first()->jobDesc()->first()->kabupaten()->first()->NAMA_KAB ?? 'OSP' }}</td>	
								</tr>		
							</li>				
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
						$tanggal = Carbon\Carbon::parse($start);
						$day = $tanggal->addDays($i);
						$day1 =  $day->format('Y-m-d');
						@endphp
						{{ $day->format('l, d F Y') }}
					</div>					
					<div>
						<ol>
						
							@foreach($noAttendances->whereNotIn('user_id', $attendances->where('tanggal', $day1)->pluck('user_id') )->unique('user_id') as $noAttendance)			
							<li>
								{{ $noAttendance->user()->first()->name }}
								{{ $noAttendance->user()->first()->posisi()->pluck('job_title')->first() }}
								{{ $noAttendance->user()->first()->jobDesc()->first()->kabupaten()->first()->NAMA_KAB ?? 'OSP' }}
							</li>						
						@endforeach
						</ol>
					</div>				
				</div>
				@endfor
			</div>
		</div>


	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
