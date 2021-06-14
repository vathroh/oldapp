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
					<th scope="col">HP/WA</th>
				</tr>
			</thead>
			<tbody>
				@foreach($participants as $participant)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $participant['name'] }}</td>
					<td>{{ $participant['job_title'] }}</td>
					<td>{{ $participant['kab'] }}</td>
					<td>{{ \App\User::find($participant['user_id'])->biodata->HP ?? '' }}</td>
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
				@foreach($instructors as $instructor)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $instructor['name'] }}</td>
					<td>{{ $instructor['job_title'] }}</td>
					<td>{{ $instructor['kab'] }}</td>
					<td>{{ \App\User::find($instructor['user_id'])->biodata->HP ?? '' }}</td>
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
                @foreach($organizers as $organizer)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $organizer['name'] }}</td>
					<td>{{ $organizer['job_title'] }}</td>
					<td>{{ $organizer['kab'] }}</td>
					<td>{{ \App\User::find($organizer['user_id'])->biodata->HP ?? '' }}</td>
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
