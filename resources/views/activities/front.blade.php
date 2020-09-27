@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">PELATIHAN</h4>
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/activities">Kegiatan</a></li>
			<li class="breadcrumb-item active" aria-current="page">Pelatihan</li>
		  </ol>
		</nav>
	</div>
	<div class="card-body">
		
		<div class="mt-3">
			Peserta yang hadir:
			Peserta yang belum hadir:
			
			Peserta yang belum input Evaluasi:

		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
