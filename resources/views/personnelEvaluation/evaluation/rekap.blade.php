@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
	</div>
	<div class="card-body">
	@include('personnelEvaluation.navbar')
	
	<div class="row">
		<div class="col">
			<h5 class="my-5 text-center">REKAP EVALUASI KINERJA PERSONIL </h5>
		
			<div>
				<a href="/personnel-evaluation-download-rekap-all" >
					<button class="btn btn-primary" type="button">
						Download Excel
					</button>
				</a>
			</div>


			<table class=" table-striped"style="width:100%;">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Nama</th>
						<th scope="col">Posisi</th>
						<th scope="col">Kabupaten/Kota</th>
						<th scope="col">Nilai (%)</th>
						<th scope="col">Kualifikasi</th>
						<th scope="col">Isu</th>
						<th scope="col">Rekomendasi</th>
					</tr>
				</thead>
				<tbody>
				@if (Auth::user()->hasRole('hrm'))
				@foreach($users->where('ready', 1)->sortBy('jobTitleId') as $user)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>
						<td>{{ $user->name }}</td>
						<td>{{ $jobDescs->where('user_id', $user->id)->first()->job_title }}</td>
						<td>{{ $jobDescs->where('user_id', $user->id)->first()->NAMA_KAB }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->totalScore }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->finalResult }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->issue }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->recommendation }}</td>
					</tr>
					@endforeach
				@endif

				@if($jobDescs->where('user_id', Auth::user()->id )->first()->level == "Korkot" || "Askot Mandiri")

					@foreach($users->whereIn('jobTitleId', $evaluators->pluck('jobId'))->where('ready', 1)->sortBy('jobTitleId') as $user)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>
						<td>{{ $user->name }}</td>
						<td>{{ $jobDescs->where('user_id', $user->id)->first()->job_title }}</td>
						<td>{{ $jobDescs->where('user_id', $user->id)->first()->NAMA_KAB }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->totalScore }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->finalResult }}</td>
					</tr>
					@endforeach
				
				@else
					<tr>
						<td colspan="6" style="text-transform:uppercase;">tim korkot/askot mandiri</td>
					</tr>
					@foreach($users->where('ready', 1)->sortBy('jobTitleId')->whereNotIn('jobTitleId', [11])->unique('jobTitleId') as $user1)
					<tr>
						<td colspan="6" style="text-transform:uppercase;">{{ $jobDescs->where('user_id', $user1->id)->first()->job_title }}</td>
					</tr>
					@foreach($users->where('ready', 1)->sortBy('jobTitleId')->whereNotIn('jobTitleId', [11])->where('jobTitleId', $user1->jobTitleId) as $user)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>
						<td>{{ $user->name }}</td>
						<td>{{ $jobDescs->where('user_id', $user->id)->first()->job_title }}</td>
						<td>{{ $jobDescs->where('user_id', $user->id)->first()->NAMA_KAB }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->totalScore }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->finalResult }}</td>
					</tr>
					@endforeach
					@endforeach
					<tr><td colspan="6" class="text-center">==</td></tr>
					<tr>
						<td colspan="6" style="text-transform:uppercase;">tim faskel</td>
					</tr>
					@foreach($users->where('ready', 1)->whereIn('jobTitleId', [11])->unique('NAMA_KAB') as $user1)
					<tr>
						<td colspan="6">{{ $jobDescs->where('user_id', $user->id)->first()->NAMA_KAB }}</td>
					</tr>
					@foreach($users->where('ready', 1)->whereIn('jobTitleId', [11])->where('NAMA_KAB', $user1->NAMA_KAB) as $user)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>
						<td>{{ $user->name }}</td>
						<td>{{ $jobDescs->where('user_id', $user->id)->first()->job_title }}</td>
						<td>{{ $jobDescs->where('user_id', $user->id)->first()->NAMA_KAB }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->totalScore }}</td>
						<td>{{ $evaluations->where('userId', $user->id)->first()->finalResult }}</td>
					</tr>
					@endforeach
					@endforeach
	

				@endif
				</tbody>
			</table>
			{{ $users->links() }}
		</div>	
		
	</di>
	
	
</div>
@endsection
