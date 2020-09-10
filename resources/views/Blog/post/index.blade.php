@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">BLOG</h4>
		<p class="card-category">Post</p>
	</div>
	<div class="card-body">
		
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col"><a href="/blog/post/create"><i class="material-icons">note_add</i></a></th>
					<th scope="col">Judul</th>
					<th scope="col">Nama Kategori</th>
					<th scope="col">Terbit</th>
					<th scope="col">Edit</th>
					<th scope="col">Delete</th>
				</tr>
			</thead>
			<tbody>
				@foreach($posts as $post)
				<tr>
					<th scope="row">{{ $loop->iteration }}</th>
					<th>{{ $post->title }}</th>
					<td>{{ $post->name }}</td>
					<td>{{ $post->published }}</td>
					<td><a href="/blog/post/{{ $post->post_id }}/edit"><button class ="btn btn-success"><i class="material-icons">rule</i>  Edit</button></a></td>
					<td>
						<form action = "/blog/post/{{$post->post_id}}" method ="post">
							@csrf
							@method('delete')
							<a onclick="return confirm('Yakin?')" >
							<button class ="btn btn-danger"><i class="material-icons">delete</i>Delete</button></a>
						</form>
					</td>
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
