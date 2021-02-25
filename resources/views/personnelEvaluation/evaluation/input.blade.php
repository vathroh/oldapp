@extends('layouts.MaterialDashboard')

@section('head')
<style>
	.personnel-evaluation-wrapper {
		border: 1px solid grey;
		border-radius: 10px;
		padding: 40px;
	}
</style>
@endsection

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category">Kriteria</p>
	</div>
	<div class="card-body">

		<div class="personnel-evaluation-wrapper">
			<div class="row text-center mb-5">
				<div class="col">
					<h3>Evaluasi Kinerja {{ $value[0]->evaluationSetting ->jobTitle->job_title ?? '' }} </h3>
					<h3>Tri Wulan {{ $value[0]->evaluationSetting->quarter?? '' }} Tahun {{ $value[0]->evaluationSetting->year?? '' }}</h3>
				</div>
			</div>

			<div class="row">
				<div class="col md-5 text-right">
					<h5>Nama :</h5>
				</div>
				<div class="col">
					<h5>{{ $job_desc[0]->user->name }}</h5>
				</div>
			</div>

			<div class="row">
				<div class="col md-5 text-right">
					<h5>Jabatan :</h5>
				</div>
				<div class="col">
					<h5>{{ $job_desc[0]->posisi->job_title ?? '' }}</h5>
				</div>
			</div>

			<div class="row">
				<div class="col md-5 text-right">
					<h5>Kabupaten/Kota :</h5>
				</div>
				<div class="col">
					<h5>@isset($job_desc[0]->kabupaten[0]->NAMA_KAB){{ $job_desc[0]->kabupaten[0]->NAMA_KAB }} @endif</h5>
				</div>
			</div>

		</div>

		<div class="row text-center mt-5">
			<div class="col">
				<a href="/personnel-evaluation/being-assessed/achievement/{{ $value[0]->id }}"><button type="button" class="btn btn-primary">Lanjut</button></a>
			</div>
		</div>

	</div>
</div>

@endsection