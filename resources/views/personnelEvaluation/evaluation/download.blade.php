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

	<style>
		#evaluatorSign {
			display: flex;
			flex-wrap: wrap;
			text-align: center;
			text-transform: uppercase;
			justify-content: center;
		}

		#personnelEvaluator {
			margin-top: 20px;
			width: 33%;
		}

		.evaluatorTitle {
			text-transform: uppercase;
			font-size: 18px;
			margin: 30px 0 0px 0;
			text-align: center;
			font-weight: bold;
		}

		@media print {
			.btn-print {
				display: none;
			}
		}
	</style>

	<!-- CSS Files -->
	<link href="{{ asset('MaterialDashboard/css/material-dashboard.css?v=2.1.2') }}" rel="stylesheet" />
	<link rel="stylesheet" href="{{ asset('/MaterialDashboard/css/bootstrap.min.css') }}">
	<script src="{{ asset('MaterialDashboard/js/core/jquery.min.js') }}"></script>

</head>


<body class="">
	<button class="btn-print" onClick="window.print()">Print</button>
	<div class="form-group text-center">
		<h4>Evaluasi Kinerja {{ $setting->pluck('job_title')->first() }}</h4>
		<h4>Kuartal {{ $setting->pluck('quarter')->first() }} Tahun {{ $setting->pluck('year')->first() }}</h4>
	</div>

	<table style="width:100%;">
		<tbody>
			<tr>
				<td style="width:20%">Nama Personil</td>
				<td>: {{ $user[0]->name }}</td>
			</tr>
			<tr>
				<td style="width:20%">Tim</td>
				<td>: {{ $value[0]->team }} </td>
			</tr>
			<tr>
				<td style="width:20%">Kabupaten/Kota</h6>
				</td>
				<td>: {{ $user[0]->NAMA_KAB }}</td>
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
				<!--	<th class="text-center" scope="col">No. Bukti</th> -->
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
				<th colspan="5">{{ $criterias->where('id',$criteriId[0])->pluck('criteria')->first() }}</th>
			</tr>

			@php $y = 1; $countAspect = count($criteriIds[$i-1]) @endphp
			@for($x=1; $x < $countAspect; $x++) <tr>
				<td class="text-right" style="vertical-align:top;">{{ $y }} </td>
				<td>{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('aspect')->first() }} </td>
				<td class="text-center" id="checkbox" data-id="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}-{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-aspect="{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-criteria="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}" data-value="{{ $value[0]->id }}" @if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel']))

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
					@else 0
					@endif
				</td>
				{{--
								<td class="text-center">
									@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['evidences']))
				
											{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['evidences'] }}

				@endif
				</td>
				--}}
				<td class="text-center">
					@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['assesment']))

					{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['assesment'] }}
					@else 0
					@endif
				</td>
				<td class="score text-center" id="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}-{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-aspect="{{ $aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first() }}" data-criteria="{{ $criterias->where('id',$criteriId[0])->pluck('id')->first() }}" data-value="{{ $value->first()->id }}" @if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel']))

					data-variabel = "{{ $content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['variabel'] }}"

					@endif >

					@if(isset($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['score_by_evaluator']))

					{{ number_format($content[$criterias->where('id',$criteriId[0])->pluck('id')->first()][$aspects->where('id', $criteriIds[$i-1][$x] )->pluck('id')->first()]['score_by_evaluator'], 2) }} @else 0 @endif
				</td>

				</tr>

				@php $y++ @endphp
				@endfor

				<tr>
					<th class="text-center" colspan="2">Jumlah</th>
					<th class="text-center" id="sumVariabel{{$criterias->where('id',$criteriId[0])->pluck('id')->first()}}"></th>
					<th colspan="2"></th>
					<th data-proportion="{{ $criterias->where('id',$criteriId[0])->pluck('proportion')->first() }}" class="text-center" id="sumScores{{$criterias->where('id',$criteriId[0])->pluck('id')->first()}}">

					</th>
				</tr>

				@php $i++ @endphp
				@endforeach
				@endif
				<tr>
					<th class="text-center" colspan="2">T O T A L</th>
					<th colspan="3"></th>
					<th class="text-center" id="totalScores"></th>
				</tr>
		</tbody>
	</table>



	</form>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>




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
				<textarea class="form-control" id="issue" data-value="{{ $value[0]->id }}" rows="4">{{ $value[0]->issue }}</textarea>
			</div>
		</div>
	</div>
	@endif
	<div class="mt-3" style="width:100%; border: 1px solid grey; border-radius: 5px; padding: 30px;">
		<div style="width: 600px; margin:auto;">
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



	@if( $value->first()->user->posisi->level == "Korkot" || $value->first()->user->posisi->level == "Askot Mandiri" )


	<div class="evaluatorTitle">
		TIM PENILAI
	</div>


	<div id="evaluatorSign">
		@foreach($thisPersonnelEvaluatorsKorkot->whereNotIn('evaluator', [14]) as $thisPersonnelEvaluator)


		<div id="personnelEvaluator">
			<div>
				{{ $thisPersonnelEvaluator->evaluatorsUser->name }}
			</div>
			<br><br><br>
			<div>
				{{ $thisPersonnelEvaluator->evaluatorsUser->posisi->job_title }}
			</div>
		</div>
		@endforeach
	</div>

	<div class="evaluatorTitle">
		MENGETAHUI DAN MENYETUJUI
	</div>
	<div id="evaluatorSign">
		@foreach($thisPersonnelEvaluatorsKorkot->whereIn('evaluator', [14]) as $thisPersonnelEvaluator)

		<div id="personnelEvaluator">
			<div>
				{{ $thisPersonnelEvaluator->evaluatorsUser->name }}
			</div>
			<br><br><br>
			<div>
				{{ $thisPersonnelEvaluator->evaluatorsUser->posisi->job_title }}
			</div>
		</div>
		@endforeach
	</div>

	@else



	<div class="evaluatorTitle">
		TIM PENILAI
	</div>


	<div id="evaluatorSign">
		@foreach($thisPersonnelEvaluators->whereNotIn('job_title_id', [1,2]) as $thisPersonnelEvaluator)


		<div id="personnelEvaluator">
			<div>
				{{ $thisPersonnelEvaluator->posisi->job_title }}
			</div>
			<br><br><br>
			<div>
				{{ $thisPersonnelEvaluator->user->name }}
			</div>
		</div>
		@endforeach
	</div>

	<div class="evaluatorTitle">
		MENGETAHUI DAN MENYETUJUI
	</div>
	<div id="evaluatorSign">
		@foreach($thisPersonnelEvaluators->whereIn('job_title_id', [1,2])->where('district', App\User::find($user[0]->id)->areaKerja()->first()->district ) as $thisPersonnelEvaluator)

		<div id="personnelEvaluator">
			<div>
				{{ $thisPersonnelEvaluator->posisi->job_title }}
			</div>
			<br><br><br>
			<div>
				{{ $thisPersonnelEvaluator->user->name }}
			</div>
		</div>
		@endforeach
	</div>
	@endif



	<style type="text/css">
		h1 {
			page-break-before: always
		}
	</style>
	<script>
		$(document).ready(function() {
			var ready = $("div#ready").data('ready');
			if (ready == 1) {
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
			for (i = 1; i < 4; i++) {
				var sumScores = 0;

				$("td[data-variabel='1'][data-criteria=" + i + "].score").each(function() {
					var assesmentValue = $(this).text();
					if ($.isNumeric(assesmentValue)) {
						sumScores += parseFloat(assesmentValue);
					}
				});

				console.log(sumScores);

				var variabel = $("td[data-variabel='1'][ data-criteria='" + i + "']#checkbox").length;
				var proportion = $("#sumScores" + i).data('proportion');

				$("#sumVariabel" + i).text(variabel);
				$("#sumScores" + i).text(sumScores.toFixed(2));

				if (variabel > 0) {
					var allScores = parseFloat(sumScores * proportion / variabel);
				} else {
					var allScores = 0;
				}

				totalScores += parseFloat(allScores);
			}
			var totalVariabel = $("td[data-variabel='1']#checkbox").length;
			$("#totalVariabel").text(totalVariabel);
			$("#totalScores").text(totalScores.toFixed(2) + '%');

		});

		$("textarea#recommendation").keyup(function() {
			var recommendation = $(this).val();
			var issue = $("textarea#issue").val();
			var value = $(this).data('value');
			var team = $("input#team").val();

			$.ajax({
				type: 'get',
				url: '/personnel-evaluation/create',
				data: {
					'recommendation': recommendation,
					'value': value,
					'issue': issue,
					'team': team
				},


				success: function(data) {
					console.log(data);
				}
			});

		});

		$("textarea#issue").keyup(function() {
			var recommendation = $("textarea#recommendation").val();
			var value = $(this).data('value');
			var team = $("input#team").val();
			var issue = $(this).val();

			$.ajax({
				type: 'get',
				url: '/personnel-evaluation/create',
				data: {
					'recommendation': recommendation,
					'value': value,
					'issue': issue,
					'team': team
				},

				success: function(data) {
					console.log(data);
				}
			});

		});

		$("input#team").keyup(function() {
			var recommendation = $("textarea#recommendation").val();
			var issue = $("textarea#issue").val();
			var value = $(this).data('value');
			var team = $(this).val();

			$.ajax({
				type: 'get',
				url: '/personnel-evaluation/create',
				data: {
					'recommendation': recommendation,
					'value': value,
					'issue': issue,
					'team': team
				},

				success: function(data) {
					console.log(data);
				}
			});
		});

		$("input#checkbox").click(function() {
			var id = $(this).data('id');
			var criteria = $(this).data('criteria');
			var aspect = $(this).data('aspect');
			var value = $(this).data('value');
			var recommendation = $("textarea#recommendation").val();
			var issue = $("textarea#issue").val();
			var team = $("input#team").val();

			console.log(value);

			if ($(this).prop('checked')) {
				var variabel = 1;
				$("input[id=" + id + "].assesment").prop('disabled', false);
				//$("select[id=" + id + "].capaian").prop('disabled', false);        
				$("select[id=" + id + "]").css('background-color', 'white');
				$("input[id=" + id + "].assesment").css('background-color', 'white');
				$("input[id=" + id + "].assesment").css('color', 'black');
				$("input[id=" + id + "].score").attr('data-variabel', '1');

			} else {
				var variabel = 0;
				$("input[id=" + id + "].assesment").prop('disabled', true);
				$("select[id=" + id + "].assesment").prop('disabled', true);
				$("input[id=" + id + "].assesment").css('background-color', 'grey');
				$("select[id=" + id + "].assesment").css('background-color', 'grey');
				$("input[id=" + id + "].score").attr('data-variabel', '0');
				$("input[id=" + id + "].assesment").css('color', 'grey');

			}

			$.ajax({
				type: 'get',
				url: '/personnel-evaluation/create',
				data: {

					'criteria': criteria,
					'aspect': aspect,
					'value': value,
					'recommendation': recommendation,
					'issue': issue,
					'team': team,
					'variabel': variabel
				},

				success: function(data) {
					console.log(data);
				}
			});

			var totalScores = 0;
			for (i = 1; i < 4; i++) {
				var sumScores = 0;
				$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function() {
					var assesmentValue = $(this).val();
					if ($.isNumeric(assesmentValue)) {
						sumScores += parseFloat(assesmentValue);
					}
				});


				var variabel = $("input[data-criteria='" + i + "']#checkbox:checked").length;
				var proportion = $("#sumScores" + i).data('proportion');

				$("#sumVariabel" + i).text(variabel);
				$("#sumScores" + i).text(sumScores.toFixed(2));

				if (variabel > 0) {
					var allScores = parseFloat(sumScores * proportion / variabel);
				} else {
					var allScores = 0;
				}
				totalScores += parseFloat(allScores);
			}

			if (parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75) {
				var kinerja = "Tercapai";
			} else if (parseFloat(totalScores) >= 75) {
				var kinerja = "Sangat Baik";
			} else {
				var kinerja = "Tidak Tercapai";
			}

			$("h6#finalResult").text(kinerja);


			var totalVariabel = $("input#checkbox:checked").length;
			$("#totalVariabel").text(totalVariabel);
			$("#totalScores").text(totalScores.toFixed(2) + '%');
		});

		$("input[type=text].capaian").keyup(function() {
			var criteria = $(this).data('criteria');
			var aspect = $(this).data('aspect');
			var value = $(this).data('value');
			var capaian = $(this).val();
			var recommendation = $("textarea#recommendation").val();
			var issue = $("textarea#issue").val();
			var team = $("input#team").val();

			$.ajax({
				type: 'get',
				url: '/personnel-evaluation/create',
				data: {
					'recommendation': recommendation,
					'issue': issue,
					'team': team,
					'criteria': criteria,
					'aspect': aspect,
					'value': value,
					'capaian': capaian
				},

				success: function(data) {
					console.log(data);
				}
			});
		});

		$("input[type=text].evidences").keyup(function() {
			var criteria = $(this).data('criteria');
			var aspect = $(this).data('aspect');
			var value = $(this).data('value');
			var evidences = $(this).val();
			var recommendation = $("textarea#recommendation").val();
			var issue = $("textarea#issue").val();
			var team = $("input#team").val();

			$.ajax({
				type: 'get',
				url: '/personnel-evaluation/create',
				data: {
					'recommendation': recommendation,
					'issue': issue,
					'team': team,
					'criteria': criteria,
					'aspect': aspect,
					'value': value,
					'evidences': evidences
				},

				success: function(data) {
					console.log(data);
				}
			});
		});

		$("input[type=text].assesment").keyup(function() {
			var recommendation = $("textarea#recommendation").val();
			var issue = $("textarea#issue").val();
			var criteria = $(this).data('criteria');
			var aspect = $(this).data('aspect');
			var value = $(this).data('value');
			var team = $("input#team").val();
			var assesment = $(this).val();

			var id = "#" + criteria + '-' + aspect;
			$(id + ".score").val(assesment / 100);
			var score = assesment / 100;

			var totalScores = 0;
			for (i = 1; i < 4; i++) {
				var sumScores = 0;
				$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function() {
					var assesmentValue = $(this).val();
					if ($.isNumeric(assesmentValue)) {
						sumScores += parseFloat(assesmentValue);
					}
				});

				var variabel = $("input[data-criteria='" + i + "']#checkbox:checked").length;
				var proportion = $("#sumScores" + i).data('proportion');
				$("#sumScores" + i).text(sumScores.toFixed(2));
				$("#sumVariabel" + i).text(variabel);

				if (variabel > 0) {
					var allScores = parseFloat(sumScores * proportion / variabel);
				} else {
					var allScores = 0;
				}
				totalScores += parseFloat(allScores);
			}

			$("#totalScores").text(totalScores.toFixed(2) + '%');

			if (parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75) {
				var kinerja = "Tercapai";
			} else if (parseFloat(totalScores) >= 75) {
				var kinerja = "Sangat Baik";
			} else {
				var kinerja = "Tidak Tercapai";
			}

			$("h6#finalResult").text(kinerja);

			$.ajax({
				type: 'get',
				url: '/personnel-evaluation/create',
				data: {
					'recommendation': recommendation,
					'issue': issue,
					'team': team,
					'totalScore': totalScores,
					'kinerja': kinerja,
					'criteria': criteria,
					'aspect': aspect,
					'value': value,
					'score_by_evaluator': score,
					'assesment': assesment
				},

				success: function(data) {
					console.log(data);
				}
			});


		});

		$("select.assesment").change(function() {
			var recommendation = $("textarea#recommendation").val();
			var issue = $("textarea#issue").val();
			var criteria = $(this).data('criteria');
			var aspect = $(this).data('aspect');
			var value = $(this).data('value');
			var team = $("input#team").val();
			var assesment = $(this).val();

			var id = "#" + criteria + '-' + aspect;
			$(id + ".score").val(assesment);
			var score = assesment;

			console.log(score);

			var totalScores = 0;
			for (i = 1; i < 4; i++) {
				var sumScores = 0;
				$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function() {
					var assesmentValue = $(this).val();
					if ($.isNumeric(assesmentValue)) {
						sumScores += parseFloat(assesmentValue);
					}
				});

				var variabel = $("input[data-criteria='" + i + "']#checkbox:checked").length;
				var proportion = $("#sumScores" + i).data('proportion');
				$("#sumScores" + i).text(sumScores.toFixed(2));
				$("#sumVariabel" + i).text(variabel);

				if (variabel > 0) {
					var allScores = parseFloat(sumScores * proportion / variabel);
				} else {
					var allScores = 0;
				}
				totalScores += parseFloat(allScores);
			}

			$("#totalScores").text(totalScores.toFixed(2) + '%');

			if (parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75) {
				var kinerja = "Tercapai";
			} else if (parseFloat(totalScores) >= 75) {
				var kinerja = "Sangat Baik";
			} else {
				var kinerja = "Tidak Tercapai";
			}

			$("h6#finalResult").text(kinerja);

			$.ajax({
				type: 'get',
				url: '/personnel-evaluation/create',
				data: {
					'recommendation': recommendation,
					'issue': issue,
					'team': team,
					'totalScore': totalScores,
					'kinerja': kinerja,
					'criteria': criteria,
					'aspect': aspect,
					'value': value,
					'score_by_evaluator': score,
					'assesment': assesment
				},

				success: function(data) {
					console.log(data);
				}
			});


		});

		function input() {
			$.ajax({
				type: 'get',
				url: '/personnel-evaluation/create',
				data: {
					'criteria': criteria,
					'aspect': aspect,
					'value': value,
					'recommendation': recommendation,
					'issue': issue,
					'team': team,
					'variabel': variabel
				},

				success: function(data) {
					console.log(data);
				}
			});
		}

		function ready() {
			var totalScores = 0;
			for (i = 1; i < 4; i++) {
				var sumScores = 0;

				$("input[data-variabel='1'][data-criteria=" + i + "].score").each(function() {
					var assesmentValue = $(this).val();
					if ($.isNumeric(assesmentValue)) {
						sumScores += parseFloat(assesmentValue);
					}
				});

				var variabel = $("input[data-variabel='1'][ data-criteria='" + i + "']#checkbox").length;
				var proportion = $("#sumScores" + i).data('proportion');

				$("#sumVariabel" + i).text(variabel);
				$("#sumScores" + i).text(sumScores.toFixed(2));

				if (variabel > 0) {
					var allScores = parseFloat(sumScores * proportion / variabel);
				} else {
					var allScores = 0;
				}

				totalScores += parseFloat(allScores);
			}
			var totalVariabel = $("input[data-variabel='1']#checkbox").length;
			$("#totalVariabel").text(totalVariabel);
			$("#totalScores").text(totalScores.toFixed(2) + '%');
		}
	</script>


	<script>
		var form = $('.form'),
			cache_width = form.width(),
			a4 = [595.28, 990.89]; // for a4 size paper width and height

		var canvasImage,
			winHeight = a4[1],
			formHeight = form.height(),
			formWidth = form.width();

		var imagePieces = [];

		// on create pdf button click
		$('#create_pdf').on('click', function() {
			$('body').scrollTop(0);
			imagePieces = [];
			imagePieces.length = 0;
			main();
		});

		// main code
		function main() {
			getCanvas().then(function(canvas) {
				canvasImage = new Image();
				canvasImage.src = canvas.toDataURL('image/png');
				canvasImage.onload = splitImage;
			});
		}

		// create canvas object
		function getCanvas() {
			form.width(a4[0] * 1.33333 - 80).css('max-width', 'none');
			return html2canvas(form, {
				imageTimeout: 2000,
				removeContainer: true,
			});
		}

		// chop image horizontally
		function splitImage(e) {
			var totalImgs = Math.round(formHeight / winHeight);
			for (var i = 0; i < totalImgs; i++) {
				var canvas = document.createElement('canvas'),
					ctx = canvas.getContext('2d');
				canvas.width = formWidth;
				canvas.height = winHeight;
				//                    source region                   dest. region
				ctx.drawImage(
					canvasImage,
					0,
					i * winHeight,
					formWidth,
					winHeight,
					0,
					0,
					canvas.width,
					canvas.height,
				);

				imagePieces.push(canvas.toDataURL('image/png'));
			}
			console.log(imagePieces.length);
			createPDF();
		}

		// crete pdf using chopped images
		function createPDF() {
			var totalPieces = imagePieces.length - 1;
			var doc = new jsPDF({
				unit: 'px',
				format: 'a4',
			});
			imagePieces.forEach(function(img) {
				doc.addImage(img, 'JPEG', 20, 40);
				if (totalPieces) doc.addPage();
				totalPieces--;
			});
			doc.save('techumber-html-to-pdf.pdf');
			form.width(cache_width);
		}
	</script>

</body>

</html>