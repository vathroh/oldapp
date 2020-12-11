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




    <input type="button" id="create_pdf" value="download PDF">  
	<form class="form" >  
	<div >
		<div style="text-align: center;">Evaluasi Kinerja {{ $setting->pluck('job_title')->first() }}</div>
		<div style="text-align: center;">Kuartal {{ $setting->pluck('quarter')->first() }} Tahun {{ $setting->pluck('year')->first() }}</div>
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
						<td style="width:20%">Kabupaten/Kota</h6></td>
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


	</form>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>


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

