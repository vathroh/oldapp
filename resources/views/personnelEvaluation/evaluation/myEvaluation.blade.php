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
					<th>Status Penilaian</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach($settings as $setting)
				@php
					$myevaluation = $myEvaluations->where('settingId', $setting->id)->first();
				@endphp
					
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
						@if(isset($myevaluation)) 
						
							@if($myEvaluations->where('settingId', $setting->id)->first()['ready'] == 1 )			
								Sudah Dinilai 
							@else 
								Belum Dinilai 
							@endif
							
						@else
						
							Belum Dinilai
														
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
				@endforeach
			</tbody>
		</table>	
		
    </div>
 </div>



@endsection
