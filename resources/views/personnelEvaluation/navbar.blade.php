<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:transparent;">
	@if (Auth::user()->hasAnyRoles(['hrm']))
	@else
	<a class="nav-link" href="/personnel-evaluation">Beranda</a>
	<a class="nav-link" href="/personnel-evaluation-myevaluation">Evaluasi Saya</a>
	@endif
	

	
	@if(Auth::User()->job_desc )
	@if(Auth::User()->job_desc->evaluator->count() > 0 )
	<a class="nav-link" href="/personnel-evaluation/assessor/rekap">Rekap</a>
	<a class="nav-link" href="/personnel-evaluation-edit">Permintaan Edit</a>
	<a class="nav-link" href="/personnel-evaluation/assessor/cetak">Print</a>
	@endif
	@endif
	
	@if (Auth::user()->hasAnyRoles(['hrm']))
	@if(!isset(Auth::User()->job_desc->evaluator))
	<a class="nav-link" href="/personnel-evaluation-edit">Permintaan Edit</a>
	@endif
	<a class="nav-link" href="/personnel-evaluation/hrm/monitoring">Monitoring</a>
	<a class="nav-link" href="/personnel-evaluation/hrm/rekap">Rekap</a>
	<a class="nav-link" href="/personnel-evaluation-edit">Permintaan Edit</a>
	<a class="nav-link" href="/personnel-evaluator/">Tim Penilai</a>
	<a class="nav-link" href="/personnel-evaluation-setup/">Setup</a>
	<a class="nav-link" href="/personnel-evaluation-criteria/">Kriteria</a>
	<a class="nav-link" href="/personnel-evaluation-aspect/">Aspek</a>
	<a class="nav-link" href="/personnel-evaluation/hrm/cetak">Print</a>
	@endif
</nav>
