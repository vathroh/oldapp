@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>
		
	</div>
	@include('activities.navbar')
	<div class="card-body">		
		Peserta:		
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
				@foreach($participants as $participant)
				<tr>
					<th scope="row">{{ $loop->iteration }}</th>
					<td>{{ $participant->name }}</td>
					<td>{{ $participant->job_title }}</td>
					<td>{{ $participant->NAMA_KAB }}</td>
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
