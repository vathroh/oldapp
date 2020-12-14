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
			<h5 class="mt-3 text-center">Daftar Personil Yang {{ $evaluasi }}</h5>
			<h6 class="mb-3 text-center">Kuartal {{ $lastSetting->first()->quarter }} Tahun {{ $lastSetting->first()->year }}</h6>
			
			<table class=" table-striped"style="width:100%;">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Nama</th>
						<th scope="col">Posisi</th>
						<th scope="col">Kabupaten/Kota</th>
						<th scope="col">Aksi</th>
						@if($evaluasi == "selesai-dievaluasi")
						<th class="text-center" scope="col">
							Form
						</th>
						@endif
					</tr>
				</thead>
				<tbody>

					@foreach($users as $user)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>
						<td>{{ $user->name }}</td>
						<td>{{ $user->posisi()->first()->job_title }}</td>
						<td>{{ $user->jobDesc()->first()->kabupaten()->first()->NAMA_KAB }}</td>
						@if($evaluasi == "siap-dievaluasi")
						<td>
							<a href="/personnel-evaluation-input/{{ $lastSetting->first()->id }}/{{ $user->id }}"><button class="btn btn-success">Evaluasi Sekarang</button></a>							
						</td>
						@endif
						
						@if($evaluasi == "selesai-dievaluasi")
						<td class="text-center">
							<a href="/personnel-evaluation-input/{{ $lastSetting->first()->id }}/{{ $user->id }}"><button class="btn btn-success">Lihat</button></a>
						</td>
						<td class="text-center">
							<a href="/personnel-evaluation-download/{{ $lastSetting->first()->id }}/{{ $user->id }}" target="_blank"><button class="btn btn-success">Print</button></a>
						</td>
						@endif
						
						@if($evaluasi == "sedang-dievaluasi")
						<td class="text-center">
							<a href="/personnel-evaluation-input/{{ $lastSetting->first()->id }}/{{ $user->id }}">
								<button class="btn btn-success">Lanjutkan Evaluasi</button>
							</a>
						</td>
						@endif

						@if($evaluasi == "edit")
						<td class="text-center">
							<form method="post" action="/personnel-evaluation-edit-grant/{{ $user->evaluationValue()->first()->id }}">
								@method('put') @csrf
								<button type="submit" class="btn btn-success">izin</button>
							</form>
							<form method="post" action="/personnel-evaluation-edit-denied/{{ $user->evaluationValue()->first()->id }}">
								@method('put') @csrf
								<button type="submit" class="btn btn-success">tolak</button>
							</form>
						</td>
						@endif

					@if($evaluasi == "tolak")
						<td class="text-center">
							<form method="post" action="/personnel-evaluation-edit-grant/{{ $user->evaluationValue()->first()->id }}">
								@method('put') @csrf
								<button type="submit" class="btn btn-success">izin</button>
							</form>
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
