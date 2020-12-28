@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">BLOG</h4>
		<p class="card-category">Post</p>
	</div>
	<div class="card-body">
		

	<form method="post" action="/blog/delete/{{ $post->id  }}/{{ $image }}" enctype="multipart/form-data">
	@method('put')
	@csrf
		<div class="d-flex mt-3" style="justify-content: center;">
			<img src = "{{ asset('/storage/blog/' . $post->$image)  }}" style = "border-radius: 8px;">					
		</div>
		<div class="d-flex mt-3" style = "justify-content: center; padding: 15px 0;" >
			<button type="submit" class="mt-0 btn btn-danger btn-sm" name ="delete" style="border-radius:8px;">Delete Gambar</button>
			</form>
			</form method="post" action="/blog/update-image/{{$post->id}}" enctype="multipart/form-data">
			@method('put')
			@csrf
			<input type="file" id="customFile"  name="image">
			<button class="mt-0 btn btn-primary btn-sm" name ="update" style="border-radius:8px;">Ganti Gambar</button>
        </div>
	</form>
</div>
		
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
