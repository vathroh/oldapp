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
							<a class="tambah-pustaka" href= "/evaluation-answers/create">
								<i class="material-icons">activity_add</i>
							</a>
						</th>
						<th scope="col">Pertanyaan</th>
						<th scope="col">Jawab</th>
						<th scope="col">Betul atau Salah</th>
						<th scope="col">Edit</th>
						<th scope="col">Delete</th>
					</tr>
				</thead>
				<tbody>
				@foreach($answers as $answer)
					<tr>
						<td scope="row">{{ $loop->iteration }}</td>
						<td>{{ $answer->question }}</td>
						<td>{{ $answer->answer	 }}</td>
						<td>{{ $answer->true_or_false }}</td>
						<td>
							<a href="/evaluation-answers/{{$answer->id}}/edit">
								<button type="button" class="btn btn-primary"> Edit</button>
							</a>
						</td>
						<td>
							<form method="post" action="/evaluation-answers/{{$answer->id }}"enctype="multipart/form-data">
							@method('delete')
							@csrf
							<a onclick="return confirm('Yakin mau menghapus data ini?')" href="/evaluation-answers/{{$answer->id}}">
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
