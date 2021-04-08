@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category"></p>
	</div>
	<div class="card-body">
		@include('personnelEvaluation.navbar')		
			
		<table class="table table-striped table-bordered">
			<thead>
				<tr class="text-center">
					<th>Kwartal</th>
					<th>Tahun</th>
					<th>Status Peng-input-an</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach($settings as $setting)
				@php
					$myevaluation = $myEvaluations->where('settingId', $setting->id)->first();
				@endphp
				@if($current_job_descs->where('user_id', 
						auth()->user()->id 
						)->where('starting_timestamp', '<', 
						Carbon\Carbon::parse($setting->year . '-' . 
						$setting->quarter*3 .'-' . 
						1)->timestamp)->where('finishing_timestamp', 
						'>', Carbon\Carbon::parse($setting->year . '-' 
						. $setting->quarter*3 .'-' . 
						1)->timestamp)->count() > 0)
				<tr class="text-center">
					<td>{{ $setting->quarter }}</td>
					<td>{{ $setting->year }}</td>
					
					<td> 
						@if(isset($myevaluation)) 
						
							@if($myEvaluations->where('settingId', $setting->id)->first()['ok_by_user'] == 1 )			
								Terkirim 
							@else 
								Belum Selesai 
							@endif
							
						@else
						
							Belum diinput
														
						@endif
					</td>
										
					<td> 
						<a href="personnel-evaluation-input/{{ $setting->id }}/{{Auth::user()->id }}">
						@if(isset($myevaluation)) 
						
							@if($myEvaluations->where('settingId', $setting->id)->first()['ok_by_user'] == 1 )
								<button class="btn btn-primary">Lihat</button> 
							@else 
								<button class="btn btn-success">Selesaikan</button>
							@endif
						@else
						
							<button class="btn btn-danger">Isi Sekarang</button>
							
						@endif
						</a> 						
					</td>
				</tr>
				@endif
				@endforeach
			</tbody>
		</table>	
		
    </div>
 </div>



@endsection
