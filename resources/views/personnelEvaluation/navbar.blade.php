
	<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:transparent;">
		<a class="nav-link" href="/personnel-evaluation">Beranda</a>
		<a class="nav-link" href="/personnel-evaluation-myevaluation">Evaluasi Saya</a>
		@if($evaluators->count() > 0 )

		<a class="nav-link" href="/personnel-evaluation-rekap">Rekap</a>
		<a class="nav-link" href="/personnel-evaluation-edit">Permintaan Edit</a>
		@endif
		@if (Auth::user()->hasAnyRoles(['hrm']))
		<a class="nav-link" href="/personnel-evaluation-monitoring">Monitoring</a>
		<a class="nav-link" href="/personnel-evaluation-rekap">Rekap</a>
		<a class="nav-link" href="/personnel-evaluation-setup/">Setup</a>	
		<a class="nav-link" href="/personnel-evaluator/">Tim Penilai</a>
		<a class="nav-link" href="/personnel-evaluation-criteria/">Kriteria</a>
		<a class="nav-link" href="/personnel-evaluation-aspect/">Aspek</a>
		@endif
	</nav>
	
