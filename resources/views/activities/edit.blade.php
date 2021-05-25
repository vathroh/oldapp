@extends('layouts.MaterialDashboard')

@section('content')

<form method="post" action="/activity/{{$activity->id}}" enctype="multipart/form-data">
	@method('put')
    @csrf
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">EDIT DATA KEGIATAN</h4>
    </div>
    <div class="card-body">
		
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="description">Kategori</label>
            </div>
            <div class="col-md-10">
                <select class="custom-select" id="category" name="category" autofocus>
					<option value="{{ $activity->category_id }}">{{ $activity->name }}</option>
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
                <input id="name" type="text" class="form-control" name="name" value="{{ $activity->activity_name }}" required>
            </div>
        </div>
        
		<div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="start_date">Tanggal Mulai</label>
            </div>
            <div class="col-md-10">
                <input id="start_date" type="date" class="form-control" name="start_date" value="{{ $activity->start_date }}"  required>
            </div>
        </div>
        <div class="form-group row">
			<div class="col-md-2 text-md-right">
				<label for="finish_date">Tanggal Selesai</label>
            </div>
            <div class="col-md-10">
                <input id="finish_date" type="date" class="form-control" name="finish_date" value="{{ $activity->finish_date }}" required>
            </div>
        </div>
        <div id="break_day">
			@if(($activity->break==""))
				<div class="form-group row">
				<div class="col-md-2 text-md-right">
					<label for="evaluator1">Break Day {{--$loop->iteration --}}</label>
				</div>
				<div class="col-md-9">
					<input id="break_day1" type="date" class="form-control" name="break[]" value="{{--$break--}}">
				</div>
				<div class="col-md-1">
					<i class="material-icons">add_box</i>
					
				</div>
			</div>
			@else
			@foreach(explode(',', $activity->break) as $break)
			<div class="form-group row">
				<div class="col-md-2 text-md-right">
					<label for="evaluator1">Break Day {{--$loop->iteration --}}</label>
				</div>
				<div class="col-md-9">
					<input id="break_day1" type="date" class="form-control" name="break[]" value="{{$break}}">
				</div>
				<div class="col-md-1">
					<i class="material-icons">add_box</i>
					<i id="break_minus_button" class="material-icons" style="color:red;">remove_circle</i>
				</div>
			</div>
			@endforeach
			@endif
		</div>

	<div class="form-group row">
		<div class="col-md-2 text-md-right">
		<label for="method">Metode Pelaksanaan</label>
            </div>
	    <div class="col-md-10">
		<select id="mothod" class="form-control"  name="method">
			<option value="{{ $activity->methods  }}" selected>{{ $activity->methods === true ? 'Offline' : 'Online'  }}</option>
			<option value="false">Offline</option>
			<option value="true">Online</option>
		</select>
            </div>
	</div>        
	
	<div class="form-group row">
		<div class="col-md-2 text-md-right">
		<label for="finish_date">Link Zoom</label>
            </div>
            <div class="col-md-10">
                <input id="zoom_link" type="text" class="form-control" name="zoom_link" value="{{ $activity->zoom_link }}"/>
            </div>
	</div>        
	
	<div class="form-group row">
		<div class="col-md-2 text-md-right">
		<label for="record_link">Link Rekaman</label>
            </div>
            <div class="col-md-10">
                <input id="record_link" type="text" class="form-control" name="record_link" value="{{ $activity->record_link }}" />
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
