@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">Evaluasi Kinerja</h4>
    <p class="card-category">Kriteria</p>
  </div>
  <div class="card-body">
	@include('personnelEvaluation.navbar')
    <div class="table-responsive tableFixHead">
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Kriteria</th>
					<th scope="col">Posisi</th>
					<th scope="col">Aspek</th>
					<th scope="col"><a href="/personnel-evaluation-aspect/create"><i class="material-icons">circle_plus</i></a></th>
				</tr>
			</thead>
			<tbody>
				@foreach($aspects as $aspect)
				<tr>
					<th scope="row">{{ $loop->iteration }}</th>
					<td>{{ $criterias->where('id', $aspect->criteria_id)->pluck('criteria')->first() }}</td>
					<td>{{ $jobTitles->where('id', $aspect->evaluate_to)->first()->job_title }}</td>
					<td>{{ $aspect->aspect }}</td>
					<td></td>
				</tr>
				@endforeach
			</tbody>
		</table>
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
