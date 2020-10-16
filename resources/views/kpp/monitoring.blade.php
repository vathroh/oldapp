@extends('layouts.MaterialDashboard')



@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">KPP</h4>
    <p class="card-category"> Daftar Kelurahan yang Belum Membentuk KPP</p>
  </div>
  <div class="card-body">
    <div class="table-responsive tableFixHead">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th scope="col">Nomor</th>
					<th scope="col">Kabupaten</th>
					<th scope="col">Kecamatan</th>
					<th scope="col">Kelurahan</th>
					<th scope="col">Tahun BDI/BPM</th>
					<th scope="col">PIC</th>
				</tr>
			</thead>
			<tbody>
				@foreach($noKPPs as $noKPP)
				<tr>					
					<th scope="row">{{ $loop->iteration }}</th>
					<td>{{ $noKPP->NAMA_KAB }}</td>
					<td>{{ $noKPP->NAMA_KEC }}</td>
					<td>{{ $noKPP->NAMA_DESA }}</td>
					<td>@foreach($BDIs->where('KD_KEL', $noKPP->KD_KEL) as $BDI) {{ $BDI->year }},  @endforeach</td>
					<td>@foreach($PICs->whereIn('zone', $noKPP->KD_KAB) as $PIC) {{ $PIC->job_title }}: <span class="namaPersonil">{{ $PIC->name }}</span>, HP: {{ $PIC->HP  }} <br>  @endforeach</td>
				</tr>
				@endforeach
			</tbody>
		</table>

    </div>
  </div>
</div>

<script src="{{ asset('js/kpp/monitoringKPP.js') }}"></script>
@endsection
