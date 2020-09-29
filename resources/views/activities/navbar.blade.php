
	<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:transparent;">


				@if (Auth::user()->hasAnyRoles(['admin', 'training']))
				<a class="nav-link" href="/listing-attendant/{{ $activity }}/{{ $activity_item }}">Register Peserta</a>
				<a class="nav-link" href="/training-monitoring/{{ $activity }}/{{ $activity_item }}">Monitoring</a>
				<a class="nav-link" href="/participants/{{ $activity }}/{{ $activity_item }}">Personil</a>
				<a class="nav-link" href="/evaluation-check/{{ $activity }}/{{ $activity_item }}">Ceklist Evaluasi</a>
				<a class="nav-link" href="/evaluation-result/{{ $activity }}/{{ $activity_item }}">Hasil Evaluasi</a>
				@endif
				<a class="nav-link" href="/attendance/{{ $activity }}/{{ $activity_item }}">Daftar Hadir</a>
				@if($role == "PESERTA")
				<a class="nav-link" href="/activity/{{ $activity }}/{{ $activity_item }}">Evaluasi Belajar</a>
				@endif
				<a class="nav-link" href="/schedule/{{ $activity }}/{{ $activity_item }}">Jadwal</a>
				<a class="nav-link" href="/lesson/{{ $activity }}/{{ $activity_item }}">Materi</a>

	</nav>
	
