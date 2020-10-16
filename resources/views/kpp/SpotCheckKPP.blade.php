@extends('layouts.MaterialDashboard')



@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">KPP</h4>
    <p class="card-category"> Daftar KPP Yang Melakukan Kegiatan Pengecekan Fisik</p>
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
					<th scope="col">Jumlah Kegiatan</th>
				</tr>
			</thead>
			<tbody>
				@foreach($spotChecks->unique('kelurahan_id') as $spotCheck)
				<tr>					
					<th scope="row">{{ $loop->iteration }}</th>
					<td>{{ $spotCheck->NAMA_KAB }}</td>
					<td>{{ $spotCheck->NAMA_KEC }}</td>
					<td><a href="/kpp/{{ $kppdatas->where('kode_desa', $spotCheck->KD_KEL)->pluck('id')->first() }}">{{ $spotCheck->NAMA_DESA }}</a></td>
					<td class="text-center">{{ $spotChecks->where('kelurahan_id', $spotCheck->kelurahan_id)->count() }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

    </div>
  </div>
</div>

<script src="{{ asset('js/kpp/monitoringKPP.js') }}"></script>
@endsection
