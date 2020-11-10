@extends('layouts.MaterialDashboard')

@section('content')

<div class="dashboard-icon-container">
	@can('manage-users')
	<div class="dashboard-card">
		<a class="nav-link" href="{{ route('admin.users.index') }}">
			<div class="card-icon">
				<i class="material-icons">supervisor_account</i>
				<p>Manajemen User</p>
			</div>
		</a>
	</div>
	@endcan
	<div class="dashboard-card">
		<a class="nav-link" href="/profil">
		<div class="card-icon">
			<i class="material-icons">account_circle</i>
			<p>Profile</p>
		</div>
		</a>
	</div>
	<div class="dashboard-card">
		<a href="/kpp">
			<div class="card-icon">
				<i class="material-icons">engineering</i>
				<p>KPP</p>
			</div>
		</a>
	</div>
	@if (Auth::user()->hasAnyRoles(['admin', 'fasilitator']))
	<div class="dashboard-card">
		<a href="/blog/post">
		<div class="card-icon">
			<i class="material-icons">book_online</i>
			<p>Blog</p>
		</div>
		</a>
	</div>
	@endif
	@if (Auth::user()->hasAnyRoles(['admin', 'osp']))
	<div class="dashboard-card">
		<a href="#">
			<div class="card-icon">
				<i class="material-icons">chrome_reader_mode</i>
				<p>Library</p>
			</div>
		</a>
	</div>
	@endif
	<div class="dashboard-card">
		<a href="/activities">
			<div class="card-icon">
				<i class="material-icons">groups</i>
				<p>Pelatihan / Rakor / KBIK</p>
			</div>
		</a>
	</div>
	<div class="dashboard-card">
		<a href="/personnel-evaluation">
			<div class="card-icon">
				<i class="material-icons">groups</i>
				<p>Evkinja</p>
			</div>
		</a>
	</div>
</div>
            


@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
