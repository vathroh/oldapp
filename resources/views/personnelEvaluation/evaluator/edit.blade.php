@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">Evaluasi Kinerja</h4>
    <p class="card-category">Kriteria</p>
  </div>
  <div class="card-body">
	    @include('personnelEvaluation.navbar')
		<form method="post" action="/personnel-evaluator/{{ $evaluators->first()->jobId }}" enctype="multipart/form-data">
		@csrf
		@method('put')

			<div class="form-group row mt-5">
				<div class="col-md-2 text-md-right">
					<label for="jobId">Nama Jabatan</label>
				</div>
				<div class="col-md-9">
					<select id="jobId" type="text" class="form-control" name="jobId">
						<option value="{{ $evaluators->first()->jobId }}">{{ $jobTitles->where('id', $evaluators->first()->jobId )->first()->job_title }}</option>
					</select>
				</div>
			</div>
			
			<div id="evaluator">
				
				@foreach($evaluators as $evaluator)				
				<div class="form-group row">
					<div class="col-md-2 text-md-right">
						<label for="evaluator1">Tim Penilai</label>
					</div>
					<div class="col-md-9">
						<select id="evaluator1" type="text" class="form-control" name="evaluator{{$loop->iteration}}" required>
						
							<option value="{{ $jobTitles->where('id', $evaluator->evaluator )->pluck('id')->first() }}">{{ $jobTitles->where('id', $evaluator->evaluator )->pluck('job_title')->first() }}</option>
							
							@foreach($jobTitles as $jobTitle)
							<option value="{{ $jobTitle->id }}">{{ $jobTitle->job_title }}</option>
							@endforeach
							
						</select>
					</div>
					<div class="col-md-1">
						<i id="add_evaluator" class="material-icons">add_circle</i>
						<i id="remove_evaluator" class="material-icons" style="color:red;">remove_circle</i>
					</div>
				</div>
				@endforeach
			</div>			
			
			<div class="text-center mt-5">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
			
		</form>
    </div>
    <div id="indexKPPpagination" class="row text-center">
		<div class="col justify-content-center">
			<span></span>
		</div>
    </div>
  </div>
</div>

<script>

//$("#evaluator i:nth-child(1)").click(function(e){
$("#evaluator").on('click', '#add_evaluator', function(e){
	e.preventDefault();
	var count = $("#evaluator").children().length + 1;	
	
	$.get('/personnel-evaluator-select', function (data) {
		
		$('#evaluator').append('<div class="form-group row">'
			+'<div class="col-md-2 text-md-right">'
				+'<label for="personnelEvaluationCriteriaId">Tim Penilai</label>'
			+'</div>'
			+'<div class="col-md-9">'
				+'<select type="text" name="evaluator' + count +'" id="evaluator' + count +'" class="form-control">'
					+'<option value="">Penilai...</option>'
				+'</select>'
			+'</div>'
			+'<div class="col-md-1">'
				+'<i id="add_evaluator" class="material-icons">add_circle</i>'
				+'<i id="remove_evaluator" class="material-icons" style="color:red;">remove_circle</i>'
			+'</div>'
		+'</div>');
		
		$.each(data, function (index, aspectObj) {
			$("#evaluator select").append('<option value="' + aspectObj.id + '">' + aspectObj.job_title + '</option>');
		});    
	
	});
	
		
});
	

$("#evaluator").on('click', '#remove_evaluator', function(e) {
    e.preventDefault();
    $(this).closest('.row').remove();
});



</script>
@endsection
