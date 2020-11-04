@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category">Kriteria</p>
	</div>
	<div class="card-body">
	@include('personnelEvaluation.navbar')

	<div class="row">		
		<div class="col-md-3">
			<select id="quarter" type="text" class="form-control" name="quarter" required autofocus>
				<option selected>Triwulan ke...</option>
				<option value="I">I</option>
				<option value="II">II</option>
				<option value="III">III</option>
				<option value="IV">IV</option>
				</select>
			</div>
		<div class="col-md-3">
			<select id="year" type="text" class="form-control" name="year" required>
				<option selected>Tahun...</option>
				<option value="2020">2020</option>
				<option value="2021">2021</option>
			</select>
		</div>
		<div class="col-md-6">
			<button type="button" class="btn btn-primary">
				Lanjut
			</button>
		</div>		
	</div>

	<table class="table table-striped table-bordered mt-3">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Kwartal | Tahun </th>
				<th scope="col">Posisi Yang Dievaluasi</th>
				<th scope="col">Aksi</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th colspan="4" style="background-color:#eafc99">BELUM DIBUAT</th>
			</tr>
			<tbody id="belumDibuat1"></tbody>
			<!--
			/*
			@foreach($jobTitles as $jobTitle)
			<tr id="belumDibuat">
				<form method="post" action="{{ route('personnel-evaluation-setup.store') }}" enctype="multipart/form-data">
				@csrf
				<td>{{ $loop->iteration }}</td>
				<td>Kuartal <input type="text" name="quarter" value="{{ $lastSettings[0]->quarter}}" style="border:none;" size="3"> 
					Tahun <input type="text" name="year" value="{{ $lastSettings[0]->year }}" style="border:none;" size="3">
				</td>
				<td>{{ $jobTitle->job_title }}<input type="text" name="jobTitleId" value="{{ $jobTitle->id }}" style="display:none;" size="3"></td>
				<td>
					<button class ="btn btn-warning"><i class="material-icons">rule</i>Buat sekarang</button>
				</td>
				</form>
			</tr>
			@endforeach
			<tr>
				<th colspan="4" style="background-color:#eafc99">BELUM SIAP</th>
			</tr>
			@foreach($lastSettings->where('status', 0) as $lastSetting)
			<tr id="belumSiap">
				<td>{{ $loop->iteration }}</td>
				<td>Kuartal  {{ $lastSetting->quarter }} Tahun {{ $lastSetting->year }}</td>
				<td>{{ $jobTitleAll->where('id', $lastSetting->jobTitleId )->first()->job_title }}</td>
				<td class="text-center">
					<div class="d-flex">
						<a href="/personnel-evaluation-setup/{{ $lastSetting->id }}/edit">
							<button class ="btn btn-success"><i class="material-icons">rule</i>Edit</button>
						</a>
						<form action = "/personnel-evaluation-setup/{{ $lastSetting->id }}" method ="post">
							@csrf
							@method('delete')
							<a onclick="return confirm('Yakin mau menghapus data ini?')">
							<button class ="btn btn-danger"><i class="material-icons">delete</i>Delete</button></a>
						</form>
					</div>
				</td>
			</tr>
			@endforeach
			<tr>
				<th colspan="4" style="background-color:#eafc99">SIAP</th>
			</tr>
			@foreach($lastSettings->where('status', 1) as $lastSetting)
			<tr id="Siap">
				<td>{{ $loop->iteration }}</td>
				<td>Kuartal  {{ $lastSetting->quarter }} Tahun {{ $lastSetting->year }}</td>
				<td>{{ $jobTitleAll->where('id', $lastSetting->jobTitleId )->first()->job_title }}</td>
				<td class="text-center d-flex">
					<a href="/personnel-evaluation-setup/{{ $lastSetting->id }}/edit">
						<button class ="btn btn-primary"><i class="material-icons">rule</i>lihat</button>
					</a>
					<form action = "/personnel-evaluation-setup/{{ $lastSetting->id }}" method ="post">
						@csrf
						@method('delete')
						<a onclick="return confirm('Yakin mau menghapus data ini?')">
						<button class ="btn btn-danger"><i class="material-icons">delete</i>Delete</button></a>
					</form>
				</td>
			</tr>
			@endforeach
			*/
			-->
		</tbody>
	</table>
	
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<form method="post" action="{{ route('personnel-evaluation-setup.store') }}" enctype="multipart/form-data">
			@csrf
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buat Lembar Evaluasi Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row mt-5">
					<div class="col-md-6 text-md-right">
						<label for="personnelEvaluationCriteriaId">Triwulan | Tahun</label>
					</div>
					<div class="col-md-3">
						<select id="quarter" type="text" class="form-control" name="quarter" required autofocus>
							<option selected>Triwulan ke...</option>
							<option value="I">I</option>
							<option value="II">II</option>
							<option value="III">III</option>
							<option value="IV">IV</option>
						</select>
					</div>
					
					<div class="col-md-3">
						<select id="year" type="text" class="form-control" name="year" required>
							<option selected>Tahun...</option>
							<option value="2020">2020</option>
							<option value="2021">2021</option>
						</select>
					</div>				
				</div>	
				
				<div class="form-group row">
					<div class="col-md-6 text-md-right">
						<label for="personnelEvaluationAspect">Posisi Personil Yang Dievaluasi</label>
					</div>
					<div class="col-md-6">
						<select id="jobTitleId" type="text" class="form-control" name="jobTitleId" required>
							<option selected>Posisi...</option>
							@foreach($jobTitles as $jobTitle)
							<option value="{{ $jobTitle->id }}">{{ $jobTitle->job_title }}</option>
							@endforeach
						</select>
					</div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
  </form>
</div>
	
	
	
	
	
</div>

<script src="{{ asset('js/personnelEvaluation/jobTitles.js') }}"></script>
@endsection
