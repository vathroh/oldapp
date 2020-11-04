<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    KOTAKU OSP-1 JATENG-1
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  
  
  
  <!-- CSS Files -->
  <link href="{{ asset('MaterialDashboard/css/material-dashboard.css?v=2.1.2') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('/MaterialDashboard/css/bootstrap.min.css') }}">
  <script src="{{ asset('MaterialDashboard/js/core/jquery.min.js') }}"></script>

</head>

<body class="">	
	
	<div class="form-group text-center">
		<h4>Evaluasi Kinerja {{ $setting->pluck('job_title')->first() }}</h4>
		<h4>Kuartal {{ $setting->pluck('quarter')->first() }} Tahun {{ $setting->pluck('year')->first() }}</h4>
	</div>

	<table style="width:100%;">
				<tbody>
					<tr>
						<td scope="col" style="width:20%"><h6>Nama Personil</h6></td>
						<td><h6>: {{ $user[0]->name }}</h6></td>
					</tr>
					<tr>
						<td style="width:20%"><h6>Tim</h6></td>
						<td><div><h6>: {{ $value[0]->team }} </h6></div></td>
					</tr>
					<tr>
						<td style="width:20%"><h6>Kabupaten/Kota</h6></td>
						<td><h6>: {{ $user[0]->NAMA_KAB }}</h6></td>
					</tr>
				</tbody>
			</table>
			
			
			<table class="table-striped table-bordered" style="width:100%;">
				<thead>
					<tr>
						<th class="text-center" scope="col">No</th>
						<th class="text-center" scope="col">Aspek Kinerja</th>
						<th class="text-center" scope="col">Variabel Target</th>
						<th class="text-center" scope="col">Tercapai %</th>
						<th class="text-center" scope="col">No. Bukti</th>
						<th class="text-center" scope="col">Penilaian Ketercapaian (%)</th>
						<th class="text-center" scope="col">Skor</th>
					</tr>
				</thead>
				<tbody>
					@if($criteriIds != "")
					@php $i = 1 @endphp
					@foreach($criteriIds as $criteriId)
						<tr style="background-color:#c2f0fc;">
							<th>{{ $i }}</th>
							<th colspan="6">{{ $criterias->where('id',$criteriId[0])->pluck('criteria')->first() }}</th>
						</tr>
					
						@php $y = 1;  $countAspect = count($criteriIds[$i-1]) @endphp
						@for($x=1; $x < $countAspect; $x++)
						
							<tr>
								<td class="text-right" style="vertical-align:top;">{{ $y }} </td>
								<td>{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('aspect')->first() }} </td>
								<td class="text-center" id="checkbox" data-id="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}-{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-aspect="{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-criteria="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}" data-value="{{ $value[0]->id }}"
										
									@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'])) 
										
									data-variabel="{{$content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] }}" 
									
											@if($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] == 1 ) 
									
												checked 
									
											@endif 
										@endif >
										
										
										@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'])) 					

									
											@if($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] == 1 ) 
									
												&radic;
									
											@endif 
										@endif									
										
								</td>
								<td class="text-center">
									@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['capaian']))
				
											{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['capaian'] }}
										
									@endif
								</td>
								<td class="text-center">
									@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['evidences']))
				
											{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['evidences'] }}
										
									@endif
								</td>
								<td class="text-center">
									@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['assesment']))
				
											{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['assesment'] }}
										
									@endif
								</td>
								<td class="score text-center" id="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}-{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-aspect="{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-criteria="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}" data-value="{{ $value->first()->id }}" 
								
								@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'])) 
									
									data-variabel = "{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] }}"

									@endif >
									
								@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['score'])) 
									
									{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['score'] }} @endif
								</td>
								
							</tr>					
						
						@php $y++ @endphp
						@endfor
						
						<tr>
							<th class="text-center" colspan="2">Jumlah</th>
							<th class="text-center" id="sumVariabel{{$criterias->where('id',$criteriId[0])->pluck('id')->first()}}"></th>
							<th colspan="3"></th>
							<th data-proportion="{{ $criterias->where('id',$criteriId[0])->pluck('proportion')->first() }}" class="text-center" id="sumScores{{$criterias->where('id',$criteriId[0])->pluck('id')->first()}}">

							</th>
						</tr>				
					
					@php $i++ @endphp
					@endforeach
					@endif
					<tr>
							<th class="text-center" colspan="2">T O T A L</th>
							<th colspan="4"></th>
							<th class="text-center" id="totalScores"></th>
						</tr>
				</tbody>
			</table>			




<script>

$(document).ready(function() {
		var totalScores = 0;
		for(i=1; i < 4; i++){
			
			var sumScores = 0;
			
			$("td.score[data-criteria=" + i + "]").each(function(){
				var assesmentValue = $(this).text();
				if ($.isNumeric(assesmentValue)) {
					sumScores += parseFloat(assesmentValue);				
				}				
			});
			
			var variabel = $("td[data-variabel='1'][ data-criteria='" + i + "']#checkbox").length;
			var proportion = $("#sumScores"+i).data('proportion');			
			
			$("#sumVariabel"+i).text(variabel);
			$("#sumScores"+i).text(sumScores.toFixed(2));
			totalScores += parseFloat(sumScores * proportion / variabel);
		}
		
	$("#totalScores").text(totalScores.toFixed(2) + '%');
	
	
});
    
  </script>

</body>

</html>

