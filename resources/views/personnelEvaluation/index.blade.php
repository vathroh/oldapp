@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category"></p>
	</div>
	<div class="card-body">
		@include('personnelEvaluation.navbar')
		
		@if($notUser->where('id', Auth::user()->id )->count() > 0)
		
		@if($settings->count() > 0 )
			@php
			$lastYear		= $settings->pluck('year')->max();
			$lastQuarter 	= $settings->where('year', $lastYear)->pluck('quarter')->max();
			$jobTitleId		= $notUser->where('id', Auth::user()->id )->first()->job_title_id;
			$mySettingId	= $settings->where('year', $lastYear)->where('quarter', $lastQuarter)->where('jobTitleId', $jobTitleId );
			@endphp
		
		@if($mySettingId->count() > 0 )
			@php
			$settingId		= $mySettingId->first()->id;
			$myEvaluation	= $myEvaluations->where('settingId', $settingId );
			@endphp
			
		@if($myEvaluation->count() == 0 )
			
				<div class="my-3 text-center" style="border: 2px solid red; border-radius: 5px; padding: 20px;">
					<h5 style="color:red;">Anda Belum Mengisi Evaluasi Kinerja. </h5>
					<a href="personnel-evaluation-input/{{  $settings->where('year', $settings->pluck('year')->max())->pluck('id')->max() }} /{{ Auth::user()->id }}"><button class="btn btn-danger">Isi Sekarang</button></a>
				</div>
			
			@else
			
				<div class="my-3 text-center" style="border: 2px solid grey; border-radius: 5px; padding: 20px;">
					<h5 style="color:grey;">
						Evaluasi Kinerja Kuartal {{ $lastQuarter  }} Tahun {{ $lastYear }} 
						@if($myEvaluation->first()->ok_by_user == 1 )
							Sudah Selesai				
						@else
							<span style="color:red">Belum Selesai</span>						
						@endif
						Diinput.	
					</h5>
					<a href="personnel-evaluation-input/{{  $settingId }}/{{ Auth::user()->id }}">
						@if($myEvaluation->first()->ok_by_user == 1 )
							<button class="btn btn-primary">Lihat</button>
						@else
							<button class="btn btn-success">Selesaikan</button>
						@endif
					</a>
				</div>
			
			@endif
			@endif		
		@endif
		@endif
			
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
 </div>

@endsection
