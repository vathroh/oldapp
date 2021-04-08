@extends('layouts.MaterialDashboard')

@section('content')


<div class="card">
	<div class="card-header">Data Penugasan Pendamping {{ $user->name }} </div>
		
		<div class="card-body">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Masa Kerja</th>
						<th scope="col">Posisi</th>
						<th scope="col">Kabupaten/Kota</th>						
						<th scope='col'>Tim</th>
						<th scope="col">Wilayah Penugasan</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $dt)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>	
						<td>{{ $dt['awal_kontrak'] }} - {{ $dt['akhir_kontrak'] }}</td>
						<td>{{ $dt['posisi'] }}</td>
						<td>{{ $dt['kabupaten'] }}</td>						
						<td>{{ $dt['tim'] }}</td>
						<td> 
							@foreach($dt['wilayah_tugas'] as $wilayah)
								{{ $wilayah }},
							@endforeach
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>   
		           {{ collect($data) }}  
	</div>
</div>


    @endsection
