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
						<th scope="col">Posisi</th>
						<th>Kabupaten/Kota</th>
						<th scope="col">Aksi</th>
						@if($evaluasi == "selesai-dievaluasi")
						<th class="text-center" scope="col">
							<button class="btn btn-success">Download Semua</button>
						</th>
						@endif
					</tr>
				</thead>
				<tbody>

					@foreach($users as $user)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>
						<td>{{ $user->name }}</td>
						<td>{{ $user->job_title }}</td>
						<td>{{ $user->NAMA_KAB }}</td>
						@if($evaluasi == "siap-dievaluasi")
						<td>
							<a href="/personnel-evaluation-input/{{ $setting[0]->id }}/{{ $user->id }}"><button class="btn btn-success">Evaluasi Sekarang</button></a>							
						</td>
						@endif
						
						@if($evaluasi == "selesai-dievaluasi")
						<td class="text-center">
							<a href="/personnel-evaluation-input/{{ $setting[0]->id }}/{{ $user->id }}"><button class="btn btn-success">Lihat</button></a>
						</td>
						<td class="text-center">
							<a href="/personnel-evaluation-download/{{ $setting[0]->id }}/{{ $user->id }}"><button class="btn btn-success">Download</button></a>
						</td>
						@endif
						
						@if($evaluasi == "sedang-dievaluasi")
						<td class="text-center">
							<a href="/personnel-evaluation-input/{{ $setting[0]->id }}/{{ $user->id }}">
								<button class="btn btn-success">Lanjutkan Evaluasi</button>
							</a>
						</td>
						@endif
					</tr>
					@endforeach

				</tbody>
			</table>

		</div>		
	</div>	
</div>



@endsection