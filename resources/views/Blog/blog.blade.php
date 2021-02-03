@extends('layouts.bickery')

@section('page_title')
<div class="page-title">Blog</div>
@endsection

@section('content')

<section id="content_area">
	<div class="clearfix wrapper main_content_area">
		<div class="clearfix main_content floatleft">
			<div class="clearfix content">
				<div class="content_title">
					<h2>Posting Terbaru</h2>
				</div>
				@foreach($posts as $post)
				<div class="clearfix single_content">
					<div class="clearfix post_date floatleft">
						<div class="date">
							<h3>{{ $post->tanggal_update  }}</h3>
							<p>{{ $post->bulan_update }}</p>
							<p>{{ $post->tahun_update }}</p>
						</div>
					</div>
					<div class="clearfix post_detail">
						<h2><a href="/blog-osp1/{{ $post->slug }}">{{ $post->title }}</a></h2>
						<div class="clearfix post-meta">
							<p><span>Ditulis oleh {{ $post->name }} </span> <span>{{ $post->job_title }}</span> <span>{{ Str::title($post->nama_kab) }}</span></p>
						</div>
						<div class="clearfix post_excerpt">
							<img src="{{ asset('/storage/blog/' . $post->image1) }}" alt="" />
							<p> {!! $post->exerpt !!} >>> </p>
						</div>
						<a href="/blog-osp1/{{ $post->slug }}">Lanjut baca</a>
					</div>
				</div>
				@endforeach
			</div>
			<div class="pagination">
				<nav>
					<ul>
						<li> {{ $posts->links() }} </li>
					</ul>
				</nav>
			</div>
		</div>
		@include('layouts.sidebar.bickery')
	</div>

</section>
@endsection