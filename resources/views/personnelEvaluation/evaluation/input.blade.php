@extends('layouts.MaterialDashboard')

@section('head')
	<style>
		.personnel-evaluation-wrapper{
			border: 1px solid grey;
			border-radius : 10px;
			padding : 40px;
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
		@include('personnelEvaluation.navbar')
		
		<div class ="personnel-evaluation-wrapper">
			<div class="row text-center mb-5">
				<div class="col">
					<h3>Evaluasi Kinerja {{ $user[0]->job_title }}</h3>
				</div>
			</div>
			
			<div class="row">
				<div class="col md-5 text-right">
					<h5>Nama :</h5>
				</div>
				<div class="col">
					<h5>{{ $user[0]->name }}</h5>
				</div>
			</div>
			
			<div class="row">
				<div class="col md-5 text-right">
					<h5>Jabatan :</h5>
				</div>
				<div class="col">
					<h5>{{ $user[0]->job_title }}</h5>
				</div>
			</div>
			
			<div class="row">
				<div class="col md-5 text-right">
					<h5>Kabupaten/Kota :</h5>
				</div>
				<div class="col">
					<h5>{{ $user[0]->NAMA_KAB }}</h5>
				</div>
			</div>
			
		</div>
		
		<div class="row text-center mt-5">
			<div class="col">
				<a href="/personnel-evaluation-create/{{$settingId}}/{{$userId}}"><button type="button" class="btn btn-primary">Input</button></a>
			</div>
		</div>
    
	</div>
</div>



@endsection
