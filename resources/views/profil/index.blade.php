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
        <a class="nav-link" href="/profil">
            <i class="material-icons">dashboard</i>
            <p>PROFIL</p>
        </a>
    </li>
	<li class="nav-item active  ">
		<a class="nav-link" href="/kpp">
		<i class="material-icons">dashboard</i>
		<p>KPP</p>
		</a>
	</li>
	<li class="nav-item ">
		<a class="nav-link">
		<i class="material-icons">content</i>
		<p></p>
		</a>
	</li>
	<li class="nav-item ">
		<a class="nav-link">
		<i class="material-icons">content</i>
		<p></p>
		</a>
	</li>
</ul>
@endsection

@section('content')

<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">PROFIL</h4>
		<p class="card-category">Informasi User</p>
	</div>
	<div class="card-body">
		<div class="form-group">
			<label for="nik">
                No. E-KTP
			</label>
            <input type="text" id="nik" name="nik" value="{{ Auth::user()->nik }}" readonly>
        </div>
        <div class="form-group">
			<label for="username">
                NAMA
			</label>
            <input type="text" id="username" name="username" value="{{ Auth::user()->name }}" readonly>
        </div>
        <div class="form-group">
			<label for="email">
                E-MAIL
			</label>
            <input type="text" id="email" name="email" value="{{ Auth::user()->email }}" readonly>
        </div>
        <div class="form-group">
			<label for="job_title">
                POSISI / JABATAN
			</label>
            <input type="text" id="job_title" name="job_title" value="{{ $job_desc->job_title }}" readonly>
        </div>
        <div class="form-group">
			<label for="district">
                KABUPATEN / KOTA
			</label>
            <input type="text" id="district" name="district" value="{{ $job_desc->district }} {{ $job_desc->NAMA_KAB }}" readonly>
        </div>
	</div>
</div>
<div class = "button text-center">
	<a href = "/profil/{{Auth::user()->id}}/edit"<button class = "btn btn-primary">Edit</button></a>
</div>
@endsection
