@extends('layouts.MaterialDashboard')

@section('content')


<div class="card">
	<div class="card-header">Data Penugasan Pendamping  </div>
		
		<div class="card-body">
			
			
			
			<form action="/admin/user-work-zones/{{ $job_desc->id }}" method="post" enctype="multipart/form-data">
			@csrf
			@method('put')
				
				<input type="text" name="user_id" value="{{ $job_desc->user_id }} ">

				<div class="form-group row">
					<div class="col-md-2 text-md-right">
						<label for="starting_date">Awal Menjabat</label>
					</div>
					<div class="col-md-8">
						<input id="starting_date" type="date" class="form-control" name="starting_date" value="{{ $job_desc->starting_date }}" required autofocus>
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-md-2 text-md-right">
						<label for="finishing_date">Akhir Menjabat</label>
					</div>
					<div class="col-md-8">
						<input id="finishing_date" type="date" class="form-control" name="finishing_date" value="{{ $job_desc->finishing_date }}" required>
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-md-2 text-md-right">
						<label for="email">Tingkat</label>
					</div>
					<div class="col-md-8">
						<select class="form-control" id="select-level" name="level">
						<option value="{{ $job_desc->posisi->zone_level_id }}" >{{ $job_desc->posisi->zone_level->name }}</option>
						@foreach($zone_levels as $level)
						<option value="{{ $level->id }}">{{ $level->name }}</option>
						@endforeach
						</select>
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-md-2 text-md-right">
						<label for="select-job-title">Posisi</label>
					</div>
					<div class="col-md-8">
						<select class="form-control" id="select-job-title" name="job_title">
						<option value="{{$job_desc->job_title_id}}">{{ $job_desc->posisi->job_title }}</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-2 text-md-right">
						<label for="select-district">Kabupaten</label>
					</div>
					<div class="col-md-8">
						<select class="form-control" id="select-district" name="district">
						<option value="{{ $job_desc->areaKerja->district_id }}">{{ $job_desc->areaKerja->kabupaten->NAMA_KAB ??'' }}</option>
						</select>
					</div>
				</div>		

				<div class="form-group row">
					<div class="col-md-2 text-md-right">
						<label for="select-team">Tim</label>
					</div>
					<div class="col-md-8">
						<select class="form-control" id="select-team" name="work_zone">
						<option value="{{ $job_desc->work_zone_id }}">{{ $job_desc->areaKerja->team }}</option>
						</select>
					</div>
				</div>
				
				<div class="text-center">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>

			</form>
			
			
		</div>   

	</div>
</div>


<script>

$("#select-level").click(function() {	
	var level_id = $(this).val();
	var starting_date = $("#starting_date").val();
	var date = new Date(starting_date);
	var month = date.getMonth();
	var year = date.getFullYear();
	$.ajax({
		data: {
			'level_id' : level_id,
			'date' : date,
			'month' : month+1,
			'year' : year
		},
		type: 'get',
		url: '/admin/job-title/areakerja',
		success: function(data) {
			console.log(data)
			$("#select-job-title").empty();
			'<option></option>'
			$.each(data[0], function(index, jobTitleObj) {
				$("#select-job-title").append(
					'<option value="' + jobTitleObj.id + '">' + jobTitleObj.job_title + '</option>'
				);
			});
			
			$("#select-district").empty();
			'<option></option>'
			$.each(data[1], function(index, jobTitleObj) {
				$("#select-district").append(
					'<option value="' + jobTitleObj.id + '">' + jobTitleObj.nama_kab + '</option>'
				);
			});
		}
	});
});

$("#select-district").click(function(){
	var district_id = $(this).val();
	var level_id = $("#select-level").val();
	var starting_date = $("#starting_date").val();
	var date = new Date(starting_date);
	var month = date.getMonth();
	var year = date.getFullYear();

	$.ajax({
		data: {
			'level_id' : level_id,
			'district_id' : district_id,
			'date' : date,
			'month' : month+1,
			'year' : year
		},
		type: 'get',
		url: '/admin/work-zone/areakerja',
		success: function(data) {
			console.log(data);
			$("#select-team").empty();
			'<option></option>'
			$.each(data, function(index, jobTitleObj) {
				$("#select-team").append(
					'<option value="' + jobTitleObj.id + '">' + jobTitleObj.team + '</option>'
				);
			});
		}
	});
});

</script>

@endsection
