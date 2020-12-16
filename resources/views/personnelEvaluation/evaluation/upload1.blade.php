@extends('layouts.MaterialDashboard')

@section('head')
<style>
#uploadFile{
	border 				: 1px solid grey;
	border-radius : 5px;
	padding 			: 10px;
}

#progress-wrapper {
	padding 			: 20px;
	border 				: 1px solid grey;
	border-radius : 5px;
	margin 				: 20px 0;
}
</style>
@endsection


@section('content')
<div class="card">
	
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category">Bukti</p>
	</div>
	
	<div class="card-body">
		@include('personnelEvaluation.navbar')

			<div id="ready" class="form-group text-center my-3" data-readyByUser="{{ $value->ok_by_user }}" data-ready="{{ $value->ready }}">
				<h4>Bukti Evkinja {{ $lastSetting->pluck('job_title')->first() }}Kuartal {{ $lastSetting->pluck('quarter')->first() }} Tahun {{ $lastSetting->pluck('year')->first() }}</h4>
			</div>

			<div id="uploadFile" class="my-3">
				<form id="formInputFile" method="post" action="/personnel-evaluation-upload/{{ $value->id }}" enctype="multipart/form-data">
				@csrf
					
				  <div class="form-group row">
						<div class="col-md-2 text-md-right">
				    	<label for="nameSelect">Nama</label>
						</div>
						<div class="col-md-10">
				    	<select class="form-control" name="valueId" id="nameSelect">
								<option value="{{ $value->id }}">{{ $value->user()->first()->name }} </option>
				    	</select>
						</div>
				  </div>

				  <div class="form-group row">
						<div class="col-md-2 text-md-right">
				    	<label for="nameSelect">Kriteria</label>
						</div>
						<div class="col-md-10">
				    	<select class="form-control" name="criteriaId" id="criteriaSelect">
								<option>Pilih Kriteria</option>
								@foreach($criterias as $criteria)
									<option value="{{ $criteria->id }}">{{ $criteria->criteria }}</option>
								@endforeach
				    	</select>
						</div>
				  </div>

				  <div class="form-group row">
						<div class="col-md-2 text-md-right">
				    	<label for="nameSelect">Aspek</label>
						</div>
						<div class="col-md-10">
				    	<select class="form-control" name="aspectId" id="aspectSelect">
				    	</select>
						</div>
				  </div>

					<hr class="mb-4">

					<div class="text-center my-3" id="formButton">
							<input type="submit" class="btn btn-primary" value="upload">  			
							<input type="file" name="file" class="file-input" id="file">
					</div>
						
				</form>
			</div>
			
			<div id="progress-wrapper">
			<div class="progress">
				<div class="progress-bar" role="progressbar" aria-valuenow="" aria-valumin="0" aria-valuemax="100" style="width: 0%">
					0%
				</div>
			</div>
			<div id="success" class="text-center">
			</div>
			</div>

			
			<table class=" table table-bordered" style="width:100%;">
				<thead>
					<tr>
						<th class="text-center" scope="col" width="3%">No</th>
						<th class="text-center" scope="col" width="25%">Aspek Kinerja</th>
						<th class="text-center" scope="col">File</th>
					</tr>
				</thead>
				<tbody>
					@if($criteriIds != "")
					@php $i = 1 @endphp
					@foreach($criteriIds as $key=>$criteriId)
						<tr style="background-color:#c2f0fc;">
							<th>{{ $i }}</th>
							<th colspan="@if($value->userId != Auth::user()->id) 6 @else 5 @endif">{{ $criterias->where('id',$criteriId[0])->pluck('criteria')->first() }}</th>
						</tr>
					
						@php $y = 1;  $countAspect = count($criteriIds[$i-1]) @endphp
						@for($x=1; $x < $countAspect; $x++)
						
							<tr>
								<td class="text-right">{{ $y }} </td>
								<td>{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('aspect')->first() }} </td>
								<td class="fileList" id="{{ $criteriIds[$i-1][$x] }}" data-criteria="{{ $key+1 }}">
									@foreach($uploads->where('personnel_evaluation_criteria_id', $i)->where('personnel_evaluation_aspect_id', $criteriIds[$i-1][$x]	) as $upload)	
										<div class="d-flex">	
												<form method="post" action="/personnel-evaluation-upload/{{ $upload->id }}" enctype="multipart/form-data">
													@csrf
													@method('delete')
													<a onclick="return confirm('Hapus File?')" >
														<button class="btn btn-danger">delete</button>
													</a>
													{{ $upload->file_name }} 
													@if(is_null($upload->file_id))
														<a href="/personnel-evaluation-download-file/{{$upload->id}}">
															 download
													@else
														<a href="https://drive.google.com/file/d/{{$upload->file_id}}/view" target="_blank">
															lihat
														</a>
													@endif
												</form>
										</div>
									@endforeach 
								</td>
							</tr>					
						@php $y++ @endphp
						@endfor		
						@php $i++ @endphp
						@endforeach
						@endif
				</tbody>
			</table>	
		</div>
	</div>
	
</div>

<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
$(document).ready(function(){
	
	$('#formButton').hide();

	$('#criteriaSelect').change(function(){
		$('#formButton').show();
		var criteria = $('#criteriaSelect').val();
			$.ajax({
					type 		: 'get',
					url 		: '/ajax-personnel-evaluation-upload',
					data 		: {
						'criteria' : criteria,
						'jobTitleId' 	: {{ $value->user()->first()->posisi()->first()->id }}
					},
					success: function(data){
						console.log(data);
						$('#aspectSelect').empty();
						$.each(data, function (index, aspectObj) {
							$('#aspectSelect').append(
								'<option value=" '+ aspectObj.id +' ">' + aspectObj.aspect +'</option>'
							);
						});
					}
			});
	});

	$('#formInputFile').ajaxForm({

			beforeSend:function(){
				$('#success').empty();
				$('#formInputFile').hide();
			},
			uploadProgress:function(event, position, total, percentComplete)
			{
				$('.progress-bar').text(percentComplete + '%');
				$('.progress-bar').css('width', percentComplete + '%');
			},
			success:function(data)
			{
				if(data[0].errors)
				{
					$('.progress-bar').text('0%');
					$('.progress-bar').css('width', '0%');
					$('#formInputFile').show();
					$('#success').html('<span class="text-danger"><b>' + data[0].errors + '</b></span>');
				}
				if(data[0].success)
				{
					console.log(data[1]);
					$('#file').val("");
					$('#formInputFile').show();
					$('.progress-bar').text('upload selesai');
					$('.progress-bar').css('width', '100%');
					$('#success').html('<span class="text-success"><b>' + data[0].success + '</b></span>');
					$('.fileList').empty();
					$('#criteriaSelect').empty();
					$('#aspectSelect').empty();

					$.each(data[1], function (index, fileObj) {
						$('#' + fileObj.personnel_evaluation_aspect_id +'.fileList').append(
							'<div class="d-flex">'
							+ '<form method="post" action="/personnel-evaluation-upload/' + fileObj.id +'" enctype="multipart/form-data">'
							+'{!! method_field("delete") !!}    {!! csrf_field() !!}'
							+'<a onclick="return confirm(\'Hapus File?\')" >'
							+'<button class="btn btn-danger">delete</button></a>'
							+'</form>'
							+ fileObj.file_name
							+ '@if(is_null(' + fileObj.file_id + '))'
							+'<a href="/personnel-evaluation-download-file/' + fileObj.id +'" >download</a>'
							+ '@else'
							+ '<a href="https://drive.google.com/file/d/' + fileObj.file_id + '/view" target="_blank"> lihat </a>'
							+ '@endif'
							+ '</div>'
						);
					});

					$('#criteriaSelect').append(
						'<option>Pilih Kriteria</option>'
					)
					$.each(data[2], function (index, criteriaObj) {
						$('#criteriaSelect').append(
							'<option value="' + criteriaObj.id + '">' + criteriaObj.criteria + '</option>'

						);
					});
				}
		}
	});
});
</script> 
@endsection
