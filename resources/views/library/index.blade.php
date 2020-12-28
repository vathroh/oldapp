@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">PUSTAKA</h4>
	</div>
	<div class="card-body">
		<div class="mt-3">
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">
							<a class="tambah-pustaka" href= "/pustaka/create">
								<i class="material-icons">library_add</i>
								<p>Tambah</p>
							</a>
						</th>
						<th scope="col">Perihal</th>
						<th scope="col">Kategori</th>
						<th scope="col">Keterangan</th>
						<th scope="col">Link dari web lain</th>
						<th scope="col">Nama File</th>
						<th scope="col">Edit</th>
						<th scope="col">Delete</th>
					</tr>
				</thead>
				<tbody>
				@foreach($libraries as $library)
					<tr>
						<td scope="row">{{ $loop->iteration }}</td>
						<td>{{ $library->subject }}</td>
						<td>{{ $library->name	 }}</td>
						<td>{{ $library->description }}</td>
						<td>{{ $library->link }}</td>
						<td>{{ $library->file }}</td>
						<td>
							<a href="/pustaka/{{$library->id}}/edit">
								<button type="button" class="btn btn-primary"> Edit</button>
							</a>
						</td>
						<td>
							<form method="post" action="/pustaka/{{$library->id }}"enctype="multipart/form-data">
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
