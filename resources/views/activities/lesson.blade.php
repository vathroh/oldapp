@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>		
	</div>
	@include('activities.navbar')
	<div class="card-body">
		
		<div class="mt-3">
			
			<table class="table table-bordered">
				<thead>
					<tr  class="table-info">
					  <th scope="col">Materi</th>
					  <th scope="col">Lihat/Download</th>
					</tr>
				</thead>
				<tbody>
					@foreach($subjects as $subject)
					<tr>
						<th>{{ $subject->subject }}</th>
						<td>@if($subject->file != null)<a href = "/lesson-download/{{ $subject->library_id }}" target="_blank"> . download . </a>@endif
							@if($subject->link != null ) <a href = "{{ $subject->link }}" target="_blank"> . download . </a> @endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>			
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
