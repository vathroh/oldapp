@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>
		
	</div>
	@include('activities.navbar')
	<div class="card-body">		
		<h5>Peserta:		</h5>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">Nama</th>
					<th scope="col">Posisi</th>
					<th scope="col">Kabupaten/Kota</th>
				</tr>
			</thead>
			<tbody>
				@foreach($participants->where('role', 'PESERTA') as $participant)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $participant->user()->first()->name }}</td>
					<td>{{ $participant->job_desc ? $participant->job_desc->posisi->job_title : ''}}</td>
					<td>{{ $participant->job_desc ? $participant->job_desc->areaKerja->kabupaten->NAMA_KAB : ''}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		
		
		<h5>Pemandu:		</h5>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">Nama</th>
					<th scope="col">Posisi</th>
					<th scope="col">Kabupaten/Kota</th>
				</tr>
			</thead>
			<tbody>
				@foreach($participants->where('role', 'PEMANDU') as $participant)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $participant->user()->first()->name }}</td>
					<td>{{ $participant->user()->first()->posisi()->first()->job_title }}</td>
					<td>{{ $participant->user()->first()->jobDesc()->first()->kabupaten()->first()->KD_KAB ?? 'OSP' }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		
		
		<h5>Panitia:		</h5>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">Nama</th>
					<th scope="col">Posisi</th>
					<th scope="col">Kabupaten/Kota</th>
				</tr>
			</thead>
			<tbody>
				@foreach($participants->where('role', 'PANITIA') as $participant)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $participant->user()->first()->name }}</td>
					<td>{{ $participant->user()->first()->posisi()->first()->job_title }}</td>
					<td>{{ $participant->user()->first()->jobDesc()->first()->kabupaten()->first()->KD_KAB ?? 'OSP' }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>		
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
