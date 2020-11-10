@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">Evaluasi Kinerja</h4>
    <p class="card-category">Siapa menilai siapa</p>
  </div>
  <div class="card-body">
	
	@include('personnelEvaluation.navbar')
	
    <div class="tableFixHead" style="width:100%;">
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Posisi</th>
					<th scope="col">Penilai</th>
					<th scope="col">
						<a href="/personnel-evaluator/create">
							+
						</a>
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($evaluators->unique('jobId') as $evaluator)
				<tr>
					<th scope="row">{{ $loop->iteration }}</th>
					<td>{{ $jobTitles->where('id', $evaluator->jobId)->first()->job_title }}</td>
					<td>@foreach($evaluators->where('jobId', $evaluator->jobId) as $evaluator1) {{ $jobTitles->where('id',  $evaluator1->evaluator)->first()->job_title }}, @endforeach</td>
					<td class="d-flex">
						<a href="/personnel-evaluator/{{ $evaluator->jobId }}/edit">
							<button class="btn btn-success">Edit</button>
						</a>						
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
    </div>
  </div>
</div>


@endsection
