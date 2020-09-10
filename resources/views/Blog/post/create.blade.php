@extends('layouts.MaterialDashboard')
@section('head')
<script src="{{url('tinymce/jquery.tinymce.min.js')}}"></script>
<script src="{{url('tinymce/tinymce.min.js')}}"></script>
@endsection

@section('content')

<form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">BLOG</h4>
        <p class="card-category">KETIK ARTIKEL BARU </p>
    </div>
    <div class="card-body">
		<div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="post_title">Judul</label>
            </div>
            <div class="col-md-10">
                <input id="post_title" type="text" class="form-control" name="post_title" required autofocus>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="post_category">
					Kategori
				</label>
			</div>
			<div class="col-md-10">
                <select name="post_category" id="post_category" class="form-control input-lg dynamic">
                    @foreach($categories as $category)
                    <option value="{{ $category->id  }}">{{ $category->name  }}</option>
                    @endforeach
				</select>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="post_content">Konten Blog</label>
            </div>
            <div class="col-md-10">
                <input class = "blog_content" id = "post_content" name = "post_content" rows = "20">
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="post_keyword">Kata Kunci</label>
            </div>
            <div class="col-md-10">
                <input id="post_keyword" type="text" class="form-control" name="post_keyword" required>
            </div>
        </div>
        <div class  = "d-flex">
			<div class="col-md-2 text-right">
				<label for="post_content">Gambar</label>
			</div>
			<div class="col-md-8">
				<div class="d-flex">
					<div class="custom-file">
						<input type="file" class="file-input" id="customFile"  name="image1">
					</div>
					<div class="custom-file">
						<input type="file" class="file-input" id="customFile"  name="image2">
					</div>
				</div>
				<div class="d-flex">
					<div class="custom-file">
						<input type="file" class="file-input" id="customFile"  name="image3">
					</div>
					<div class="custom-file">
						<input type="file" class="file-input" id="customFile"  name="image4">
					</div>
				</div>
			</div>
		</div>
		
		<div class  = "d-flex mt-3">
			<div class="col-md-2 text-right">
				<label for="post_content">Terbitkan Blog</label>
			</div>
			<div class="col-md-8 d-flex">
				<div class="form-check">
					<input class="check-input" type="radio" name="published" id="exampleRadios1" value="1" checked>
					<label class="check-label" for="exampleRadios1">
						Sekarang
					</label>
				</div>
				<div class="form-check">
					<input class="check-input" type="radio" name="published" id="exampleRadios2" value="0">
					<label class="check-label" for="exampleRadios2">
						Tunda
					</label>
				</div>
			</div>
		</div>
		
        <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
	</div>
</form>

@endsection

@section('script')
<!-- tinymce.init({
			selector: "textarea.blog_content",height: 500,
			plugins: [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
			"table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
			],
			toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
			toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
			image_advtab: true ,
			
			external_filemanager_path:"{{url('tinymce/filemanager')}}/",
			filemanager_title:"Responsive Filemanager" ,
			external_plugins: { "filemanager" : "{{url('tinymce')}}/filemanager/plugin.min.js"} });
-->
<script>tinymce.init({
			selector: "input.blog_content",height: 500,
			plugins: [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
			"table contextmenu directionality emoticons paste textcolor code"
			],
			toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
			toolbar2: "| responsivefilemanager | link unlink anchor | forecolor backcolor  | print preview code ",
			image_advtab: true
            });			
</script>
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
