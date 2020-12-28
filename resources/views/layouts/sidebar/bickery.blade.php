<div class=" sidebar_container floatright">
	<div class="clearfix sidebar">
		<div class="clearfix single_sidebar">
			<div class="popular_post" >
				@foreach($categories as $category)
				<div class="sidebar_title"  style="margin: 50px 0 0px 0;">
					<h2>{{ $category->name }}</h2>
				</div>
				<ul>				
					@foreach($libraries->where('category_id', $category->id) as $library)					
					<li><a href="/pustaka-osp1/{{$library->id}}/PUSTAKA">{{ $library->subject }}</a></li>
					@endforeach
				</ul>
				@endforeach
			</div>
		</div>
	</div>
</div>

