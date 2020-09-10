@extends('layouts.MaterialDashboard')

@section('content')
<form method="post" action="/blog/category/{{ $category[0]->id }}" enctype="multipart/form-data">
	@method('put')
    @csrf
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">BLOG</h4>
        <p class="card-category">Edit Kategori</p>
    </div>
    <div class="card-body">
		<div class="form-group row mt-5">
			<div class="col-md-2 text-md-right">
				<label for="blog_category">Nama Kategori</label>
            </div>
            <div class="col-md-10">
                <input id="blog_category" type="text" class="form-control" name="blog_category" value = "{{ $category[0]->name }}" required autofocus>
            </div>
        </div>
        <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
	</div>
</form>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
