@extends('layouts.MaterialDashboard')
@section('head')
<script src="{{url('tinymce/jquery.tinymce.min.js')}}"></script>
<script src="{{url('tinymce/tinymce.min.js')}}"></script>
@endsection

@section('content')

<form method="post" action="/blog/post/{{ $post->post_id }}" enctype="multipart/form-data" id = "post_form">
@method('put')
@csrf
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">BLOG</h4>
        <p class="card-category">EDIT ARTIKEL</p>
    </div>
    <div class="card-body">
		<div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="post_title">Judul</label>
            </div>
            <div class="col-md-10">
                <input id="post_title" type="text" class="form-control" name="post_title" value = "{{ $post->title }}" required autofocus>
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
					<option value="{{ $post->category_id  }}">{{ $post->name  }}</option>
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
                <input class = "blog_content" id = "post_content" name = "post_content" value = "{{ $post->body }}" rows = "20">
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="post_keyword">Kata Kunci</label>
            </div>
            <div class="col-md-10">
                <input id="post_keyword" type="text" class="form-control" name="post_keyword" value = "{{ $post->keyword }}" required>
            </div>
        </div>
        <div class  = "form-group row">
			<div class="col-md-2 text-md-right">
				<label for="post_content">Gambar</label>
			</div>
			
            <div class="col-md-10">
                <div class="image-row mt-md-3">
                    <div class="image-row-item">
						<div class="image-row-item-space">
							<img src = "{{ asset('/storage/blog/' . $post->image1)  }}" style="width:100%;">
                        </div>
						<div class="image-row-item-space">
							<img src = "{{ asset('/storage/blog/' . $post->image2)  }}" style="width:100%;">
                        </div>
                    </div>                    
                    <div class="image-row-item">
                        <div class="button-row-item-space">
							<a href ="/blog/post-delete/{{$post->post_id }}/{{ 'image1' }}/edit" class="mt-0 btn btn-primary btn-sm" style="border-radius:8px;">Ganti / Hapus</a>
							<a href ="/blog/post-delete/{{$post->post_id }}/{{ 'image2' }}/edit" class="mt-0 btn btn-primary btn-sm" style="border-radius:8px;">Ganti / Hapus</a>
						</div>
                    </div>                    
				</div>
				                <div class="image-row mt-md-3">
                    <div class="image-row-item">
						<div class="image-row-item-space">
							<img src = "{{ asset('/storage/blog/' . $post->image3)  }}" style="width:100%;">
                        </div>
						<div class="image-row-item-space">
							<img src = "{{ asset('/storage/blog/' . $post->image4)  }}" style="width:100%;">
                        </div>
                    </div>                    
                    <div class="image-row-item">
                        <div class="button-row-item-space">
							<a href ="/blog/post-delete/{{$post->post_id }}/{{ 'image3' }}/edit" class="mt-0 btn btn-primary btn-sm" style="border-radius:8px;">Ganti / Hapus</a>
							<a href ="/blog/post-delete/{{$post->post_id }}/{{ 'image4' }}/edit" class="mt-0 btn btn-primary btn-sm" style="border-radius:8px;">Ganti / Hapus</a>
						</div>
                    </div>                    
				</div>
			</div>
		</div>
		
		<div class  = "d-flex mt-1">
			<div class="col-md-2 text-md-right">
				<label for="post_content">Terbitkan Blog</label>
			</div>
			<div class="col-md-8 d-flex">
				<div class="form-check">
					<input class="check-input" type="radio" name="published" id="exampleRadios1" value="1" @if ($post->published = 1) checked @endif>
					<label class="check-label" for="exampleRadios1">
						Sekarang
					</label>
				</div>
				<div class="form-check">
					<input class="check-input" type="radio" name="published" id="exampleRadios2" value="0" @if ($post->published = 0) checked @endif>
					<label class="check-label" for="exampleRadios2">
						Tunda
					</label>
				</div>
			</div>
		</div>
		
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>
<div id="data-container">
		</div>
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
			image_advtab: true, 
            });			
</script>

<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
