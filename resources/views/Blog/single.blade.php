@extends('layouts.bickery')

@section('page_title')
<div class = "page-title">Blog</div>
@endsection

@section('content')
<section id="content_area">
	<div class="clearfix wrapper main_content_area">			
		<div class="clearfix main_content floatleft">				
			<div class="clearfix content">
				<div class="clearfix single_content">
					<div class="clearfix post_detail">
						<h2 style="color:black;">{{ $post->pluck('title')[0]?? }}</a></h2>
					<div class="clearfix post-meta">
						<p><span>Diposting oleh {{ $post->pluck('name')[0]??'' }} </span> <span>{{ $post->pluck('job_title')[0]??'' }}</span> <span>{{ Str::title($post->pluck('nama_kab')[0]??'') }}</span></p>
					</div>
					<div class ="image1">
						<img src="{{ asset('/storage/blog/' . $post->pluck('image1')[0]??'') }}" alt=""/>
					</div>
					<div class="clearfix post_excerpt">
						<p> {!! $post->pluck('body')[0] !!} </p>
					</div>
					<div class ="image-bottom">
						<img src="{{ asset('/storage/blog/' . $post->pluck('image2')[0]??'') }}" alt=""/>
						<img src="{{ asset('/storage/blog/' . $post->pluck('image3')[0]??'') }}" alt=""/>
						<img src="{{ asset('/storage/blog/' . $post->pluck('image4')[0]??'') }}" alt=""/>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('layouts.sidebar.bickery')
</section>
@endsection

