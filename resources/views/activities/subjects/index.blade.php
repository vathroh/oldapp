@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">MATERI</h4>
	</div>
	<div class="card-body">
		<div class="mt-3">
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">
							<a class="tambah-pustaka" href= "/subjects/create">
								<i class="material-icons">library_add</i>
								<p>Tambah</p>
							</a>
						</th>
						<th scope="col">Materi</th>
						<th scope="col">Kegiatan</th>
						<th scope="col">Tanggal</th>
						<th scope="col">Jam Mulai</th>
						<th scope="col">Jam Selesai</th>
						<th scope="col">Evaluasi</th>
						<th scope="col">Edit</th>
						<th scope="col">Delete</th>
					</tr>
				</thead>
				<tbody>
				@foreach($subjects as $subject)
					<tr>
						<td scope="row">{{ $loop->iteration }}</td>
						<td>{{ $subject->subject }}</td>
						<td>{{ $subject->name	}}</td>
						<td>{{ $subject->date	}}</td>
						<td>{{ $subject->start_time }}</td>
						<td>{{ $subject->finish_time }}</td>
						<td>{{ $subject->evaluation_sheet }}</td>
						<td>
							<a href="/subjects/{{$subject->id}}/edit">
								<button type="button" class="btn btn-primary"> Edit</button>
							</a>
						</td>
						<td>
							<form method="post" action="/subjects/{{$subject->id }}"enctype="multipart/form-data">
							@method('delete')
							@csrf
							<a onclick="return confirm('Yakin mau menghapus data ini?')" href="/subjects/{{$subject->id}}">
							<button type="submit" class="btn btn-danger"> Delete</button>
							</a>
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
