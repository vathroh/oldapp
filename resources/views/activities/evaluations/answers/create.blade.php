@extends('layouts.MaterialDashboard')

@section('content')

<form method="post" action="{{ route('evaluation-answers.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">INPUT JAWABAN LEMBAR EVALUASI</h4>
    </div>
    <div class="card-body">
		
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="activity">Kegiatan</label>
            </div>
            <div class="col-md-10">
                <select class="custom-select" id="activity" name="activity" autofocus>
					<option selected>Pilih Kegiatan</option>
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
				<select class="custom-select" id="question" name="question" autofocus>
				</select>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="answer">Jawab</label>
            </div>
            <div class="col-md-10">
                <input id="answer" type="text" class="form-control" name="answer" required>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="scale">Skala</label>
            </div>
            <div class="col-md-10">
                <input id="scale" type="text" class="form-control" name="scale" required  aria-describedby="answer">
                <small id="scale" class="form-text text-muted">
				Kurang = 1, Cukup = 2, Sangat = 4 | a = 1, b = 2, c = 3, d = 4, e =5
				</small>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label>Jawaban betul atau salah</label>
            </div>
            <div class="col-md-10">
                <div class="formcheck form-check-inline">
					<input class="form-check-input" type="radio" name="true_or_false" id="inlineRadio1" value="1">
					<label class="form-check-label" for="inlineRadio1">Jawaban betul</label>
				</div>
				<div class="formcheck form-check-inline">
					<input class="form-check-input" type="radio" name="true_or_false" id="inlineRadio2" value="0">
					<label class="form-check-label" for="inlineRadio2">Jawaban salah</label>
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
<script src="{{ asset('js/cb/chaineddropdown.js') }}" defer></script>
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
