<div class=" sidebar_container floatright">
	<div class="clearfix sidebar">
		<div class="clearfix single_sidebar">
			<div class="popular_post">
				<div class="sidebar_title">
					<h2>PUSTAKA</h2></div>
					<ul>				
						@foreach($libraries as $library)					
						<li><a href="/pustaka-osp1/{{$library->id}}">{{ $library->subject }}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
			<div class="clearfix single_sidebar">
				<div class="sidebar_title">
					<h2>PENGUMUMAN</h2>
					<ul>
						<li><a href=""><span></span></a></li>
						<li><a href=""><span></span></a></li>
						<li><a href=""><span></span></a></li>
						<li><a href=""><span></span></a></li>
						<li><a href=""><span></span></a></li>
					</ul>
				</div>
			</div>
			<div class="clearfix single_sidebar category_items">
				<div class="sidebar_title">
					<h2>PUSTAKA</h2>
					<ul>
						<li class="cat-item"><a href=""></a></li>
						<li class="cat-item"><a href=""></a></li>
						<li class="cat-item"><a href=""></a></li>
						<li class="cat-item"><a href=""></a></li>
						<li class="cat-item"><a href=""></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
