@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">Evaluasi Kinerja</h4>
    <p class="card-category">Kriteria</p>
  </div>
  <div class="card-body">
	    @include('personnelEvaluation.navbar')
		<form method="post" action="{{ route('personnel-evaluator.store') }}" enctype="multipart/form-data">
		@csrf

			<div class="form-group row mt-5">
				<div class="col-md-2 text-md-right">
					<label for="jobId">Nama Jabatan</label>
				</div>
				<div class="col-md-9">
					<select id="jobId" type="text" class="form-control" name="jobId" required autofocus>
						<option selected>Posisi...</option>
						@foreach($jobTitles as $jobTitle)
						<option value="{{ $jobTitle->id }}">{{ $jobTitle->job_title }}</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div id="evaluator">
				<div class="form-group row">
					<div class="col-md-2 text-md-right">
						<label for="evaluator1">Tim Penilai</label>
					</div>
					<div class="col-md-9">
						<select id="evaluator1" type="text" class="form-control" name="evaluator1" required autofocus>
							<option selected>Penilai...</option>
							@foreach($jobTitles as $jobTitle)
							<option value="{{ $jobTitle->id }}">{{ $jobTitle->job_title }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-1">
						<i class="material-icons">add_circle</i>
					</div>
				</div>
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

$("#evaluator i:nth-child(1)").click(function(){
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
				+'<i id="remove_evaluator" class="material-icons" style="color:red;">remove_circle</i>'
			+'</div>'
		+'</div>');
		
		$.each(data, function (index, aspectObj) {
			$("#evaluator select").append('<option value="' + aspectObj.id + '">' + aspectObj.job_title + '</option>');
		});    
	
	});
	
		
});
	


var ter = "#evaluator";

$(ter).on('click', '#remove_evaluator', function(e) {
    e.preventDefault();
    $(this).closest('.row').remove();
});



</script>
@endsection
