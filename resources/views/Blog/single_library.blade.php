@extends('layouts.bickery')

@section('page_title')
<div class = "page-title">Pustaka</div>
@endsection

@section('content')
<section id="content_area">

	<div class="clearfix wrapper main_content_area">			
		<div class="clearfix main_content floatleft">				
			<div class="clearfix content">
				<div class="clearfix single_content">

					<div class="pustaka form-group row">
						<div class="col-md-8 record" style="margin-top: 90px;">
							<div class="subject">{{ $library->subject }}</div>
							<div style="margin-top: 20px;">{{ $library->description }}</div>
							<div style="margin-top: 20px;" class = "download">
								@if(is_null($library->file))
								@else 
								<div class="file"><a href="/download/{{'library'}}/{{ $library->file }}" target="_blank">Download</a> </div>
								@endif
								@if(is_null($library->link))
								@else 
								<div class="link"><a href="{{ $library->link }}" target="_blank">Download</a></div>
								@endif
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
	@include('layouts.sidebar.bickery')
</section>
@endsection

