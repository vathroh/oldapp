<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:transparent;">
	<div class="d-flex">
		@foreach(Auth::User()->ActivityParticipant->where('activity_id', $activity_item) as $role)
		<a href="/kegiatan/{{ strtolower($role->role) }}/absensi/{{ $activity_item }}">
			<button class="btn btn-primary">
				{{ $role->role }}
			</button>
			@endforeach
		</a>
	</div>
	@if (Auth::user()->hasAnyRoles(['admin', 'training']))
	<a class="nav-link" href="/listing-attendant/{{ $activity }}/{{ $activity_item }}">Register Peserta</a>
	<a class="nav-link" href="/kegiatan/panitia/monitoring/peserta/{{ $activity_item }}">Monitoring</a>
	<a class="nav-link" href="/participants/{{ $activity }}/{{ $activity_item }}">Personil</a>
	<a class="nav-link" href="/evaluation-check/{{ $activity }}/{{ $activity_item }}">Ceklist Evaluasi</a>
	<a class="nav-link" href="/evaluation-result/{{ $activity }}/{{ $activity_item }}">Hasil Evaluasi</a>
	@endif

	@if($role =="PESERTA")
	<a class="nav-link" href="/kegiatan/peserta/absensi/{{ $activity_item }}">Daftar Hadir</a>
	@endif
	@if($role =="PEMANDU" OR $role =="PANITIA")
	<a class="nav-link" href="/attendance/{{ $activity }}/{{ $activity_item }}">Daftar Hadir</a>
	@endif

	@if($role == "PESERTA")
	<a class="nav-link" href="/activity/{{ $activity }}/{{ $activity_item }}">Evaluasi Belajar</a>
	@endif
	<a class="nav-link" href="/schedule/{{ $activity }}/{{ $activity_item }}">Jadwal</a>
	<a class="nav-link" href="/lesson/{{ $activity }}/{{ $activity_item }}">Materi</a>
	@if($activity_item == 5)
	@if($role =="PESERTA")
	<a class="nav-link" href="/kegiatan/peserta/sertifikat/{{ $activity_item }}">Sertifikat</a>
	@endif
	@if($role =="PEMANDU" OR $role =="PANITIA")
	<a class="nav-link" href="/certificate_page/{{ $activity }}/{{ $activity_item }}">Sertifikat</a>
	@endif
	@endif
</nav>