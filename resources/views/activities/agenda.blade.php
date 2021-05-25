@extends('layouts.MaterialDashboard')

@section('content')
<div class="col-md-12">
<div class="col-md-12">
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">KEGIATAN HARI INI</h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          No.
                        </th>
                        <th>
                          Name Kegiatan
                        </th>
                        <th>
                          Tanggal Pelaksanaan
                        </th>
                        <th>
                          Zoom
                        </th>
                      </thead>
		      <tbody>
			@foreach($todayActivities as $activity)
                        <tr>
                          <td>
			    {{ $loop->iteration }}
                          </td>
                          <td>
			    {{ $activity->name }}
                          </td>
                          <td>
			    {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y')}} - {{ \Carbon\Carbon::parse($activity->finish_date)->format('d M Y') }}
                          </td>
                          <td class="text-primary">
                            <a href="{{ $activity->zoom_link  }}">{{ $activity->zoom_link }}</a>
                          </td>
			</tr>
@endforeach
</tbody>
</table>
		</div>
		</div>
	</div>
</div>
<div class="col-md-12 mt-5">
<div class="card mt-3">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">AGENDA YANG AKAN DATANG</h4>
	</div>
	<div class="card-body">

		<div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          No.
                        </th>
                        <th>
                          Name Kegiatan
                        </th>
                        <th>
                          Tanggal Pelaksanaan
                        </th>
                        <th>
                          Zoom
                        </th>
                      </thead>
		      <tbody>
			@foreach($Upcoming as $activity)
                        <tr>
                          <td>
			    {{ $loop->iteration }}
                          </td>
                          <td>
			    {{ $activity->name }}
                          </td>
                          <td>
			    {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y')}} - {{ \Carbon\Carbon::parse($activity->finish_date)->format('d M Y') }}
                          </td>
                          <td class="text-primary">
                            <a href="{{ $activity->zoom_link  }}">{{ $activity->zoom_link  }}</a>
                          </td>
			</tr>
@endforeach
</tbody>
</table>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
