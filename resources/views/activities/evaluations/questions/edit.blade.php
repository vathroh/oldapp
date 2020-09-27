@extends('layouts.MaterialDashboard')

@section('content')

<form method="post" action="/evaluation-questions/{{ $question->id }}" enctype="multipart/form-data">
	@method('put')
    @csrf
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">INPUT PERTANYAAN LEMBAR EVALUASI</h4>
    </div>
    <div class="card-body">
		
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="activity">Kegiatan</label>
            </div>
            <div class="col-md-10">
                <select class="custom-select" id="activity" name="activity" autofocus>
					<option value="{{ $question->activity_id }}">{{ $question->name }}</option>
					@foreach($activities as $activity)
					<option value="{{ $activity->id }}">{{ $activity->name }}</option>
					@endforeach
				</select>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="question">Pertanyaan</label>
            </div>
            <div class="col-md-10">
                <input id="question" type="text" class="form-control" name="question" value="{{ $question->question }}" required>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label>Untuk Semua Materi / Hanya satu kali</label>
            </div>
            <div class="col-md-10">
                <div class="formcheck form-check-inline">
					<input class="form-check-input" type="radio" name="for_all_subjects" id="inlineRadio1" value="1" @if($question->for_all_subjects == 1) checked @endif>
					<label class="form-check-label" for="inlineRadio1">Untuk semua materi</label>
				</div>
				<div class="formcheck form-check-inline">
					<input class="form-check-input" type="radio" name="for_all_subjects" id="inlineRadio2" value="0" @if($question->for_all_subjects == 0	) checked @endif>
					<label class="form-check-label" for="inlineRadio2">hanya muncul 1 kali</label>
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
