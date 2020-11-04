<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    SERTIFIKAT PELATIHAN
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

  <link rel="stylesheet" href="{{ asset('/MaterialDashboard/css/bootstrap.min.css') }}">
  <script src="{{ asset('MaterialDashboard/js/core/jquery.min.js') }}"></script>

</head>

<body>


			<div class="form-group text-center my-3">
				<h4>Evaluasi Kinerja {{ $setting->pluck('job_title')->first() }}</h4>
				<h4>Kuartal {{ $setting->pluck('quarter')->first() }} Tahun {{ $setting->pluck('year')->first() }}</h4>
			</div>
			
			<div class="personal-information my-2">
				<div class="d-flex">
					<div class="col-md-3"><h6>Nama Personil</h6></div>
					<div><h6>: {{ $user[0]->name }}</h6></div>
				</div>
				<div class="d-flex">
					<div class="col-md-3"><h6>Tim</h6></div>
					<div><h6>: <input type="text"></h6></div>
				</div>
				<div class="d-flex">
					<div class="col-md-3"><h6>Kabupaten/Kota</h6></div>
					<div><h6>: {{ $user[0]->NAMA_KAB }}</h6></div>
				</div>
			</div>
			
			
			
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
								<td class="text-center">{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['capaian'] }}</td>
								
								<td class="text-center">
									{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['evidences'] }}
								</td>
								
								<td class="text-center">
									{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['assesment'] }}
								</td>							
								
								
								<td class="score text-center" id="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}-{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-aspect="{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-criteria="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}" data-value="{{ $value->first()->id }}" 
								
								@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'])) 
									
									data-variabel = "{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] }}"

									@endif
									
								@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['score'])) @endif
									>{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['score'] }}
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

