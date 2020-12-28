@extends('layouts.MaterialDashboard')



@section('content')
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">KPP | PERTEMUAN</h4>
    <p class="card-category"> Jumlah Pertemuan Yang Dilaksanakan Oleh KPP</p>
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
					<th scope="col" class="text-center">Jumlah Pertemuan</th>
				</tr>
			</thead>
			<tbody>
				@foreach($meetings->unique('kelurahan_id') as $meeting)
				<tr>
					<th scope="row">{{ $loop->iteration }}</th>
					<td>{{ $meeting->NAMA_KAB }}</td>
					<td>{{ $meeting->NAMA_KEC }}</td>
					<td><a href="/kpp/{{ $kppdatas->where('kode_desa', $meeting->KD_KEL)->pluck('id')->first() }}">{{ $meeting->NAMA_DESA }}</a></td>
					<td class="text-center">{{ $meetings->where('kelurahan_id', $meeting->kelurahan_id)->count() }}</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="4" class="text-center">Jumlah Pertemuan Seluruh KPP di wilayah OSP-1 Jawa Tengah-1</td>
					<td class="text-center">{{ $meetings->count() }}</td>
				</tr>
			</tbody>
		</table>

    </div>
  </div>
</div>

<script src="{{ asset('js/kpp/monitoringKPP.js') }}"></script>
@endsection
