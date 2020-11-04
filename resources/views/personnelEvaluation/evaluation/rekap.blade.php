@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category">Kriteria</p>
	</div>
	<div class="card-body">
	@include('personnelEvaluation.navbar')
	
	<div class="row">
		<div class="col">
			<h5 class="my-5 text-center">REKAP EVALUASI KINERJA PERSONIL </h5>
			
			<table class=" table-striped"style="width:100%;">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Nama</th>
						<th scope="col">Posisi</th>
						<th scope="col">Kabupaten/Kota</th>
						<th scope="col">Nilai (%)</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tbody>

					@foreach($users as $user)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>
						<td>{{ $user->name }}</td>
						<td>{{ $jobDescs->where('user_id', $user->id)->first()->job_title }}</td>
						<td>{{ $jobDescs->where('user_id', $user->id)->first()->NAMA_KAB }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->totalScore }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->finalResult }}</td>
					</tr>
					@endforeach

				</tbody>
			</table>

		</div>	
		
	</div>
	
	

	
	
	
	
</div>


@endsection
