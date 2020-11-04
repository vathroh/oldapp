@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">Evaluasi Kinerja</h4>
    <p class="card-category">Kriteria</p>
  </div>
  <div class="card-body">
		@include('personnelEvaluation.navbar')

			<div class="form-group text-center my-5">
				<h4>Daftar Aspek Kinerja {{ $jobTitles->where('id', $setting->pluck('jobTitleId')->first())->first()->job_title }}</h4>
				<h4>Kuartal {{ $setting->pluck('quarter')->first() }} Tahun {{ $setting->pluck('year')->first() }}</h4>
			</div>
			
			<div>
				<table class="table-bordered" style="width:100%;">
					<thead>
						<tr style="background-color:#c2f0fc;">
							<th scope="col">No</th>
							<th scope="col">Aspek Kinerja</th>
							@if($setting->pluck('status')[0]==0)
							<th scope="col" style="text-align:center;">
								<!-- Button trigger modal -->
								<button type="button" style="box-shadow:none;" class="btn" data-toggle="modal" data-target="#exampleModal">
									<i class="material-icons" style="font-size:25px;">add_box</i>
								</button>
							</th>
							@endif
						</tr>
					</thead>
					
						@if($criteriIds != "")
						@php $i = 1 @endphp
						@foreach($criteriIds as $criteriId)

						
						<tbody id="criteria" ">
							<tr style="background-color:#eef7aa;">
								<th scope="row">{{ $i }}</th>
								<th>{{ $criterias->where('id',$criteriId[0])->pluck('criteria')->first() }} </th>
								@if($setting->pluck('status')[0]==0)
								<th style="text-align:center; float:right">
									<div class="text-left d-flex">
																				
										<i class="material-icons" name= "{{ $setting->pluck('id')[0] }}" style="font-size:25px;"><a href="/personnel-evaluation-setup/{{ $setting->pluck('id')[0] }}/edit">expand_less</a></i>
										<i class="material-icons" id="{{ $criteriId[0] }}" name="{{ $i-1 }}" style="font-size:25px;"><a data-toggle="modal" data-target="#aspectsModal">add_box</a></i>
										<i class="material-icons" name= "{{ $setting->pluck('id')[0] }}" style="font-size:25px;"><a href="/personnel-evaluation-setup/{{ $setting->pluck('id')[0] }}/edit">remove_circle</a></i>
										<i class="material-icons" name= "{{ $setting->pluck('id')[0] }}" style="font-size:25px;"><a href="/personnel-evaluation-setup/{{ $setting->pluck('id')[0] }}/edit">expand_more</a></i>
										
									</div>						
								</th>
								@endif
							</tr>
							
							@php $y = 1;  $countAspect = count($criteriIds[$i-1]) @endphp
							@for($x=1; $x < $countAspect; $x++)
							
							<tr id="aspects">
								<th scope="row" style="text-align:right;">{{ $y }}</th>
								<td> {{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('aspect')->first() }}</td>
								@if($setting->pluck('status')[0]==0)
								<td style="text-align:center;">
									<i name= "{{ $setting->pluck('id')[0] }}" class="material-icons"><a href="/personnel-evaluation-setup/{{ $setting->pluck('id')[0] }}/edit">expand_less</a></i>
									<i name= "{{ $setting->pluck('id')[0] }}" class="material-icons"><a href="/personnel-evaluation-setup/{{ $setting->pluck('id')[0] }}/edit">remove_circle</a></i>
									<i name= "{{ $setting->pluck('id')[0] }}" class="material-icons"><a href="/personnel-evaluation-setup/{{ $setting->pluck('id')[0] }}/edit">expand_more</a></i>
								</td>
								@endif
							</tr>
							@php $y++ @endphp
							@endfor					
					</tbody>
					@php $i++ @endphp

					@endforeach
					@endif
					
				</table>
			</div>
			
			@if($setting->pluck('status')[0]==0)
			<form method="post" action="/personnel-evaluation-setup-ready/{{ $setting->pluck('id')->first() }}" enctype="multipart/form-data">
			@method('put')
			@csrf
				<div class="text-center mt-5">
					<button type="submit" class="btn btn-primary">Selesai</button>
				</div>
			</form>
			@else			
			<form method="post" action="/personnel-evaluation-setup-not-ready/{{ $setting->pluck('id')->first() }}" enctype="multipart/form-data">
			@method('put')
			@csrf
				<div class="text-center mt-5">
					<button type="submit" class="btn btn-primary">Edit Lembar Evaluasi</button>
				</div>
			</form>
			@endif
			</div>
		</div>
</div>

<!-- Modal Kriteria-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<form method="post" action="/personnel-evaluation-setup/{{ $setting->pluck('id')->first() }}" enctype="multipart/form-data">
				@method('put')
				@csrf
				
			<div class="modal-body">
				
					<div class="form-group row mt-5">
						<div class="col-md-3 text-md-right">
							<p>Kriteria Aspek Yang Dievaluasi</p>
						</div>
						<div class="col-md-9">
							<select id="year" type="criteria" class="form-control" name="criteria" required>
								<option selected>Kriteria Aspek Kinerja...</option>
								@foreach($criterias as $criteria)
								<option value="{{ $criteria->id }}">{{ $criteria->criteria }}</option>
								@endforeach
							</select>
						</div>
					</div>				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				
					<a href="/personnel-evaluation-setup/{{ $setting->pluck('jobTitleId')->first() }}/edit">
					<button type="submit" class="btn btn-primary">
						Simpan
						</button>
					</a>
				
			</div>
			
			</form>
			
		</div>
	</div>
</div>


<!-- Modal Aspek-->
<div class="modal fade" id="aspectsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<form id="form_Aspect" method="post" action="/personnel-evaluation-setup-aspect/{{ $setting->pluck('id')->first() }}" class="{{ $setting->pluck('id')->first() }}" enctype="multipart/form-data">
				@method('put')
				@csrf
				
			<div class="modal-body">
				
				<div class="form-group row mt-5">
					<div class="col-md-3 text-md-right">
						<p>Posisi Yang Dievaluasi</p>
					</div>
					<div class="col-md-9">
						<select id="SettingId" type="text" class="form-control" name="SettingId" required>
							<option value="{{ $setting->pluck('id')->first() }}">{{ $setting->pluck('jobTitleId')->first() }}</option>
						</select>
					</div>
				</div>
					
				<div class="form-group row mt-5">
					<div class="col-md-3 text-md-right">
						<p>Kriteria Ke</p>
					</div>
					<div class="col-md-9">
						<select id="criteriaNumber" type="text" class="form-control" name="criteriaNumber" required>
						</select>
					</div>
				</div>
					
				<div class="form-group row mt-5">
					<div class="col-md-3 text-md-right">
						<p>Kriteria</p>
					</div>
					<div class="col-md-9">
						<select id="criteriaId" type="text" class="form-control" name="criteriaId" required>
						</select>
					</div>
				</div>
					
				<div class="form-group row mt-5">
					<div class="col-md-3 text-md-right">
						<p>Aspek Kinerja</p>
					</div>
					<div class="col-md-9">
						<select id="aspect" type="text" class="form-control" name="aspect" required>

						</select>
					</div>
				</div>		
			</div>


			
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary btn-aspect-modal">Simpan</button>
			</div>
			
			</form>
			
		</div>
	</div>
</div>

<script>

	$("table tbody tr#aspects td i:nth-child(1)").click(function(){
		$(this).closest('tbody').children('tr:first').children('th:first').css('color', 'green');
		var criteriaNumber = $(this).closest('tbody').children('tr:first').children('th:first').text()-1;
		var aspectNumber = $(this).closest('tr').children('th:first').text()-1;	
		var settingId = $(this).attr('name');
		
		$.ajax({			
			type: 'get',
			url: '/personnel-evaluation-setup-aspect-item-move-up',
			data: {
				'settingId'			: settingId,
				'criteriaNumber'	: criteriaNumber,
				'aspectNumber'		: aspectNumber
			},
				
			success: function(data) {				
				console.log(data);			
			}
		});		
	});
	
	$("table tbody tr#aspects td i:nth-child(2)").click(function(){
		$(this).closest('tbody').children('tr:first').children('th:first').css('color', 'green');
		var criteriaNumber = $(this).closest('tbody').children('tr:first').children('th:first').text()-1;
		var aspectNumber = $(this).closest('tr').children('th:first').text();	
		var settingId = $(this).attr('name');
		
		$.ajax({			
			type: 'get',
			url: '/personnel-evaluation-setup-aspect-item-delete',
			data: {
				'settingId'			: settingId,
				'criteriaNumber'	: criteriaNumber,
				'aspectNumber'		: aspectNumber
			},
				
			success: function(data) {
				console.log(data);
			}
		});	
	});
	
	$("table tbody tr#aspects td i:nth-child(3)").click(function(){
		$(this).closest('tbody').children('tr:first').children('th:first').css('color', 'green');
		var criteriaNumber = $(this).closest('tbody').children('tr:first').children('th:first').text()-1;
		var aspectNumber = $(this).closest('tr').children('th:first').text();	
		var settingId = $(this).attr('name');
		
		$.ajax({			
			type: 'get',
			url: '/personnel-evaluation-setup-aspect-item-move-down',
			data: {
				'settingId'			: settingId,
				'criteriaNumber'	: criteriaNumber,
				'aspectNumber'		: aspectNumber
			},
				
			success: function(data) {
				console.log(data);
			}
		});	
	});
		
	$("table tbody tr th div i:nth-child(1)").click(function(){
		$(this).closest('tr').children('th:first').css('color', 'red');
		var criteriaNumber = $(this).closest('tr').children('th:first').text()-1;		
		var settingId = $(this).attr('name');
				
		$.ajax({			
			type: 'get',
			url: '/personnel-evaluation-setup-aspect-move-up',
			data: {
				'settingId'			: settingId,
				'criteriaNumber'	: criteriaNumber
			},
				
			success: function(data) {
				console.log(data);
			}
		});		
	});
	
	$("table tbody tr th div i:nth-child(2)").click(function(){
		var criteriaId = $(this).attr('id');
		var criteriaNumber = $(this).attr('name');
		var settingId = {{ $setting[0]->id }}
		console.log(settingId);
		
		$.get('/search-aspect-id?id=' + criteriaId + '&&setting=' + settingId, function (data) {
		
		console.log(data);
		$("#aspect").empty();
		$("#criteriaId").append('<option value="' + criteriaId + '" selected>' + criteriaId + '</option>');
		$("#criteriaNumber").append('<option value="' + criteriaNumber + '" selected>' + criteriaNumber + '</option>');		
		
		$.each(data, function (index, aspectObj) {
			$("#aspect").append('<option value="' + aspectObj.id + '">' + (index+1) + '. ' + aspectObj.aspect + '</option>');
			});          
		});
	});
	
	$("table tbody tr th div i:nth-child(3)").click(function(){
		$(this).closest('tr').children('th:first').css('color', 'red');
		var criteriaNumber = $(this).closest('tr').children('th:first').text()-1;		
		var settingId = $(this).attr('name');
			
		$.ajax({			
			type: 'get',
			url: '/personnel-evaluation-setup-aspect-delete',
			data: {
				'settingId'			: settingId,
				'criteriaNumber'	: criteriaNumber
			},
				
			success: function(data) {
				console.log(data);
			}
		});
	});
	
	$("table tbody tr th div i:nth-child(4)").click(function(){
		$(this).closest('tr').children('th:first').css('color', 'green');
		var criteriaNumber = $(this).closest('tr').children('th:first').text()-1;		
		var settingId = $(this).attr('name');
		
		$.ajax({			
			type: 'get',
			url: '/personnel-evaluation-setup-aspect-move-down',
			data: {
				'settingId'			: settingId,
				'criteriaNumber'	: criteriaNumber
			},
			
			success: function(data) {
				console.log(data);
			}
		});
	});

	$(".btn-aspect-modal").click(function(){
		$("#aspectsModal").modal('hide');
	});
	
	/*
	$( "form#form_Aspect" ).submit(function(e){		
		e.preventDefault();
		
		$.ajax({			
			type: 'put',
			url: '/personnel-evaluation-setup-aspect',
			data: {
				'_token'		: $('input[name=_token]').val(),
				'criteriaId'	: $('select[name=criteriaId]').val(),
				'SettingId'		: $('select[name=SettingId]').val(),
				'criteriaNumber': $('select[name=criteriaNumber]').val(),
				'aspect' 		: $('select[name=aspect]').val()
			},
				
			success: function(data) {
				console.log('data');
			}
		});
		
	});
	*/

</script>

@endsection
