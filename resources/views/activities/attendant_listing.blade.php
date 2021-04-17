@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>
	</div>
	@include('activities.navbar')
	<div class="card-body">	
		
		<div class="mt-3">	
			<input type="text" id="activity_id" value="{{ $activity_item }}">	
			<div class="form-group row">
				<div class="col-md-12">				 
					<select class="custom-select" id="role" name="role" required>
						<option value="PESERTA">PESERTA</option>
						<option value="PEMANDU">PEMANDU</option>
						<option value="PANITIA">PANITIA</option>
					</select>
				</div>
				
				<div class="form-group row">
					<div class="col-md-6 mt-3">
						<select class="custom-select" id="find_district" name="find_district">
							<option value="">Cari berdasarkan kabupaten penugasan</option>
							@foreach($districts as $district)
							<option value="{{ $district->KD_KAB }}">{{ $district->NAMA_KAB }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 mt-3">
						<input type="text" class="form-control" id="find_name" name="find_name" placeholder="Cari Berdasarkan Nama/Jabatan">
					</div>
				</div>
				
				<div class="col-md-6 mt-3">
					<select class="custom-select" id="users" multiple size="10">
					</select>
					<input type="submit" value="Register" id="register">
				</div>
					
				<div class="col-md-6 mt-3">
					<select class="custom-select" id="registered_users" multiple size="10">
					</select>
					<input type="submit" value="remove" id="remove">
				</div>
			</div>				
			
		</div>
		
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/cb/attendantListing.js') }}" defer></script>
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
