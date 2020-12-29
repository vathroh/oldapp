@extends('layouts.MaterialDashboard')



@section('content')
<div class="card">
	
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category">Kriteria</p>
	</div>
	
	<div class="card-body">
		@include('personnelEvaluation.navbar')

			<div id="ready" class="form-group text-center my-3" data-readyByUser="{{ $value[0]->ok_by_user }}" data-ready="{{ $value[0]->ready }}">
				<h4>Evaluasi Kinerja {{ $setting->pluck('job_title')->first() }}</h4>
				<h4>Kuartal {{ $setting->pluck('quarter')->first() }} Tahun {{ $setting->pluck('year')->first() }}</h4>
			</div>
			
			<div>
				<div class="row">
					<div class="col-md-3"><h6>Nama Personil</h6></div>
					<div class="col-md-9"><h6>: {{ $user[0]->name }}</h6></div>
					
				</div>
				<div class="row">
					<div class="col-md-3"><h6>Tim</h6></div>
					<div class="col-md-9"><h6>: <input type="text" id="team" data-value="{{ $value[0]->id }}" value="{{ $value[0]->team }}"></h6></div>					
				</div>
				<div class="row">
					<div class="col-md-3"><h6>Kabupaten/Kota</h6></div>
					<div class="col-md-9"><h6>: {{ $user[0]->NAMA_KAB }}</h6></h6></div>					
				</div>
			</div>
			@if($user[0]->id == Auth::user()->id)			
				<a href="/personnel-evaluation-upload/{{ $value[0]->id }}" target="_blank"><button type="submit" class="btn btn-primary">Upload Bukti PEnilaian</button></a>
			@endif
			<table class=" table table-bordered" style="width:100%;">
				<thead>
					<tr>
						<th class="text-center" scope="col">No</th>
						<th class="text-center" scope="col">Aspek Kinerja</th>
						<th class="text-center" scope="col">Variabel Target</th>
						<th class="text-center" scope="col">Tercapai %</th>
						<th class="text-center" scope="col">Bukti</th>
						@if($user[0]->id != Auth::user()->id)
						<th class="text-center" scope="col">Penilaian Ketercapaian (%)</th>
						@endif
						<th class="text-center" scope="col">Skor</th>
					</tr>
				</thead>
				<tbody>
					
					@if($criteriIds != "")
					@php $i = 1 @endphp
					@foreach($criteriIds as $criteriId)
						<tr style="background-color:#c2f0fc;">
							<th>{{ $i }}</th>
							<th colspan="@if($user[0]->id != Auth::user()->id) 6 @else 5 @endif">{{ $criterias->where('id',$criteriId[0])->pluck('criteria')->first() }}</th>
						</tr>
					
						@php $y = 1;  $countAspect = count($criteriIds[$i-1]) @endphp
						@for($x=1; $x < $countAspect; $x++)
						
							<tr>
								<td class="text-right">{{ $y }} </td>
								<td>{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('aspect')->first() }} </td>
								<td class="text-center">
									<input type="checkbox" value="1" id="checkbox" data-id="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}-{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-aspect="{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-criteria="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}"
									
									data-value="{{ $value[0]->id }}" name="checkbox"
										
										@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'])) 
										
										data-variabel="{{$content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] }}" 
									
											@if($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] == 1 ) 
									
												checked 
									
											@endif 
										@endif >
								</td>
								<td class="text-center">
									@if($criterias->where('id',$criteriId[0])->pluck('id')->first() == 1)
									<input class="capaian" type="Text" size="3" id="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}-{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-aspect="{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-criteria="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}" data-value="{{ $value[0]->id }}" data-variabel="$content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel']" 							
							
									@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'])) 							
								
										@if($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] == 0 )
							
											disabled style="background-color:grey;" 
								
										@endif @else disabled style="background-color:grey;" 
							
									@endif
							
									@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['capaian'])) value="{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['capaian'] }}" @endif>
									
									@else
									
									<select class="capaian" type="Text" id="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}-{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-aspect="{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-criteria="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}" data-value="{{ $value[0]->id }}" data-variabel="$content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel']" 							
							
									@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'])) 							
								
										@if($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] == 0 )
							
											disabled style="background-color:grey;" 
								
										@endif @else disabled style="background-color:grey;" 
							
									@endif>
										@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['capaian']))										
										<option value="{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['capaian'] }}"> @if($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['capaian'] == 1) 1 @else 0 @endif </option>
										@endif
										<option value=0>0</option>
										<option value=1>1</option>
									</select>	
									@endif
								</td>

								<td class="text-center">
								@if($user[0]->id != Auth::user()->id)
									@foreach($files->where('personnel_evaluation_criteria_id', $criteriId[0])->where('personnel_evaluation_aspect_id', $criteriIds[$i-1][$x]) as $file)
										@if(is_null($file->google))
										@else
											<a href="https://drive.google.com/file/d/{{$file->google->file_id}}/view" target="_blank">
										@endif
											bukti-{{ $loop->iteration }}
											</a>
									@endforeach 
								@endif
								</td>

								@if($user[0]->id != Auth::user()->id)
								<td class="text-center">
									@if($criterias->where('id',$criteriId[0])->pluck('id')->first() == 1)
										<input class="assesment" type="Text" size="3" id="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}-{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-aspect="{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-criteria="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}" data-value="{{ $value->first()->id }}" 
										@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'])) 							
									
											@if($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] == 0 )
								
												disabled style="background-color:grey;" 
									
											@endif @else disabled style="background-color:grey;" 
								
										@endif
								
										@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['assesment'])) value="{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['assesment'] }}" @endif
										>
									@else
										<select class="assesment" type="Text" id="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}-{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-aspect="{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-criteria="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}" data-value="{{ $value->first()->id }}" 
										@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'])) 							
									
											@if($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] == 0 )
								
												disabled style="background-color:grey;" 
									
											@endif @else disabled style="background-color:grey;" 
								
										@endif									
										>
										@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['assesment'])) 
										<option value="{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['assesment'] }}">
											{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['assesment'] }}
										</option>
										@endif
										<option value=0>0</option>
										<option value=1>1</option>
									@endif
								</td>
								@endif
								<td class="text-center">
									<input class="score" type="Text" size="3" id="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}-{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-aspect="{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-criteria="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}" 
									
									
									@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'])) 
									
									data-variabel = "{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] }}"

									@endif
									
									data-value="{{ $value->first()->id }}" 									
									
									@if($user[0]->id == Auth::user()->id)
									
										@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['score'])) value="{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['score'] }}" @endif
									@else
										@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['score_by_evaluator'])) value="{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['score_by_evaluator'] }}" @endif
									@endif									
									disabled >
								</td>
							</tr>					
						
						@php $y++ @endphp
						@endfor
						
						<tr>
							<th class="text-center" colspan="2">Jumlah</th>
							<th class="text-center" id="sumVariabel{{$criterias->where('id',$criteriId[0])->pluck('id')->first()}}"></th>
							<th colspan="@if($user[0]->id != Auth::user()->id) 3 @else 2 @endif"></th>
							<th data-proportion="{{ $criterias->where('id',$criteriId[0])->pluck('proportion')->first() }}" class="text-center" id="sumScores{{$criterias->where('id',$criteriId[0])->pluck('id')->first()}}">
							</th>
						</tr>				
					
					@php $i++ @endphp
					@endforeach
					@endif
					<tr>
						<th class="text-center" colspan="2">T O T A L</th>
						<td class="text-center" id="totalVariabel"></td>
						<th colspan="@if($user[0]->id != Auth::user()->id) 3 @else 2 @endif" id="finalResult"></th>
						<th class="text-center" id="totalScores"></th>
					</tr>
					<tr>
						<th colspan="2" style="border-color:transparent;"></th>
						<th colspan="@if($user[0]->id != Auth::user()->id) 5 @else 4 @endif" style="border-color:transparent;">							
						</th>
					</tr>
				</tbody>
			</table>
			
			@if($user[0]->id != Auth::user()->id)
			

			<div class="row">
								
				<div class="col-md-6">
					<div>
						REKOMENDASI PERBAIKAN
					</div>
					<div class="form-group">
						<textarea class="form-control" id="recommendation" data-value="{{ $value[0]->id }}" rows="4">{{ $value[0]->recommendation }}</textarea>
					</div>
				</div>
				
				<div class="col-md-6">
					<div>
						MASALAH DAN SARAN
					</div>
					<div class="form-group">
						<textarea class="form-control"  id="issue" data-value="{{ $value[0]->id }}" rows="4">{{ $value[0]->issue }}</textarea>
					</div>
				</div>
			</div>
			@endif		
			<div class="mt-3" style="width:100%; border: 1px solid grey; border-radius: 5px; padding: 30px;">
				<div style="width: 600px; margin:auto;" >
					@if($user[0]->id != Auth::user()->id)
					<div class="row">
						Status Blacklist
					</div>
					<div>
						<div class="check">
							<input class="check-input" type="checkbox" value="Penyalahgunaan Dana Program/LKM/Masyarakat" id="blackllist1">
							<label class="check-label" for="blackllist1">
								Penyalahgunaan Dana Program/LKM/Masyarakat
							</label>
						</div>
						<div class="check">
							<input class="check-input" type="checkbox" value="Penyalahgunaan Dana Program/LKM/Masyarakat" id="blackllist2">
							<label class="check-label" for="blackllist2">
								Manipulasi Data dan atau Data SIM
							</label>
						</div>
					</div>
					@endif
					<div class="row mt-1" style="background-color:#befc9f; padding:10px 0;">
						<div class="col" style="font-weight: bold; font-size:14px;">
							Hasil Akhir/Kualifikasi Kinerja
						</div>
						<div class="col">
							<h6 id="finalResult" class="text-center" style="vertical-align: bottom;">
								@if($user[0]->id == Auth::user()->id)
									{{ $value[0]->userFinalResult }}
								@else
									{{ $value[0]->finalResult }}
								@endif
							</h6>
						</div>
					</div>
				</div>
			</div>
			
			@if($user[0]->id == Auth::user()->id)
			
				@if($value[0]->ok_by_user == 0)
				<div class="text-center mt-3">
						<!-- <a href="/personnel-evaluation-create/{{ $value[0]->evaluationSetting->id }}/{{ $value[0]->user->id }}"> -->
						<button id="check" class="btn btn-primary">Refresh</button>
						<p>Silahkan <span class="font-weight-bold">refresh</span> untuk memeriksa nilai dan <span class="font-weight-bold">Total Nilai</span> yang telah diinput sebelum klik OK, untuk memastikan apa yang anda input sudah tersimpan secara sempurna</p>
					</div>
					<form method="post" action="/personnel-evaluation-value-ready-user/{{ $value[0]->id }}" enctype="multipart/form-data">
						@method('put')
						@csrf
						<div class="text-center mt-5">
							<button type="submit" class="btn btn-primary">SUDAH OK, KIRIM</button>
						</div>
					</form>
				@elseif($value[0]->ok_by_user == 1 && $value[0]->edit_by_user == 0)
					<form method="post" action="/personnel-evaluation-value-not-ready-user/{{ $value[0]->id }}" enctype="multipart/form-data">
						@method('put')
						@csrf
						<div class="text-center mt-5">
							<button type="submit" class="btn btn-primary">AJUKAN PERMOHONAN EDIT</button>
						</div>
					</form>
				@elseif($value[0]->edit_by_user == 1)
					<h6 class="text-center">Permohonan untuk edit telah diajukan</h6>
				@endif

			@else
				@if($value[0]->ready==0)
					<div class="text-center mt-3">
						<!-- <a href="/personnel-evaluation-create/{{ $value[0]->evaluationSetting->id }}/{{ $value[0]->user->id }}"> -->
							<button id="check" class="btn btn-primary">Refresh</button>
						
						<p>Silahkan <span class="font-weight-bold">refresh</span> untuk memeriksa nilai dan <span class="font-weight-bold">Total Nilai</span> yang telah diinput sebelum klik OK, untuk memastikan apa yang anda input sudah tersimpan secara sempurna</p>
					</div>
					<form method="post" action="/personnel-evaluation-value-ready/{{ $value[0]->id }}" enctype="multipart/form-data">
						@method('put')
						@csrf
						<div class="text-center mt-5">
							<button type="submit" class="btn btn-primary">SUDAH OK, KIRIM</button>
						</div>
					</form>
				@elseif($value[0]->ready== 1 && $value[0]->edit == 0)
					<form method="post" action="/personnel-evaluation-value-not-ready/{{ $value[0]->id }}" enctype="multipart/form-data">
						@method('put')
						@csrf
						<div class="text-center mt-5">
							<button type="submit" class="btn btn-primary">AJUKAN PERMINTAAN EDIT</button>
						</div>
					</form>
				@elseif($value[0]->edit == 1)
					<h6 class="text-center">Permohonan untuk edit telah diajukan</h6>
				@endif
				
			@endif

		</div>
	</div>
	
</div>

@if($user[0]->id == Auth::user()->id)
<script>
$(document).ready(function() {
	var ready_by_user = $("div#ready").data('readybyuser');
	if(ready_by_user == 1 ){
		$("input[type=text]").attr('disabled', true)		
		$("input#checkbox").attr('disabled', true)
		$("select").attr('disabled', true)
	}
	
	var totalScores = 0;
	for(i=1; i < 4; i++){			
		var sumScores = 0;
		
		$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function(){
			var assesmentValue = $(this).val();
			if ($.isNumeric(assesmentValue)) {
				sumScores += parseFloat(assesmentValue);				
			}				
		});
		
		var variabel = $("input[data-variabel='1'][ data-criteria='" + i + "']#checkbox").length;
		var proportion = $("#sumScores"+i).data('proportion');			
		
		$("#sumVariabel"+i).text(variabel);
		$("#sumScores"+i).text(sumScores.toFixed(2));
		
		if(variabel > 0){
			var allScores = parseFloat(sumScores * proportion / variabel);
		}else{
			var allScores = 0;
		}
		
		totalScores += parseFloat(allScores);
	}
	var totalVariabel = $("input[data-variabel='1']#checkbox").length;
	$("#totalVariabel").text(totalVariabel);
	$("#totalScores").text(totalScores.toFixed(2) + '%');
	
});

$("input#team").keyup(function(){
	var recommendation		= $("textarea#recommendation").val();	
	var issue				= $("textarea#issue").val();
	var value				= $(this).data('value');
	var team				= $(this).val();
	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation/create',
		data: {
			'recommendation': recommendation,
			'value'			: value,
			'issue'			: issue,
			'team'			: team
		},	
		
		success: function(data) {
			console.log(data);
		}
	});
});

$("input#checkbox").click(function(){	
	var id 				= $(this).data('id');
	var criteria		= $(this).data('criteria');
	var aspect			= $(this).data('aspect');
	var value			= $(this).data('value');
	var team			= $("input#team").val();
	
	console.log(value);
	
	if($(this).prop('checked')) {
		var variabel = 1;
        $("input[id=" + id + "].capaian").prop('disabled', false);
        $("select[id=" + id + "].capaian").prop('disabled', false);
        $("input[id=" + id + "].evidences").prop('disabled', false);        
		$("input[id=" + id + "].capaian").css('background-color', 'white');
		$("select[id=" + id + "].capaian").css('background-color', 'white');
		$("input[id=" + id + "].evidences").css('background-color', 'white');
		$("input[id=" + id + "]").css('color', 'black');
		$("input[id=" + id + "].score").css('color', 'red');		
		$("input[id=" + id + "].score").attr('data-variabel', '1');		
				
    } else {
		var variabel = 0;
        $("input[id=" + id + "].capaian").prop('disabled', true);
        $("select[id=" + id + "].capaian").prop('disabled', true);
        $("input[id=" + id + "].evidences").prop('disabled', true);
		$("input[id=" + id + "].capaian").css('background-color', 'grey');
		$("select[id=" + id + "].capaian").css('background-color', 'grey');
		$("input[id=" + id + "].evidences").css('background-color', 'grey');
		$("input[id=" + id + "]").css('color', 'grey');		
		$("input[id=" + id + "].score").attr('data-variabel', '0');	
    }
    
    
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation-user-create',
		data: {
			
			'criteria' 		: criteria,
			'aspect' 		: aspect,
			'value'			: value,
			'team'			: team,
			'variabel'		: variabel
		},
		
		success: function(data) {
			console.log(data);
		}
	});
	
	var totalScores = 0;
	for(i=1; i < 4; i++){
		var sumScores = 0;
		$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function(){
			var assesmentValue = $(this).val();
			if ($.isNumeric(assesmentValue)) {
				sumScores += parseFloat(assesmentValue);
			}
		});	
	
	
		var variabel 	= $("input[data-criteria='"+ i +"']#checkbox:checked").length;
		var proportion 		= $("#sumScores"+i).data('proportion');
		
		$("#sumVariabel"+i).text(variabel);
		$("#sumScores"+i).text(sumScores.toFixed(2));
		
		if(variabel > 0){
			var allScores =  parseFloat(sumScores * proportion / variabel);
		}else{
			var allScores = 0;
		}
		totalScores += parseFloat(allScores);
	}
	
	if(parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75){
		var kinerja = "Tercapai";
	}else if(parseFloat(totalScores) >= 75){
		var kinerja = "Sangat Baik";
	}else{
		var kinerja = "Tidak Tercapai";
	}	
	
	$("h6#finalResult").text(kinerja);
	
	
	var totalVariabel 	= $("input#checkbox:checked").length;
	$("#totalVariabel").text(totalVariabel);
	$("#totalScores").text(totalScores.toFixed(2) + '%');
});

$("input[type=text].capaian").keyup(function(){
	var criteria		= $(this).data('criteria');	
	var aspect			= $(this).data('aspect');
	var value			= $(this).data('value');	
	var team			= $("input#team").val();
	var capaian			= $(this).val();
	
	var id 				= "#" + criteria + '-' + aspect;
	$(id + ".score").val(capaian/100);
	var score			= capaian/100;
	
	var totalScores = 0;
	for(i=1; i < 4; i++){
		var sumScores = 0;
		$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function(){
			var assesmentValue = $(this).val();
			if ($.isNumeric(assesmentValue)) {
				sumScores += parseFloat(assesmentValue);
			}
		});		
	
		var variabel 	= $("input[data-criteria='"+ i +"']#checkbox:checked").length;
		var proportion 	= $("#sumScores"+i).data('proportion');
		$("#sumScores"+i).text(sumScores.toFixed(2));
		$("#sumVariabel"+i).text(variabel);
		
		if(variabel > 0){
			var allScores =  parseFloat(sumScores * proportion / variabel);
		}else{
			var allScores = 0;
		}
		totalScores += parseFloat(allScores);
	}
	
	$("#totalScores").text(totalScores.toFixed(2) + '%');	
	
	if(parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75){
		var kinerja = "Tercapai";
	}else if(parseFloat(totalScores) >= 75){
		var kinerja = "Sangat Baik";
	}else{
		var kinerja = "Tidak Tercapai";
	}	
	
	$("h6#finalResult").text(kinerja);
	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation-user-create',
		data: {
			'team'			: team,
			'totalScores'	: totalScores,
			'kinerja'		: kinerja,
			'criteria'	 	: criteria,
			'aspect'	 	: aspect,
			'value'			: value,
			'capaian'		: capaian,
			'score'			: score
		},
		
		success: function(data) {
			console.log(data);
		}
	});
	
});

$("select.capaian").change(function(){	
	var criteria		= $(this).data('criteria');	
	var aspect			= $(this).data('aspect');
	var value			= $(this).data('value');	
	var team			= $("input#team").val();
	var capaian			= $(this).val();
	console.log(capaian);
	
	var id 				= "#" + criteria + '-' + aspect;
	$(id + ".score").val(capaian);
	var score			= capaian;
	
	var totalScores = 0;
	for(i=1; i < 4; i++){
		var sumScores = 0;
		$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function(){
			var assesmentValue = $(this).val();
			if ($.isNumeric(assesmentValue)) {
				sumScores += parseFloat(assesmentValue);
			}
		});		
	
		var variabel 	= $("input[data-criteria='"+ i +"']#checkbox:checked").length;
		var proportion 	= $("#sumScores"+i).data('proportion');
		$("#sumScores"+i).text(sumScores.toFixed(2));
		$("#sumVariabel"+i).text(variabel);
		
		if(variabel > 0){
			var allScores =  parseFloat(sumScores * proportion / variabel);
		}else{
			var allScores = 0;
		}
		totalScores += parseFloat(allScores);
	}
	
	$("#totalScores").text(totalScores.toFixed(2) + '%');	
	
	if(parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75){
		var kinerja = "Tercapai";
	}else if(parseFloat(totalScores) >= 75){
		var kinerja = "Sangat Baik";
	}else{
		var kinerja = "Tidak Tercapai";
	}	
	
	$("h6#finalResult").text(kinerja);
	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation-user-create',
		data: {
			'team'				: team,
			'totalScores'	: totalScores,
			'kinerja'			: kinerja,
			'criteria'		: criteria,
			'aspect'	 		: aspect,
			'value'				: value,
			'capaian'			: capaian,
			'score'				: score
		},
		
		success: function(data) {
			console.log(data);
		}
	});
	
});

$("input[type=text].evidences").keyup(function(){
	var criteria	= $(this).data('criteria');
	var aspect		= $(this).data('aspect');
	var value		= $(this).data('value');
	var evidences	= $(this).val();
	var team		= $("input#team").val();
	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation-user-create',
		data: {
			'team'		: team,
			'criteria' 	: criteria,
			'aspect' 	: aspect,
			'value'		: value,
			'evidences'	: evidences
		},
		
		success: function(data) {
			console.log(data);
		}
	});
});

function ready(){
	var totalScores = 0;
	for(i=1; i < 4; i++){			
		var sumScores = 0;
		
		$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function(){
			var assesmentValue = $(this).val();
			if ($.isNumeric(assesmentValue)) {
				sumScores += parseFloat(assesmentValue);				
			}				
		});
		
		var variabel = $("input[data-variabel='1'][ data-criteria='" + i + "']#checkbox").length;
		var proportion = $("#sumScores"+i).data('proportion');			
		
		$("#sumVariabel"+i).text(variabel);
		$("#sumScores"+i).text(sumScores.toFixed(2));
		
		if(variabel > 0){
			var allScores = parseFloat(sumScores * proportion / variabel);
		}else{
			var allScores = 0;
		}
		
		totalScores += parseFloat(allScores);
	}
	var totalVariabel = $("input[data-variabel='1']#checkbox").length;
	$("#totalVariabel").text(totalVariabel);
	$("#totalScores").text(totalScores.toFixed(2) + '%');	
}

$("button#check").click(function(){
	var checkbox = [];
	$("#checkbox").each(function(){
		checkbox[0] = $("#checkbox").val();
	});
	console.log(checkbox);
	var criteria	= $(this).data('criteria');
	var aspect		= $(this).data('aspect');
	var value		= $(this).data('value');
	var evidences	= $(this).val();
	var team		= $("input#team").val();

	$.ajax({			
		type: 'post',
		url: '/personnel-evaluation-check',
		data: {
			'team'		: team,
			'criteria' 	: criteria,
			'aspect' 	: aspect,
			'value'		: value,
			'evidences'	: evidences
		},
		
		success: function(data) {
			console.log(data);
		}
	});
});
</script>

@else

<script>
$(document).ready(function() {
	var ready = $("div#ready").data('ready');
	if(ready == 1 ){
		$("input[type=text]").attr('disabled', true)
		$("select").attr('disabled', true)
		$("input#checkbox").attr('disabled', true)
	} else {
		$("input[type=text].capaian").attr('disabled', true)
		$("input[type=text].evidences").attr('disabled', true)
		$("input[type=text].assesment").attr('disabled', false)
		$("select.capaian").attr('disabled', true)
		$("select.scores").attr('disabled', false)
	}
	
console.log(ready);
	
	var totalScores = 0;
	for(i=1; i < 4; i++){			
		var sumScores = 0;
		
		$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function(){
			var assesmentValue = $(this).val();
			if ($.isNumeric(assesmentValue)) {
				sumScores += parseFloat(assesmentValue);				
			}				
		});
		
		var variabel = $("input[data-variabel='1'][ data-criteria='" + i + "']#checkbox").length;
		var proportion = $("#sumScores"+i).data('proportion');			
		
		$("#sumVariabel"+i).text(variabel);
		$("#sumScores"+i).text(sumScores.toFixed(2));
		
		if(variabel > 0){
			var allScores = parseFloat(sumScores * proportion / variabel);
		}else{
			var allScores = 0;
		}
		
		totalScores += parseFloat(allScores);
	}
	var totalVariabel = $("input[data-variabel='1']#checkbox").length;
	$("#totalVariabel").text(totalVariabel);
	$("#totalScores").text(totalScores.toFixed(2) + '%');
	
});

$("textarea#recommendation").keyup(function(){
	var recommendation		= $(this).val();
	var issue				= $("textarea#issue").val();
	var value				= $(this).data('value');
	var team				= $("input#team").val();
	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation/create',
		data: {
			'recommendation': recommendation,
			'value'			: value,
			'issue'			: issue,
			'team'			: team
		},
	
		
		success: function(data) {
			console.log(data);
		}
	});

});

$("textarea#issue").keyup(function(){
	var recommendation		= $("textarea#recommendation").val();
	var value				= $(this).data('value');
	var team				= $("input#team").val();
	var issue				= $(this).val();
	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation/create',
		data: {
			'recommendation': recommendation,
			'value'			: value,
			'issue'			: issue,
			'team'			: team
		},	
		
		success: function(data) {
			console.log(data);
		}
	});
	
});

$("input#team").keyup(function(){
	var recommendation		= $("textarea#recommendation").val();	
	var issue				= $("textarea#issue").val();
	var value				= $(this).data('value');
	var team				= $(this).val();
	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation/create',
		data: {
			'recommendation': recommendation,
			'value'			: value,
			'issue'			: issue,
			'team'			: team
		},	
		
		success: function(data) {
			console.log(data);
		}
	});
});

$("input#checkbox").click(function(){
	var id 				= $(this).data('id');
	var criteria		= $(this).data('criteria');
	var aspect			= $(this).data('aspect');
	var value			= $(this).data('value');
	var recommendation	= $("textarea#recommendation").val();	
	var issue			= $("textarea#issue").val();
	var team			= $("input#team").val();
	
	console.log(value);
	
	if($(this).prop('checked')) {
		var variabel = 1;
        $("input[id=" + id + "].assesment").prop('disabled', false);
        $("select[id=" + id + "].assesment").prop('disabled', false);        
        $("select[id=" + id + "]").css('background-color', 'white');
		$("input[id=" + id + "].capaian").css('background-color', 'white');
		$("input[id=" + id + "].capaian").css('color', 'black');
		$("input[id=" + id + "].assesment").css('background-color', 'white');
		$("input[id=" + id + "].assesment").css('color', 'black');		
		$("input[id=" + id + "].score").attr('data-variabel', '1');		
				
    } else {
		var variabel = 0;
        $("input[id=" + id + "].assesment").prop('disabled', true);		
		$("select[id=" + id + "].assesment").prop('disabled', true);
		$("input[id=" + id + "].assesment").css('background-color', 'grey');
        $("select[id=" + id + "]").css('background-color', 'grey');
		$("input[id=" + id + "].capaian").css('background-color', 'grey');
		$("input[id=" + id + "].capaian").css('color', 'grey');
        $("input[id=" + id + "].score").attr('data-variabel', '0');	
		$("input[id=" + id + "].assesment").css('color', 'grey');		
		
    }
    	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation/create',
		data: {
			
			'criteria' 		: criteria,
			'aspect' 		: aspect,
			'value'			: value,
			'recommendation': recommendation,
			'issue'			: issue,
			'team'			: team,
			'variabel'		: variabel
		},
		
		success: function(data) {
			console.log(data);
		}
	});
	
	var totalScores = 0;
	for(i=1; i < 4; i++){
		var sumScores = 0;
		$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function(){
			var assesmentValue = $(this).val();
			if ($.isNumeric(assesmentValue)) {
				sumScores += parseFloat(assesmentValue);
			}
		});	
	
	
		var variabel 		= $("input[data-criteria='"+ i +"']#checkbox:checked").length;
		var proportion 		= $("#sumScores"+i).data('proportion');
		
		$("#sumVariabel"+i).text(variabel);
		$("#sumScores"+i).text(sumScores.toFixed(2));
		
		if(variabel > 0){
			var allScores 	=  parseFloat(sumScores * proportion / variabel);
		}else{
			var allScores 	= 0;
		}
		totalScores += parseFloat(allScores);
	}
	
	if(parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75){
		var kinerja = "Tercapai";
	}else if(parseFloat(totalScores) >= 75){
		var kinerja = "Sangat Baik";
	}else{
		var kinerja = "Tidak Tercapai";
	}	
	
	$("h6#finalResult").text(kinerja);
	
	
	var totalVariabel 	= $("input#checkbox:checked").length;
	$("#totalVariabel").text(totalVariabel);
	$("#totalScores").text(totalScores.toFixed(2) + '%');
});

$("input[type=text].capaian").keyup(function(){
	var criteria= $(this).data('criteria');
	var aspect	= $(this).data('aspect');
	var value	= $(this).data('value');
	var capaian	= $(this).val();
	var recommendation	= $("textarea#recommendation").val();	
	var issue			= $("textarea#issue").val();
	var team			= $("input#team").val();
	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation/create',
		data: {
			'recommendation': recommendation,
			'issue'			: issue,
			'team'			: team,
			'criteria' 	: criteria,
			'aspect' 	: aspect,
			'value'		: value,
			'capaian'	: capaian
		},
		
		success: function(data) {
			console.log(data);
		}
	});
});

$("input[type=text].evidences").keyup(function(){
	var criteria	= $(this).data('criteria');
	var aspect		= $(this).data('aspect');
	var value		= $(this).data('value');
	var evidences	= $(this).val();
	var recommendation	= $("textarea#recommendation").val();	
	var issue			= $("textarea#issue").val();
	var team			= $("input#team").val();
	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation/create',
		data: {
			'recommendation': recommendation,
			'issue'			: issue,
			'team'			: team,
			'criteria' 	: criteria,
			'aspect' 	: aspect,
			'value'		: value,
			'evidences'	: evidences
		},
		
		success: function(data) {
			console.log(data);
		}
	});
});

$("input[type=text].assesment").keyup(function(){
	var recommendation	= $("textarea#recommendation").val();	
	var issue			= $("textarea#issue").val();
	var criteria		= $(this).data('criteria');	
	var aspect			= $(this).data('aspect');
	var value			= $(this).data('value');	
	var team			= $("input#team").val();
	var assesment		= $(this).val();
	
	var id 				= "#" + criteria + '-' + aspect;
	$(id + ".score").val(assesment/100);
	var score			= assesment/100;
	
	var totalScores = 0;
	for(i=1; i < 4; i++){
		var sumScores = 0;
		$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function(){
			var assesmentValue = $(this).val();
			if ($.isNumeric(assesmentValue)) {
				sumScores += parseFloat(assesmentValue);
			}
		});		
		
		var variabel 	= $("input[data-criteria='"+ i +"']#checkbox:checked").length;
		var proportion 	= $("#sumScores"+i).data('proportion');
		$("#sumScores"+i).text(sumScores.toFixed(2));
		$("#sumVariabel"+i).text(variabel);
		
		if(variabel > 0){
			var allScores =  parseFloat(sumScores * proportion / variabel);
		}else{
			var allScores = 0;
		}
		totalScores += parseFloat(allScores);
	}
	
	$("#totalScores").text(totalScores.toFixed(2) + '%');	
	
	if(parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75){
		var kinerja = "Tercapai";
	}else if(parseFloat(totalScores) >= 75){
		var kinerja = "Sangat Baik";
	}else{
		var kinerja = "Tidak Tercapai";
	}	
	
	$("h6#finalResult").text(kinerja);
	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation/create',
		data: {
			'recommendation': recommendation,
			'issue'			: issue,
			'team'			: team,
			'totalScore'	: totalScores,
			'kinerja'		: kinerja,
			'criteria'	 	: criteria,
			'aspect'	 	: aspect,
			'value'			: value,
			'score_by_evaluator'			: score,
			'assesment'		: assesment
		},
		
		success: function(data) {
			console.log(data);
		}
	});
});

$("select.assesment").change(function(){	
	var recommendation	= $("textarea#recommendation").val();	
	var issue			= $("textarea#issue").val();
	var criteria		= $(this).data('criteria');	
	var aspect			= $(this).data('aspect');
	var value			= $(this).data('value');	
	var team			= $("input#team").val();
	var assesment		= $(this).val();
	
	var id 				= "#" + criteria + '-' + aspect;
	$(id + ".score").val(assesment);
	var score			= assesment;
	
	console.log(score);
	
	var totalScores = 0;
	for(i=1; i < 4; i++){
		var sumScores = 0;
		$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function(){
			var assesmentValue = $(this).val();
			if ($.isNumeric(assesmentValue)) {
				sumScores += parseFloat(assesmentValue);
			}
		});		
		
		var variabel 	= $("input[data-criteria='"+ i +"']#checkbox:checked").length;
		var proportion 	= $("#sumScores"+i).data('proportion');
		$("#sumScores"+i).text(sumScores.toFixed(2));
		$("#sumVariabel"+i).text(variabel);
		
		if(variabel > 0){
			var allScores =  parseFloat(sumScores * proportion / variabel);
		}else{
			var allScores = 0;
		}
		totalScores += parseFloat(allScores);
	}
	
	$("#totalScores").text(totalScores.toFixed(2) + '%');	
	
	if(parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75){
		var kinerja = "Tercapai";
	}else if(parseFloat(totalScores) >= 75){
		var kinerja = "Sangat Baik";
	}else{
		var kinerja = "Tidak Tercapai";
	}	
	
	$("h6#finalResult").text(kinerja);
	
	$.ajax({			
		type: 'get',
		url: '/personnel-evaluation/create',
		data: {
			'recommendation'	: recommendation,
			'issue'				: issue,
			'team'				: team,
			'totalScore'		: totalScores,
			'kinerja'			: kinerja,
			'criteria'	 		: criteria,
			'aspect'	 		: aspect,
			'value'				: value,
			'score_by_evaluator': score,
			'assesment'			: assesment
		},
		
		success: function(data) {
			console.log(data);
		}
	});
	 
	
});

function input(){
	$.ajax({		
		type: 'get',
		url: '/personnel-evaluation/create',
		data: {			
			'criteria' 		: criteria,
			'aspect' 		: aspect,
			'value'			: value,
			'recommendation': recommendation,
			'issue'			: issue,
			'team'			: team,
			'variabel'		: variabel
		},
		
		success: function(data) {
			console.log(data);
		}
	});
}

function ready(){
	var totalScores = 0;
	for(i=1; i < 4; i++){			
		var sumScores = 0;
		
		$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function(){
			var assesmentValue = $(this).val();
			if ($.isNumeric(assesmentValue)) {
				sumScores += parseFloat(assesmentValue);				
			}				
		});
		
		var variabel = $("input[data-variabel='1'][ data-criteria='" + i + "']#checkbox").length;
		var proportion = $("#sumScores"+i).data('proportion');			
		
		$("#sumVariabel"+i).text(variabel);
		$("#sumScores"+i).text(sumScores.toFixed(2));
		
		if(variabel > 0){
			var allScores = parseFloat(sumScores * proportion / variabel);
		}else{
			var allScores = 0;
		}
		
		totalScores += parseFloat(allScores);
	}
	var totalVariabel = $("input[data-variabel='1']#checkbox").length;
	$("#totalVariabel").text(totalVariabel);
	$("#totalScores").text(totalScores.toFixed(2) + '%');	
}
</script>
@endif
@endsection
