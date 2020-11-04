@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">Evaluasi Kinerja</h4>
    <p class="card-category">Kriteria</p>
  </div>
  <div class="card-body">
	  @include('personnelEvaluation.navbar')
		<form method="post" action="{{ route('personnel-evaluation-criteria.store') }}" enctype="multipart/form-data">
		@csrf

			<div class="form-group row mt-5">
				<div class="col-md-2 text-md-right">
					<label for="personnelEvaluationCriteriaName">Nama Kriteria</label>
				</div>
				<div class="col-md-10">
					<input id="personnelEvaluationCriteriaName" type="text" class="form-control" name="personnelEvaluationCriteriaName" required autofocus>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-md-2 text-md-right">
					<label for="personnelEvaluationCriteriaProportion">Bobot</label>
				</div>
				<div class="col-md-10">
					<input id="personnelEvaluationCriteriaProportion" type="text" class="form-control" name="personnelEvaluationCriteriaProportion" required>
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
