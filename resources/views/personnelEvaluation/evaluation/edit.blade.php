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
			<h5 class="my-5 text-center">Daftar Personil Yang {{ $evaluasi }}</h5>
			
			<table class=" table-striped"style="width:100%;">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Nama</th>
						<th scope="col">Aksi</th>
					</tr>
				</thead>
				<tbody>

					@foreach($users as $user)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>
						<td>{{ $user->name }}</td>
						<td>
							<a href="/personnel-evaluation-input/{{ $setting->id }}/{{ $user->id }}"><button class="btn btn-success">Evaluasi Sekarang</button></a>
						</td>
					</tr>
					@endforeach

				</tbody>
			</table>

		</div>	
		
	</div>
	
	

	
	
	
	
</div>

<script src="{{ asset('js/personnelEvaluation/jobTitles.js') }}"></script>
@endsection
