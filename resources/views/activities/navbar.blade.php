
	<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:transparent;">
		<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<div class="navbar-nav">
				@if (Auth::user()->hasAnyRoles(['admin', 'training']))
				<a class="nav-link" href="/listing-attendant/{{ $activity }}/{{ $activity_item }}">Register Peserta</a>
				@endif
				<a class="nav-link" href="/attendance/{{ $activity }}/{{ $activity_item }}">Daftar Hadir</a>
				@if($role == "PESERTA")
				<a class="nav-link" href="/activity/{{ $activity }}/{{ $activity_item }}">Evaluasi Belajar</a>
				@endif
				<a class="nav-link" href="/schedule/{{ $activity }}/{{ $activity_item }}">Jadwal</a>
				<a class="nav-link" href="/lesson/{{ $activity }}/{{ $activity_item }}">Materi</a>
				<a class="nav-link" href="/certificate_page/{{ $activity }}/{{ $activity_item }}">Sertifikat</a>
			</div>
		</div>
	</nav>
	
