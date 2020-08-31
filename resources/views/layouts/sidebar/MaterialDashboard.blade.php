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
          <li class="nav-item ">
            <a class="nav-link" href ="{{'/pass-by-user/' . Auth::user()->id . '/edit' }} ">
              <i class="material-icons">content</i>
              <p>Ganti Password</p>
            </a>
          </li>
          @can('input-data')
          <li class="nav-item active  ">
            <a class="nav-link" href="/kpp">
              <i class="material-icons">dashboard</i>
              <p>KPP</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
              <i class="material-icons">content</i>
              <p>Tambah Data</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
              <i class="material-icons">content</i>
              <p>Edit Data</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href = "/rekap-data-kpp">
              <i class="material-icons">content</i>
              <p>Rekap</p>
            </a>
          </li>
          @endcan
          </ul>
