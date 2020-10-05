@extends('layouts.MaterialDashboard')

@section('content')

<div class="activity d-flex mt-5">
	@foreach($activity_categories as $activity_category)
	<div class="activity_item col-md-4">		
		<div class="card">
			<div class="card-header card-header-primary">
				<h5 class="card-title ">{{ $activity_category->name }}</h4>
			</div>
			<div class="card-body" style="body-background: #f2e2c6;">
				<ol>
					<div>
						@if (Auth::user()->hasAnyRoles(['admin', 'training']))
						
							@foreach($activities->where('category_id', $activity_category->id)->unique('activities.id') as $activity)
							<li  class="mt-2">								
								<div><a href="/attendance/{{$activity->category_id}}/{{$activity->id}}">{{ $activity->name }}</a></div>						
							</li>						
							@endforeach
							
						@elseif(Auth::user()->hasAnyRoles(['user']))
						
							@foreach($activities->where('category_id', $activity_category->id)->where('user_id', Auth::user()->id )->unique('activities.id') as $activity)
							<li  class="mt-2">							
								<div><a href="/attendance/{{$activity->category_id}}/{{$activity->id}}">{{ $activity->name }}</a></div>
							</li>						
							@endforeach				
						
						@endif
					</div>
				</ol>
			</div>
		</div>
	</div>
	@endforeach
</div>

@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
