@extends('layouts.ProfilMaterialDashboard')

@section('head')
<link href="{{ asset('css/kpp/style.css') }}" rel="stylesheet">
@endsection

@section('sidebar')
<ul class="nav">
	@can('manage-users')
    <li class="nav-item active  ">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
		<i class="material-icons">dashboard</i>
		<p>MANAJEMEN USER</p>
        </a>
    </li>
    @endcan
	<li class="nav-item active  ">
		<a class="nav-link" href="/kpp">
		<i class="material-icons">dashboard</i>
		<p>PROFIL</p>
		</a>
	</li>
	<li class="nav-item ">
		<a class="nav-link">
		<i class="material-icons">content</i>
		<p>DATA PEKERJAAN</p>
		</a>
	</li>
	<li class="nav-item ">
		<a class="nav-link">
		<i class="material-icons">content</i>
		<p>GANTI PASSWORD</p>
		</a>
	</li>
</ul>
@endsection

@section('content')
<form method = "post" action ="/profil">
	@csrf
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">PEKERJAAN</h4>
		<p class="card-category">Informasi Jabatan dan Wilayah Kerja </p>
	</div>
	<div class="card-body">
		<div class="form-group">
            <label for="job_title">
				POSISI / JABATAN
            </label>
            <select name="job_title" id="job_title" class="form-control input-lg dynamic">
				@foreach($job_titles as $job_title)
				<option value="{{ $job_title->id}}">{{ $job_title->job_title}} </option>
				@endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="district">
				KABUPATEN / KOTA
            </label>
            <select name="district" id="district" class="form-control input-lg dynamic">
				@foreach($districts as $district)
				<option value="{{ $district->district }}">{{ $district->district }} {{ $district->NAMA_KAB }}</option>
				@endforeach
            </select>
        </div>
	</div>
</div>
<div class = "button text-center">
	<button class = "btn btn-primary">Simpan</button>
</div>
</form>
@endsection
