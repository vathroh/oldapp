<div class="wrapper row0">
	<div id="topbar" class="hoc clear">
		<nav id="mainav" class="fl_left">
			<ul>
				<li><img src="{{ asset('favicon-32x32.png') }}"></li>
				<li><a href="/">Home</a></li>
				<li><a href="/blog-osp1">BLOG</a></li>
				<li><a href="/pustaka-osp1/pengumuman">PENGUMUMAN</a></li>
				<li><a href="/pustaka-osp1/pustaka">PUSTAKA</a></li>
				<li><a href="/gis">GIS</a></li>
			</ul>
		</nav>
		<div class="fl_right">
			<ul>
				<li>
					<a href="/"><i class="fa fa-lg fa-home"></i></a>
				</li>
				@guest
				<li>
					<a href="{{ route('login') }}">{{ __('Login') }}</a>
				</li>
				@if (Route::has('register'))
				<li>
					<a href="{{ route('register') }}">{{ __('Register') }}</a>
				</li>
				@endif
				@else
				<li>
					<a href="/profil">{{ Auth::user()->name }}</a>
				</li>
				<li>
					<a href="/dashboard">DASHBOARD</a>
				</li>
				<li>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
									document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</div>
				</li>
				@endguest
			</ul>
		</div>
	</div>
</div>