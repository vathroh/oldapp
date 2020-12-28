@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">Evaluasi Kinerja</h4>
    <p class="card-category">Kriteria</p>
  </div>
  <div class="card-body">
	  @include('personnelEvaluation.navbar')
		<form method="post" action="{{ route('personnel-evaluation-aspect.store') }}" enctype="multipart/form-data">
		@csrf

			<div class="form-group row mt-5">
				<div class="col-md-2 text-md-right">
					<label for="personnelEvaluationCriteriaId">Nama Kriteria</label>
				</div>
				<div class="col-md-10">
					<select id="personnelEvaluationCriteriaId" type="text" class="form-control" name="personnelEvaluationCriteriaId" required autofocus>
						<option selected>Pilih Kriteria...</option>
						@foreach($criterias as $criteria)
						<option value="{{ $criteria->id }}">{{ $criteria->criteria }}</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-md-2 text-md-right">
					<label for="personnelEvaluationAspect">Aspek</label>
				</div>
				<div class="col-md-10">
					<input id="personnelEvaluationAspect" type="text" class="form-control" name="personnelEvaluationAspect" required>
				</div>
			</div>
			
			<div id="evaluateTo" class="form-group row">
				<div class="col-md-2 text-md-right">
					<label for="evaluateTo">Evaluasi untuk</label>
				</div>
				<div class="col-md-10">
					<select id="evaluateTo" type="text" class="form-control" name="evaluateTo" required>
						<option selected>Pilih Posisi...</option>
						@foreach($jobTitles as $jobTitle)
						<option value="{{ $jobTitle->id }}">{{ $jobTitle->job_title }}</option>
						@endforeach
					</select>
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

<script src="{{ asset('js/kpp/searchIndexKPP.js') }}"></script>


@endsection
