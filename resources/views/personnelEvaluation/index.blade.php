@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category"></p>
	</div>
	<div class="card-body">
		@include('personnelEvaluation.navbar')
		
		@if($value->count() == 0)
		<div class="my-3 text-center" style="border: 2px solid red; border-radius: 5px; padding: 20px;">
			<h5 style="color:red;">Anda Belum Mengisi Evaluasi Kinerja. </h5>
			<a href="personnel-evaluation-input/2/{{ Auth::user()->id }}"><button class="btn btn-primary">Isi Sekarang</button></a>
		</div>
		@endif
		{{ $settings }}

		<div class="row my-3 text-center"  style="width:50%; margin:auto;">		
			<div class="col-md-6">
				<select id="quarter" type="text" class="form-control" name="quarter" required>
					<option value="1">Triwulan I</option>
					<option value="2">Triwulan II</option>
					<option value="3">Triwulan III</option>
					<option value="4">Triwulan IV</option>
					</select>
				</div>
			<div class="col-md-6">
				<select id="year" type="text" class="form-control" name="year" required>
					<option value="2020">Tahun 2020</option>
					<option value="2021">Tahun 2021</option>
					<option value="2021">Tahun 2022</option>
				</select>
			</div>	
		</div>

		
		<div class="table-responsive tableFixHead">
			<table class="table table-bordered">
				<thead class=" text-primary text-center">
					<tr class="text-center" style="background-color: purple; color:white;">
						<th rowspan="2">Kuartal | Tahun</th>
						<th rowspan="2">Posisi Yang Dievaluasi</th>
						<th rowspan="2">Jumlah Personil</th>
						<th colspan="3">Isian Oleh Personil</th>
						<th colspan="3">Isian Oleh Tim Penilai</th>
					</tr>
					<tr class="text-center" style="background-color: purple; color:white;">						
						<th>Belum Mengisi</th>
						<th>Proses</th>
						<th>Sudah Mengisi</th>
						<th>Belum Dievaluasi</th>
						<th>Proses</th>
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
						<td></td>
						<td></td>
						<td></td>
						<td class="text-center" @if($notUser->where('job_title_id', $setting->jobTitleId)->whereNotIn('id', $isUser->where('settingId', $setting->id)->pluck('id'))->count() > 0) style="background-color:red;" @endif><a href="/personnel-evaluation-home/{{$setting->id}}/belum-dievaluasi">{{ $notUser->where('job_title_id', $setting->jobTitleId)->whereNotIn('id', $isUser->where('settingId', $setting->id)->pluck('id'))->count() }}</a></td>
						<td class="text-center"><a href="/personnel-evaluation-home/{{$setting->id}}/dalam-proses-evaluasi">{{ $isUser->where('settingId', $setting->id)->where('ready', 0)->count() }}</a></td>
						<td class="text-center"><a href="/personnel-evaluation-home/{{$setting->id}}/sudah-dievaluasi">{{ $isUser->where('settingId', $setting->id)->where('ready', 1)->count() }}</a></td>
					</tr>
					@endforeach
					@endforeach
				</tbody>
			</table>
		</div>
    </div>
 </div>

<script>
$(document).ready(function() {
	$.ajax({
		type	: 'get',
		url		: 'personnel-evaluation-home',
		success	: function(data){
		}	
		
	});
	$('table').css('color', 'red');
});
</script>

@endsection
