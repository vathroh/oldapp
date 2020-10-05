<ul class="nav">
	<li class="nav-item active  ">
		<a class="nav-link" href="{{ route('dashboard') }}">
			<i class="material-icons">dashboard</i>
			<p>DASHBOARD</p>
		</a>
	</li>
	@can('manage-users')
	<li class="nav-item active  ">
		<a class="nav-link" href="{{ route('admin.users.index') }}">
			<i class="material-icons">supervisor_account</i>
			<p>MANAJEMEN USER</p>
		</a>
	</li>
	@endcan    
    <li class="nav-item active  ">
        <a class="nav-link" href="/profil">
            <i class="material-icons">person</i>
            <p>PROFIL</p>
        </a>
    </li>
    <li class="nav-item ">
        <a class="nav-link" href ="{{'/pass-by-user/' . Auth::user()->id . '/edit' }} ">
            <i class="material-icons">line_style</i>
            <p>Ganti Password</p>
        </a>
    </li>
    <li class="nav-item active dropdown">
		<a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="material-icons">engineering</i>
			<p>KPP</p>
		</a>
	</li>
	<li>				
		<a class="dropdown-item" href="/kpp">
			<i class="material-icons">library_books</i>
			<p>Data KPP</p>
		</a>
    </li>

    @if (Auth::user()->hasAnyRoles(['admin', 'fasilitator']))
	<li>
		<a class="nav-link" href = "/kpp-find">
			<i class="material-icons">library_add</i>
			<p>Tambah Data</p>
		</a>
	</li>
	<li>
		<a class="nav-link" href = "/kpp-find">
			<i class="material-icons">rule</i>
			<p>Edit Data</p>
		</a>
	</li>
    @endif
	
	<li>
		<a class="nav-link" href = "/rekap-data-kpp">
			<i class="material-icons">pending_actions</i>
			<p>Rekap</p>
		</a>
    </li>
    <li class="nav-item active dropdown">
		<a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="material-icons">engineering</i>
			<p>BLOG</p>
		</a>
	</li>
	
	@if (Auth::user()->hasAnyRoles(['admin', 'fasilitator']))
	<li>				
		<a class="dropdown-item" href="/blog/post">
			<i class="material-icons">list</i>
			<p>ARTIKEL BLOG</p>
		</a>
    </li>
    @endif
    
    @if (Auth::user()->hasAnyRoles(['admin', 'osp']))
    <li>				
		<a class="dropdown-item" href="/blog/category">
			<i class="material-icons">library_books</i>
			<p>KATEGORI</p>
		</a>
	</li>
    @endif
    
    @if (Auth::user()->hasAnyRoles(['admin', 'osp']))
    <li class="nav-item active dropdown">
		<a class="nav-link" href="#">
			<i class="material-icons">engineering</i>
			<p>LIBRARY</p>
		</a>
	</li>
	<li>				
		<a class="dropdown-item" href="/library-category">
			<i class="material-icons">library_books</i>
			<p>KATEGORI</p>
		</a>
    </li>
 	<li>				
		<a class="dropdown-item" href="/pustaka">
			<i class="material-icons">library_books</i>
			<p>BERKAS</p>
		</a>
    </li>
    @endif
    
    <li class="nav-item active dropdown">
    	<a class="nav-link" href="/activities">
			<i class="material-icons">engineering</i>
			<p>KEGIATAN</p>
		</a>
	</li>
	@if (Auth::user()->hasAnyRoles(['admin', 'osp']))
	<li class="nav-item dropdown">
		<a class="nav-link" href="/activities-category">
			<i class="material-icons">engineering</i>
			<p>KATEGORI</p>
		</a>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link" href="/activity">
			<i class="material-icons">engineering</i>
			<p>KEGIATAN</p>
		</a>
    </li>
    <li class="nav-item dropdown">
		<a class="nav-link" href="/subjects">
			<i class="material-icons">engineering</i>
			<p>MATERI</p>
		</a>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link" href="/evaluation-questions">
			<i class="material-icons">engineering</i>
			<p>PERTANYAAN</p>
		</a>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link" href="/evaluation-answers">
			<i class="material-icons">engineering</i>
			<p>JAWAB</p>
		</a>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link" href="/activity-blacklist">
			<i class="material-icons">engineering</i>
			<p>BLACKLIST</p>
		</a>
	</li>
	@endif
	<li>				
		<a class="dropdown-item" href="#">
			<i class="material-icons"></i>
			<p></p>
		</a>
    </li>
</ul>
