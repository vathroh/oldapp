@extends('layouts.MaterialDashboard')

@section('head')
<link href="{{ asset('/css/bootstrap-timepicker.css') }}" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript" src="{{ asset('/js/bootstrap-timepicker.min.js') }}"></script>
@endsection

@section('content')
<form method="post" action="{{ route('subjects.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">MATERI</h4>
    </div>
    <div class="card-body">
		
		<div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="activity">Kegiatan</label>
            </div>
            <div class="col-md-10">
                <select class="custom-select" id="activity" name="activity">
					<option selected>Pilih Kegiatan</option>
					@foreach($activities as $activity)
					<option value="{{ $activity->id }}">{{ $activity->name }}</option>
					@endforeach
				</select>
            </div>
        </div>
        
		<div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="subject">Materi</label>
            </div>
            <div class="col-md-10">
                <input id="subject" type="text" class="form-control" name="subject" required>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="instructor1">Pemandu 1</label>
            </div>
            <div class="col-md-10">
                <select class="custom-select" name="instructor1" multiple>
					  <option>Pilih Pemandu</option>
					  @foreach($instructors as $instructor)
					  <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
					  @endforeach
				</select>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="instructor2">Pemandu 2</label>
            </div>
            <div class="col-md-10">
                <select class="custom-select" name="instructor2" multiple>
					  <option>Pilih Pemandu</option>
					  @foreach($instructors as $instructor)
					  <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
					  @endforeach
				</select>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="date">Tanggal</label>
            </div>
            <div class="col-md-10">
                <input id="date" type="date" class="form-control" name="date" required>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="start_time">Jam Mulai</label>
            </div>
            <div class="col-md-10">
                <div class="input-group bootstrap-timepicker timepicker">
					 <input id="start_time" name="start_time" class="form-control" data-provide="timepicker" data-template="modal" data-minute-step="15" data-modal-backdrop="true" type="text"/>
				</div>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="finish_time">Jam Selesai</label>
            </div>
            <div class="col-md-10">
				<div class="input-group bootstrap-timepicker timepicker">
					 <input id="finish_time" name="finish_time" class="form-control" data-provide="timepicker" data-template="modal" data-minute-step="15" data-modal-backdrop="true" type="text"/>
				</div>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="add_info">Keterangan</label>
            </div>
            <div class="col-md-10">
				<textarea class="form-control" id="add_info" name="add_info" rows="3"></textarea>
			</div>
		</div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label>Evaluasi Topik Belajar</label>
            </div>
            <div class="col-md-10">				        
				<div class="formcheck form-check-inline">
					<input class="form-check-input" type="radio" name="evaluation_sheet" id="inlineRadio1" value="1" checked>
					<label class="form-check-label" for="inlineRadio1">Perlu</label>
				</div>
				<div class="formcheck form-check-inline">
					<input class="form-check-input" type="radio" name="evaluation_sheet" id="inlineRadio2" value="0">
					<label class="form-check-label" for="inlineRadio2">Tidak Perlu</label>
				</div>
			</div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="link">Link Materi</label>
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
<script type="text/javascript">
    $('#start_time').timepicker();
    $('#finish_time').timepicker();
</script>
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
