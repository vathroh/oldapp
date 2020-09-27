@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>		
	</div>
	@include('activities.navbar')
	<div class="card-body">			
		<form method="post" action="/certificate">
			@csrf
			@if($role =="PESERTA" and $jml_hadir >= 2)
				<button type="submit" class="btn btn-primary">Download Sertifikat</button>
			@endif
		</form>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
