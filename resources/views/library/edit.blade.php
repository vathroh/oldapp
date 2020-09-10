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
                <input id="subject" type="text" class="form-control" name="subject" value="{{ $library->subject }}" required autofocus>
            </div>
        </div>
		<div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="description">Keterangan</label>
            </div>
            <div class="col-md-10">
                <textarea class="form-control" id="description" name="description" rows="3">{{ $library->description }} </textarea>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="link">File dari Google Drive/lainnya</label>
            </div>
            <div class="col-md-10">
                <input id="link" type="text" class="form-control" name="link" value="{{ $library->link }}" >
            </div>
        </div>
        <div class  = "d-flex">
			<div class="col-md-2 text-right">
				<label for="file">File</label>
			</div>
			<div class="col-md-10">
				<div class="custom-file">
					<input id="link" type="text" class="form-control" name="link" value="{{ $library->file }}" >
					<a href="/pustaka-file/{{$library->id}}/{{ $library->file }}/delete">Delete file</a>					
				</div>
			</div>
		</div>
		</br>
		<div class  = "d-flex">
			<div class="col-md-2 text-right">
				<label for="file">Ganti File</label>
			</div>
			<div class="col-md-10">
				<div class="custom-file">
					<input type="file" class="file-input" id="customFile"  value="cera" name="file">						
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
