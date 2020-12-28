@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>
	</div>
	<div class="card-body">
		
		<div class="mt-3">
			Kegiatan yang diikuti:
			<div>
				@foreach($activities as $activity)
				<div>{{ $loop->iteration }}. <a href="/attendance/{{$activity->category_id}}/{{$activity->id}}">{{ $activity->name }}</a></div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
