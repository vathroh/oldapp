@extends('layouts.MaterialDashboard')



@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">KPP</h4>
    <p class="card-category"> Daftar KPP Yang Melakukan Kegiatan Perbaikan Infrastruktur</p>
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
					<th scope="col">Tanggal</th>
					<th scope="col">Lama Perbaikan</th>
					<th scope="col">Jumlah Dana</th>
				</tr>
			</thead>
			<tbody>
				@foreach($maintenances as $maintenance)
				<tr>					
					<th scope="row">{{ $loop->iteration }}</th>
					<td>{{ $maintenance->NAMA_KAB }}</td>
					<td>{{ $maintenance->NAMA_KEC }}</td>
					<td><a href="/kpp/{{ $kppdatas->where('kode_desa', $maintenance->KD_KEL)->pluck('id')->first() }}">{{ $maintenance->NAMA_DESA }}</a></td>
					<td class="text-center">{{ Carbon\Carbon::parse($maintenance->tanggal_mulai)->format('l, d F Y') }}</td>
					<td class="text-center">{{ Carbon\Carbon::parse($maintenance->tanggal_mulai)->diffInDays($maintenance->tanggal_selesai)+1 }} hari</td>
					<td class="text-center">{{ $maintenance->jumlah }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

    </div>
  </div>
</div>

<script src="{{ asset('js/kpp/monitoringKPP.js') }}"></script>
@endsection
