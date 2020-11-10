@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category"></p>
	</div>
	<div class="card-body">
		@include('personnelEvaluation.navbar')
		<div class="row">		
			<div class="col-md-3">
				<select id="quarter" type="text" class="form-control" name="quarter" required autofocus>
					<option value="1">I</option>
					<option value="2">II</option>
					<option value="3">III</option>
					<option value="4">IV</option>
					</select>
				</div>
			<div class="col-md-3">
				<select id="year" type="text" class="form-control" name="year" required>
					<option value="2020">2020</option>
					<option value="2021">2021</option>
					<option value="2021">2022</option>
				</select>
			</div>
		</div>
		
		@if($evaluators->count() > 0)
		
		<div class="table-responsive tableFixHead">
			<table class="table table-bordered">
				<thead class=" text-primary text-center">
					<tr class="text-center" style="background-color: purple; color:white;">
						<th rowspan="2">Kuartal | Tahun</th>
						<th rowspan="2">Posisi Yang Dievaluasi</th>
						<th rowspan="2">Jumlah Personil</th>
						<th colspan="3">Diisi Oleh Personil</th>
												
						<th colspan="4">Diisi Oleh Tim Penilai</th>
						<th rowspan="2">Permintaan Edit</th>
						<th rowspan="2">Permintaan Edit Ditolak</th>
					</tr>
					<tr class="text-center" style="background-color: purple; color:white;">						
						<th>Belum Mengisi</th>
						<th>Proses</th>
						<th>Sudah Mengisi</th>
						<th>Belum Dievaluasi</th>
						<th>Siap Dievaluasi</th>
						<th>Sedang DiEvaluasi</th>
						<th>Selesai Dievaluasi</th>

					</tr>
				</thead>
				<tbody>

					@foreach($evaluators as $evaluator)
					@foreach($settings->where('jobTitleId', $evaluator->jobId)->sortBy('quarter')->sortBy('year') as $setting)
					<tr>
						<td>Kuartal {{ $setting->quarter }} Tahun {{ $setting->year }}</td>
						
						<td>{{ $setting->job_title }}</td>
						
						<td class="text-center">{{ $notUser->where('job_title_id', $setting->jobTitleId)->count() }}</td>
						
						<td class="text-center">
							<a href="/personnel-evaluation-home/{{$setting->id}}/belum-mengisi-evkinja">
								{{ $notUser->where('job_title_id', $setting->jobTitleId)->whereNotIn('id', $isUser->where('settingId', $setting->id)->pluck('id'))->count() }}
							</a>
						</td>
						
						<td class="text-center">
							<a href="/personnel-evaluation-home/{{$setting->id}}/sedang-mengisi-evkinja">
								{{ $isUser->where('settingId', $setting->id)->where('ok_by_user', 0)->count() }}
							</a>
						</td>						
						
						
						<td class="text-center">
							<a href="/personnel-evaluation-home/{{$setting->id}}/sudah-mengisi-evkinja">								
								{{ $isUser->where('settingId', $setting->id)->where('ok_by_user', 1)->count() }}
							</a>
						</td>
						
						<td class="text-center">
							{{ $notUser->where('job_title_id', $setting->jobTitleId)->whereNotIn('id', $isUser->where('settingId', $setting->id)->pluck('id'))->count() + $isUser->where('settingId', $setting->id)->where('totalScore', 0)->count()  }}
						</td>
						
						<td class="text-center" @if($isUser->where('settingId', $setting->id)->where('ok_by_user', 1)->count() > 0) style="color:red; font-weight:bold;" @endif>
							<a href="/personnel-evaluation-home/{{$setting->id}}/siap-dievaluasi">
								{{ $isUser->where('settingId', $setting->id)->where('ok_by_user', 1)->count() - $isUser->where('settingId', $setting->id)->where('totalScore', '>', 0 )->count() }}
							</a>
						</td>
						
						<td class="text-center">
							<a href="/personnel-evaluation-home/{{$setting->id}}/sedang-dievaluasi">
								{{ $isUser->where('settingId', $setting->id)->where('ready', 0)->where('totalScore', '>', 0 )->count() }}
							</a
						</td>
						
						<td class="text-center">
							<a href="/personnel-evaluation-home/{{$setting->id}}/selesai-dievaluasi">
								{{ $isUser->where('settingId', $setting->id)->where('ready', 1)->count() }}
							</a>
						</td>
					</tr>
					@endforeach
					@endforeach
				</tbody>
			</table>
			@endif
		
		
    </div>
 </div>



@endsection
