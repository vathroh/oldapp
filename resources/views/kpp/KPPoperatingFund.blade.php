@extends('layouts.MaterialDashboard')



@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">KPP | BOP</h4>
    <p class="card-category"> Jumlah BOP KPP</p>
  </div>
  <div class="card-body">
    <div class="table-responsive tableFixHead">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th scope="col" class="text-center">Nomor</th>
					<th scope="col" class="text-center">Kabupaten</th>
					<th scope="col" class="text-center">Kecamatan</th>
					<th scope="col" class="text-center">Kelurahan</th>
					<th scope="col" class="text-center">Jumlah BOP</th>
				</tr>
			</thead>
			<tbody>
				@foreach($BOPs->unique('kelurahan_id') as $BOP)
				<tr>					
					<th scope="row">{{ $loop->iteration }}</th>
					<td>{{ $BOP->NAMA_KAB }}</td>
					<td>{{ $BOP->NAMA_KEC }}</td>
					<td><a href="/kpp/{{ $kppdatas->where('kode_desa', $BOP->KD_KEL)->pluck('id')->first() }}">{{ $BOP->NAMA_DESA }}</a></td>
					<td class="text-center">{{ $BOPs->where('kelurahan_id', $BOP->kelurahan_id)->sum('jumlah') }}</td>
				</tr>
				@endforeach
				<tr>
					<th colspan="4" class="text-center">Jumlah BOP Seluruh KPP Wilayah OSP-1 Jawa Tengah-1</th>
					<th class="text-center">{{ $BOPs->sum('jumlah') }}</th>
				</tr>
			</tbody>
		</table>

    </div>
  </div>
</div>

<script src="{{ asset('js/kpp/monitoringKPP.js') }}"></script>
@endsection
