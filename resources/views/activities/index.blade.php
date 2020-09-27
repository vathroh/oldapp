@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">CAPACITY BUILDING</h4>
	</div>
	<div class="card-body">
		<div class="mt-3">
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">
							<a class="tambah-pustaka" href= "/activity/create">
								<i class="material-icons">activity_add</i>
							</a>
						</th>
						<th scope="col">Kategori</th>
						<th scope="col">Nama Kegiatan</th>
						<th scope="col">Mulai</th>
						<th scope="col">Selesai</th>
						<th scope="col">Edit</th>
						<th scope="col">Delete</th>
					</tr>
				</thead>
				<tbody>
				@foreach($activities as $activity)
					<tr>
						<td scope="row">{{ $loop->iteration }}</td>
						<td>{{ $activity->name }}</td>
						<td>{{ $activity->activity_name	 }}</td>
						<td>{{ $activity->start_date }}</td>
						<td>{{ $activity->finish_date }}</td>
						<td>
							<a href="/activity/{{$activity->id}}/edit">
								<button type="button" class="btn btn-primary"> Edit</button>
							</a>
						</td>
						<td>
							<form method="post" action="/activity/{{$activity->id }}"enctype="multipart/form-data">
							@method('delete')
							@csrf
							<button type="submit" class="btn btn-danger"> Delete</button>
							</form>
						</td>
					</tr>	
				@endforeach
				</body>
			</table>
			<div class="text-center">
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
