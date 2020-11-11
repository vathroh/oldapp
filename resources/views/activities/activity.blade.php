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
						@foreach($activities->where('category_id', $activity_category->id) as $activity)						
							<li  class="mt-2">								
								<div>
									<a href="/attendance/{{$activity->category_id}}/{{$activity->id}}">
										{{ $activity->name }} Tanggal 
										
										@if(Carbon\Carbon::parse($activity->start_date)->format('d') != 										
										Carbon\Carbon::parse($activity->finish_date)->format('d')  )
										
											{{ Carbon\Carbon::parse($activity->start_date)->format('d') }}
										
										@endif
										
										@if(Carbon\Carbon::parse($activity->start_date)->format('F') != 										
										Carbon\Carbon::parse($activity->finish_date)->format('F')  )
										
											{{ Carbon\Carbon::parse($activity->start_date)->format('F') }}
										
										@endif
										
										@if(Carbon\Carbon::parse($activity->start_date)->format('Y') != 										
										Carbon\Carbon::parse($activity->finish_date)->format('Y')  )
										
											{{ Carbon\Carbon::parse($activity->start_date)->format('Y') }}
										
										@endif
										
										@if($activity->start_date != $activity->finish_date)
										-
										@endif
										
										{{ Carbon\Carbon::parse($activity->finish_date)->format('d') }}
										{{ Carbon\Carbon::parse($activity->finish_date)->format('F') }}
										{{ Carbon\Carbon::parse($activity->finish_date)->format('Y') }}
									</a>
								</div>						
							</li>						
						@endforeach
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
