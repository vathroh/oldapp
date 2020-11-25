@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category"></p>
	</div>
	<div class="card-body">
		@include('personnelEvaluation.navbar')	
		
		

<!--
		<div class="row">		
			<div class="col-md-3">
				<select id="quarter" type="text" class="form-control" name="quarter" required autofocus>
					<option value="1">Triwulan I</option>
					<option value="2">Triwulan II</option>
					<option value="3">Triwulan III</option>
					<option value="4">Triwulan IV</option>
				</select>
			</div>
			<div class="col-md-3">
				<select id="year" type="text" class="form-control" name="year" required>
					<option value="2020">Tahun 2020</option>
					<option value="2021">Tahun 2021</option>
					<option value="2022">Tahun 2022</option>
				</select>
			</div>	
		</div>

-->
		
		<div class="table-responsive tableFixHead">
			<table class="table table-bordered">
				<thead class=" text-primary text-center">
					<tr class="text-center" style="background-color: purple; color:white;">
						<th rowspan="2">Kuartal | Tahun</th>
						<th rowspan="2">Posisi Yang Dievaluasi</th>
						<th rowspan="2">Jumlah Personil</th>
						<th colspan="3">Diisi Oleh Personil</th>												
						<th colspan="3">Evaluasi Oleh Tim Penilai</th>
						<th rowspan="2">Permintaan Edit</th>
						<th rowspan="2">Permintaan Edit Ditolak</th>
					</tr>
					<tr class="text-center" style="background-color: purple; color:white;">						
						<th>Belum Mengisi</th>
						<th>Proses</th>
						<th>Sudah Mengisi</th>
						<th>Siap</th>
						<th>Proses</th>
						<th>Selesai</th>
					</tr>
				</thead>
				<tbody>
				@foreach($settings as $setting)
					<tr>
						<td>Kuartal {{ $setting->quarter }} Tahun {{ $setting->year }}</td>
						<td>{{ $setting->jobTitle()->first()->job_title }}</td>
						<td><a href="/personnel-evaluation-monitoring-extend/jumlah-personil/{{ $setting->jobTitleId }}"> {{ $setting->jobDesc()->count() }} </a></td>
						<td><a href="/personnel-evaluation-monitoring-extend/belum-input/{{ $setting->jobTitleId }}">{{ $setting->jobDesc()->whereNotIn('user_id', $setting->evaluationValue()->pluck('userId'))->count() }} </a></td>
						<td><a href="/personnel-evaluation-monitoring-extend/proses-input/{{ $setting->jobTitleId }}">{{ $setting->evaluationValue()->where('ok_by_user', 0)->count() }} </a></td>
						<td><a href="/personnel-evaluation-monitoring-extend/selesai-input/{{ $setting->jobTitleId }}">{{ $setting->evaluationValue()->where('ok_by_user', 1)->count() }}</a></td>
						<td><a href="/personnel-evaluation-monitoring-extend/siap-dievaluasi/{{ $setting->jobTitleId }}">{{ $setting->evaluationValue()->where('ok_by_user', 1)->where('totalScore', '==', '0.00')->count() }}</a></td>
						<td><a href="/personnel-evaluation-monitoring-extend/proses-evaluasi/{{ $setting->jobTitleId }}">{{ $setting->evaluationValue()->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 0)->count() }}</a></td>
						<td><a href="/personnel-evaluation-monitoring-extend/selesai-evaluasi/{{ $setting->jobTitleId }}">{{ $setting->evaluationValue()->where('ready', 1)->count() }}</a></td>
						<td><a href="/personnel-evaluation-monitoring-extend/edit/{{ $setting->jobTitleId }}">{{ $setting->evaluationValue()->where('edit', 1)->count() }}</a></td>
						<td><a href="/personnel-evaluation-monitoring-extend/tolak/{{ $setting->jobTitleId }}">{{ $setting->evaluationValue()->where('edit', 2)->count() }}</a></td>
					</tr>
				@endforeach
	
				</tbody>
			</table>
			
		</div>
		
    </div>
 </div>



@endsection
