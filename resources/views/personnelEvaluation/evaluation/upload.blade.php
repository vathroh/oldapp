@extends('layouts.MaterialDashboard')



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
					@foreach($criteriIds as $criteriId)
						<tr style="background-color:#c2f0fc;">
							<th>{{ $i }}</th>
							<th colspan="@if($value->userId != Auth::user()->id) 6 @else 5 @endif">{{ $criterias->where('id',$criteriId[0])->pluck('criteria')->first() }}</th>
						</tr>
					
						@php $y = 1;  $countAspect = count($criteriIds[$i-1]) @endphp
						@for($x=1; $x < $countAspect; $x++)
						
							<tr>
								<td class="text-right">{{ $y }} </td>
								<td>{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('aspect')->first() }} </td>
								<td>
									<form method="post" action="personnel-evaluation-upload-file/{{ $value->id }}" enctype="multipart/form-data">
										@csrf
										<button type="submit" class="btn btn-primary" name="upload">upload</button>
										<input type="file" name="file" class="file-input" id="file">
									</form>
									<div class="progress">
										<div class="progress-bar" role="progressbar" aria-valuenow="" aria-valumin="0" aria-valuemax="100" style="width: 0%">
											0%
										</div>
									</div>
									<div id="success">
									</div>
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

<script>
$(document).ready(function(){
	$('form').ajaxForm({
			beforeSend:function(){
				$('#success').empty();
			},
			uploadProgress:function(event, position, total, percentComplete)
			{
				$('.progress-bar').text(percentComplete + '%');
					$('progress-bar').css('width', percentComplete + '%');
			},
			success:function(data)
			{
				if(data.errors)
						{
							$('.progress-bar').text('0%');
							$('.progress-bar').css('width', '0%');
							$('#success').html('<span class="text-danger"><b>' + data.errors + '</b></span>');
						}
				if(data.success)
						{
							$('.progress-bar').text('upload selesai');
							$('.progress-bar').css('width', '100%');
							$('#success').html('<span class="text-danger"><b>' + data.success + '</b></span>');
						}
			}
		
	});
});
</script> 
@endsection
