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
		<div class="col-md-3">
			<select id="quarter" type="text" class="form-control" name="quarter" required autofocus>
				<option value="1">I</option>
				<option value="2">II</option>
				<option value="3">III</option>
				<option value="4">IV</option>
				</select>
			</div>
		<div class="col-md-3">
			<select id="year" type="text" class="form-control" name="year" required>
				<option value="2020">2020</option>
				<option value="2021">2021</option>
				<option value="2021">2022</option>
			</select>
		</div>	
	</div>
	
	<div class="row">
		<div class="col">
			<h5 class="my-5 text-center">Daftar Personil Yang {{ $evaluasi }}</h5>
			
			<table class=" table-striped"style="width:100%;">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Nama</th>
						<th scope="col">Aksi</th>
						@if($evaluasi == "sudah-dievaluasi")
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
						@if($evaluasi == "belum-dievaluasi")
						<td>
							<a href="/personnel-evaluation-input/{{ $setting[0]->id }}/{{ $user->id }}"><button class="btn btn-success">Evaluasi Sekarang</button></a>							
						</td>
						@endif
						
						@if($evaluasi == "sudah-dievaluasi")
						<td class="text-center">
							<a href="/personnel-evaluation-input/{{ $setting[0]->id }}/{{ $user->id }}"><button class="btn btn-success">Lihat</button></a>
						</td>
						<td class="text-center">
							<a href="/personnel-evaluation-download/{{ $setting[0]->id }}/{{ $user->id }}"><button class="btn btn-success">Download</button></a>
						</td>
						@endif
						
						@if($evaluasi == "dalam-proses-evaluasi")
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
