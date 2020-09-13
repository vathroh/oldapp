@extends('layouts.MaterialDashboard')

@section('content')

<form method="post" action="{{ route('pustaka.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">PUSTAKA</h4>
    </div>
    <div class="card-body">
		<div class="form-group row mt-5">
			<div class="col-md-2 text-md-right">
				<label for="subject">Perihal</label>
            </div>
            <div class="col-md-10">
                <input id="subject" type="text" class="form-control" name="subject" required autofocus>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="description">Kategori</label>
            </div>
            <div class="col-md-10">
                <select class="custom-select" id="category" name="category">
					<option selected>Pilih Kategori</option>
					@foreach($categories as $category)
					<option value="{{ $category->id }}">{{ $category->name }}</option>
					@endforeach
				</select>
            </div>
        </div>
		<div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="description">Keterangan</label>
            </div>
            <div class="col-md-10">
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="link">Paste link disini</label>
            </div>
            <div class="col-md-10">
                <input id="link" type="text" class="form-control" name="link">
            </div>
        </div>
        <div class  = "d-flex">
			<div class="col-md-2 text-right">
				<label for="file">Upload file</label>
			</div>
			<div class="col-md-8">
				<div class="d-flex">
					<div class="custom-file">
						<input type="file" class="file-input" id="customFile"  name="file">
					</div>
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
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
