@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category">Kriteria</p>
	</div>
	<div class="card-body">
	@include('personnelEvaluation.navbar')

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
				<option value="2020">2020</option>
				<option value="2021">2021</option>
				<option value="2021">2022</option>
			</select>
		</div>	
	</div>

	<table class="table table-striped table-bordered mt-3">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Kwartal | Tahun </th>
				<th scope="col">Posisi Yang Dievaluasi</th>
				<th scope="col">Aksi</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th colspan="4" style="background-color:#eafc99">BELUM DIBUAT</th>
			</tr>
			<tbody id="belumDibuat"></tbody>
			<tr>
				<th colspan="4" style="background-color:#eafc99">BELUM SIAP</th>
			</tr>
			<tbody id="belumSiap"></tbody>
			<tr>
				<th colspan="4" style="background-color:#eafc99">SIAP</th>
			</tr>
			<tbody id="siap"></tbody>
		</tbody>
	</table>
</div>

<script src="{{ asset('js/personnelEvaluation/jobTitles.js') }}"></script>
@endsection
