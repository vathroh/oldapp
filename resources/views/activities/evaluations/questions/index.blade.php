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
							<a class="tambah-pustaka" href= "/evaluation-questions/create">
								<i class="material-icons">activity_add</i>
							</a>
						</th>
						<th scope="col">Pertanyaan</th>
						<th scope="col">Nama Kegiatan</th>
						<th scope="col">Apakah pertanyaan ini untuk semua materi?</th>
						<th scope="col">Edit</th>
						<th scope="col">Delete</th>
					</tr>
				</thead>
				<tbody>
				@foreach($questions as $question)
					<tr>
						<td scope="row">{{ $loop->iteration }}</td>
						<td>{{ $question->question }}</td>
						<td>{{ $question->name	 }}</td>
						<td>{{ $question->for_all_subjects }}</td>
						<td>
							<a href="/evaluation-questions/{{$question->id}}/edit">
								<button type="button" class="btn btn-primary"> Edit</button>
							</a>
						</td>
						<td>
							<form method="post" action="/evaluation-questions/{{$question->id }}"enctype="multipart/form-data">
							@method('delete')
							@csrf
							<a onclick="return confirm('Yakin mau menghapus data ini?')" href="/evaluation-questions/{{$question->id}}">
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
