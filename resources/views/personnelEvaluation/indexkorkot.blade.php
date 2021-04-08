@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category"></p>
	</div>
	<div class="card-body">
		@include('personnelEvaluation.navbar')
		
		@if($current_job_descs->where('user_id', auth()->user()->id )->count() > 0)
		
		@if($myEvaluationValues->count() == 0 && $lastSetting->where('jobTitleId', Auth::user()->jobDesc()->get()->first()->job_title_id)->count() > 0 )
		<div class="my-3 text-center" style="border: 2px solid red; border-radius: 5px; padding: 20px;">
			<h5 style="color:red;">Anda Belum Mengisi Evaluasi Kinerja. </h5>
			<a href="/personnel-evaluation-input/{{ $myEvaluationSetting->pluck('id')->first() }}/{{ Auth::user()->id }}"><button class="btn btn-danger">Isi sekarang</button></a>
		</div>

		@elseif($myEvaluationValues->count() > 0 )

		<div class="my-3 text-center" style="border: 2px solid grey; border-radius: 5px; padding: 20px;">
			<h5 style="color:grey;">
				Evaluasi Kinerja Kuartal {{ $lastQuarter }} Tahun {{ $lastYear }}
				@if($myEvaluationValues->get()->first()->ok_by_user == 1 )
				Sudah Selesai
				@else
				<span style="color:red">Belum Selesai</span>
				@endif
				Diinput.
			</h5>
			<a href="/personnel-evaluation-input/{{ $myEvaluationSetting->pluck('id')->first() }}/{{ Auth::user()->id }}">
				@if($myEvaluationValues->get()->first()->ok_by_user == 1 )
				<button class="btn btn-primary">Lihat</button>
				@else
				<button class="btn btn-success">Selesaikan</button>
				@endif
			</a>
		</div>
		@endif

		@if($evaluators->count() > 0)
		<div class="table-responsive tableFixHead">
			<table class="table table-bordered">
				<thead class=" text-primary text-center">
					<tr class="text-center" style="background-color: purple; color:white;">
						<!-- <th rowspan="2">Kuartal | Tahun</th> -->
						<th rowspan="2">Posisi Yang Dievaluasi</th>
						<th rowspan="2">Jumlah Personil</th>
						<th colspan="3">Personil</th>
						<th colspan="3">Tim Penilai</th>
					</tr>
					<tr class="text-center" style="background-color: purple; color:white;">
						<th>Belum Mengisi</th>
						<th>Proses</th>
						<th>Selesai Mengisi</th>
						<th>Siap Dievaluasi</th>
						<th>Sedang Dievaluasi</th>
						<th>Selesai Dievaluasi</th>
					</tr>
				</thead>
				<tbody>
					@foreach($zones->whereIn('level', 'Tim Faskel') as $zone)
					<tr>
						<td colspan="8" style="background-color:lightgreen;">
							{{ $zone->kabupaten->NAMA_KAB }}
						</td>
					</tr>
					@foreach($evaluators as $evaluator)
					@if($evaluator->setting->where('year', $lastYear)->where('quarter', $lastQuarter)->count() )
					@foreach($evaluator->setting->where('year', $lastYear)->where('quarter', $lastQuarter) as $setting)
					<tr>
						<td> {{ $setting->jobTitle->job_title }} </td>
						<td class="text-center">
							<a href="/personnel-evaluation/assessor/timfaskel/allpersonnels/{{ $evaluator->jobId }}/{{$zone->district}}">
								{{ $setting->jobDesc->where('work_zone_id', $zone->id)->whereIn('user_id', $users->pluck('id'))->count() }}
							</a>
						</td>
						<td class="text-center">
							<a href="/personnel-evaluation/assessor/timfaskel/belummengisi/{{ $evaluator->jobId }}/{{$zone->district}}">
								{{ $setting->jobDesc->where('work_zone_id', $zone->id)->whereIn('user_id', $users->pluck('id'))->whereNotIn('user_id', $setting->evaluationValue->pluck('userId') )->count() }}
							</a>
						</td>
						<td class=" text-center">
							<a href="/personnel-evaluation/assessor/timfaskel/prosesmengisi/{{ $evaluator->jobId }}/{{$zone->district}}">
								{{ $setting->evaluationValue->whereIn('userId', $zone->jobDesc->pluck('user_id'))->where('ok_by_user', 0)->count() }}
							</a>
						</td>
						<td class="text-center">
							<a href="/personnel-evaluation/assessor/timfaskel/selesaimengisi/{{ $evaluator->jobId }}/{{$zone->district}}">
								{{ $setting->evaluationValue->whereIn('userId', $zone->jobDesc->pluck('user_id'))->where('ok_by_user', 1)->count() }}
							</a>
						</td>
						<td class="text-center">
							<a href="/personnel-evaluation/assessor/timfaskel/siapevaluasi/{{ $evaluator->jobId }}/{{$zone->district}}">
								{{ $setting->evaluationValue->whereIn('userId', $zone->jobDesc->pluck('user_id'))->where('ok_by_user', 1)->where('totalScore', '0.00')->count() }}
							</a>
						</td>
						<td class=" text-center">
							<a href="/personnel-evaluation/assessor/timfaskel/prosesevaluasi/{{ $evaluator->jobId }}/{{$zone->district}}">
								{{ $setting->evaluationValue->whereIn('userId', $zone->jobDesc->pluck('user_id'))->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 0)->count() }}
							</a>
						</td>
						<td class="text-center">
							<a href="/personnel-evaluation/assessor/timfaskel/selesaievaluasi/{{ $evaluator->jobId }}/{{$zone->district}}">
								{{ $setting->evaluationValue->whereIn('userId', $zone->jobDesc->pluck('user_id'))->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 1)->count() }}
							</a>
						</td>
					</tr>

					@endforeach
					@endif
					@endforeach
					@endforeach
				</tbody>
			</table>
		</div>
		@endif
		@endif
	</div>

	@endsection
