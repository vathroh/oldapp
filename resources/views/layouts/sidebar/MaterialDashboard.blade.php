				<ul class="nav">
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
			@can('edit-users')
			<li>
					<a class="nav-link" data-toggle="modal" data-target="#exampleModal">
						<i class="material-icons">library_add</i>
						<p>Tambah Data</p>
					</a>
			</li>
			<li>
					<a class="nav-link" data-toggle="modal" data-target="#exampleModal">
						<i class="material-icons">rule</i>
						<p>Edit Data</p>
					</a>
			</li>
          @endcan
			<li>
					<a class="nav-link" href = "/rekap-data-kpp">
						<i class="material-icons">pending_actions</i>
						<p>Rekap</p>
					</a>
          </li>
          </ul>
