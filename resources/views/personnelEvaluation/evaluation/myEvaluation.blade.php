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
				
				@foreach($myEvaluations as $myevaluation)
				
				<tr class="text-center">
					<td> {{ $myevaluation->evaluationSetting->quarter }}</td>
					<td> {{ $myevaluation->evaluationSetting->year }}</td>
					<td>						
							@if($myevaluation['ok_by_user'] == 1 )			
								Terkirim 
							@else 
								Belum Selesai 
							@endif
					</td>
					<td>
						<a href="personnel-evaluation/being-assessed/achievement/{{ $myevaluation->id }}">
							@if($myevaluation['ok_by_user'] == 1 )
								<button class="btn btn-primary">Lihat</button> 
							@else 
								<button class="btn btn-success">Selesaikan</button>
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
