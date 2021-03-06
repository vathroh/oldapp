@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category"></p>
	</div>
	<div class="card-body">
		@include('personnelEvaluation.navbar')
		<div class="table-responsive tableFixHead">
			<table class="table table-bordered">
				<thead class=" text-primary text-center">
					<tr class="text-center">
						<th>Kuartal | Tahun</th>
						<th>Nama</th>
						<th>Posisi</th>
						<th>Kabupaten/Kota</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>

						@foreach($personnels as $personnel)
						<tr>
							<td></td>
							<td>{{$personnel->user->name}}</td>
							<td>{{$personnel->user->posisi->job_title}}</td>
							<td>{{$personnel->jobDesc->kabupaten->first()->NAMA_KAB}}</td>
							<td class="text-center d-flex">
								<form method="post" action="personnel-evaluation-edit-grant-user/{{$personnel->id}}">
									@method('put')
									@csrf							
									<button class="btn btn-primary">Izinkan</button>
								</form>
								<form method="post" action="personnel-evaluation-edit-denied-user/{{$personnel->id}}">
									@method('put')
									@csrf
									<button class="btn btn-warning">Tolak</button>
								</form>
						</td>
						</tr>
						@endforeach
				</tbody>
			</table>
		</div>
    </div>
 </div>



@endsection

