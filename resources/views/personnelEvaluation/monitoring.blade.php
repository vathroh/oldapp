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
		
		<div class="table-responsive tableFixHead">
			<table class="table table-bordered">
				<thead class=" text-primary text-center">
					<tr class="text-center">
						<th>Kuartal | Tahun</th>
						<th>Posisi Yang Dievaluasi</th>
						<th>Jumlah Personil</th>
						<th>Belum Dievaluasi</th>
						<th>Proses</th>
						<th>Selesai Dievaluasi</th>
						<th>Permintaan Edit</th>
						<th>Permintaan Ditolak</th>
					</tr>
				</thead>
				<tbody>
					@foreach($job_titles->whereIn('level', ['Korkot', 'Askot Mandiri']) as $job_title)
					
					@foreach($settings->where('jobTitleId', $job_title->id)->where('year', $settings->max('year'))->where('quarter', $settings->where('year', $settings->max('year'))->max('quarter') ) as $setting)
					
					<tr>
						<td>Kuartal {{ $setting->quarter }} Tahun {{ $setting->year }}</td>
						<td>{{ $setting->job_title }}</td>
						<td></td>
						<td class="text-center"><a href="/personnel-evaluation-home/{{$setting->id}}/belum-dievaluasi">{{ $notUser->where('job_title_id', $setting->jobTitleId)->whereNotIn('id', $isUser->where('settingId', $setting->id)->pluck('id'))->count() }}</a></td>
						<td class="text-center"><a href="/personnel-evaluation-home/{{$setting->id}}/dalam-proses-evaluasi">{{ $isUser->where('settingId', $setting->id)->where('ready', 0)->count() }}</a></td>
						<td class="text-center"><a href="/personnel-evaluation-home/{{$setting->id}}/sudah-dievaluasi">{{ $isUser->where('settingId', $setting->id)->where('ready', 1)->count() }}</a></td>
						<td></td>
						<td></td>
					</tr>
					@endforeach
					@endforeach
				</tbody>
			</table>
		</div>
		
		<div class="table-responsive tableFixHead">
			<table class="table table-bordered">
				<thead class=" text-primary text-center">
					<tr class="text-center">
						<th>Kuartal | Tahun</th>
						<th>Posisi Yang Dievaluasi</th>
						<th>Jumlah Personil</th>
						<th>Belum Dievaluasi</th>
						<th>Proses</th>
						<th>Selesai Dievaluasi</th>
						<th>Permintaan Edit</th>
						<th>Permintaan Ditolak</th>
					</tr>
				</thead>
				<tbody>	
					@foreach($districts as $district)
					<tr style="background-color:#caeef9;">
						<td colspan="8">{{ ucwords($district->NAMA_KAB)}}</td>
					</tr>	
					@foreach($job_titles->whereIn('level', ['Tim Faskel']) as $job_title)
					<tr>
						<td>Kuartal {{ $settings[0]->quarter }} Tahun {{ $settings[0]->year }}</td>
						<td>{{ $job_title->job_title }}</td>
					</tr>					
					@foreach($settings->where('jobTitleId', $job_title->id)->where('year', $settings->max('year'))->where('quarter', $settings->where('year', $settings->max('year'))->max('quarter') ) as $setting)
					
					@endforeach
					@endforeach
					@endforeach
				</tbody>
			</table>
		</div>
    </div>
 </div>



@endsection
