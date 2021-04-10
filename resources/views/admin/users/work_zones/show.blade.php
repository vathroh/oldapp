@extends('layouts.MaterialDashboard')

@section('content')


<div class="card">
	<div class="card-header">Data Penugasan Pendamping {{ $user->name }} </div>
		
		<div class="card-body">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
								Tambah Data
							</button>
						</th>
						<th scope="col">Masa Kerja</th>
						<th scope="col">Posisi</th>
						<th scope="col">Kabupaten/Kota</th>						
						<th scope='col'>Tim</th>
						<th scope="col">Wilayah Penugasan</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $dt)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>
						<td>
							<a href="/admin/user-work-zones/{{ $dt['job_desc_id'] }}/edit">
								<button type="button" class="btn btn-primary">Edit</button>
							</a>
							<button type="button" class="btn btn-danger">Delete</button>
						</td>
						<td>{{ $dt['awal_kontrak'] }} - {{ $dt['akhir_kontrak'] }}</td>
						<td>{{ $dt['posisi'] }}</td>
						<td>{{ $dt['kabupaten'] }}</td>						
						<td>{{ $dt['tim'] }}</td>
						<td> 
							@foreach($dt['wilayah_tugas'] as $wilayah)
								{{ $wilayah }},
							@endforeach
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>   

	</div>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
<form action="/admin/user-work-zones" method="post" enctype="multipart/form-data">
	@csrf
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Tambah Riwayat Pendampingan Baru</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			...
			
			
			
			<input type="hidden" name="user_id" value="{{ $user->id }}">

			<div class="form-group row">
				<div class="col-md-2 text-md-right">
					<label for="starting_date">Awal Kontrak</label>
				</div>
				<div class="col-md-8">
					<input id="starting_date" type="date" class="form-control" name="starting_date" value="" required autofocus>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-md-2 text-md-right">
					<label for="finishing_date">Akhir Kontrak</label>
				</div>
				<div class="col-md-8">
					<input id="finishing_date" type="date" class="form-control" name="finishing_date" value="" required>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-md-2 text-md-right">
					<label for="email">Tingkat</label>
				</div>
				<div class="col-md-8">
					<select class="form-control" id="select-level" name="level">
					<option></option>
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
					<option>1</option>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-2 text-md-right">
					<label for="select-district">Kabupaten</label>
				</div>
				<div class="col-md-8">
					<select class="form-control" id="select-district" name="district">
					<option></option>
					</select>
				</div>
			</div>		

			<div class="form-group row">
				<div class="col-md-2 text-md-right">
					<label for="select-team">Tim</label>
				</div>
				<div class="col-md-8">
					<select class="form-control" id="select-team" name="work_zone">
					<option>1</option>
					</select>
				</div>
			</div>
			
			
			...
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Save</button>
		  </div>
		</div>
	  </div>
	</div>
</form>


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


