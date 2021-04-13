@extends('layouts.MaterialDashboard')
@section('head')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
@endsection

@section('content')

<form method="post" action="{{ route('activity.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">INPUT DATA KEGIATAN</h4>
    </div>
    <div class="card-body">
		
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="description">Kategori</label>
            </div>
            <div class="col-md-10">
                <select class="custom-select" id="category" name="category" autofocus>
					<option selected>Pilih Kategori</option>
					@foreach($categories as $category)
					<option value="{{ $category->id }}">{{ $category->name }}</option>
					@endforeach
				</select>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="name">Nama Kegiatan</label>
            </div>
            <div class="col-md-10">
                <input id="name" type="text" class="form-control" name="name" required>
            </div>
        </div>
        
		<div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="start_date">Tanggal Mulai</label>
            </div>
            <div class="col-md-10">
                <input id="start_date" type="date" class="form-control" name="start_date" required>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="finish_date">Tanggal Selesai</label>
            </div>
            <div class="col-md-10">
                <input id="finish_date" type="date" class="form-control" name="finish_date" required>
            </div>
        </div>        
        <div id="break_day">
			<div class="form-group row">
				<div class="col-md-2 text-md-right">
					<label for="evaluator1">Break</label>
				</div>
				<div class="col-md-9">
					<input id="break_day1" type="date" class="form-control" name="break[]">
				</div>
				<div class="col-md-1">
					<i class="material-icons">add_box</i>
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
<script>
$("#break_day i:nth-child(1)").click(function(){
	var count = $("#break_day").children().length + 1;		
	$('#break_day').append('<div class="form-group row">'
		+'<div class="col-md-2 text-md-right">'				
		+'</div>'
		+'<div class="col-md-9">'
			+'<input type="date" name="break[]' + count +'" id="break_day' + count +'" class="form-control" required>'
		+'</div>'
		+'<div class="col-md-1">'
			+'<i id="break_minus_button" class="material-icons" style="color:red;">remove_circle</i>'
		+'</div>'
	+'</div>');
});
	
var ter = "#break_day";

$(ter).on('click', '#break_minus_button', function(e) {
    e.preventDefault();
    $(this).closest('.row').remove();
});
</script>
@endsection
