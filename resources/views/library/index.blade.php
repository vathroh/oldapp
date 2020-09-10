@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">PUSTAKA</h4>
	</div>
	<div class="card-body">
		<div class="mt-5">
			<div class="pustaka form-group row">
				<a class="tambah-pustaka" href= "/pustaka/create">
					<i class="material-icons">library_add</i>
					<p>Tambah Pustaka</p>
				</a>
			</div>
			@foreach($libraries as $library)
			<form method="post" action="/pustaka/{{$library->id }}"enctype="multipart/form-data">
			@method('delete')
			@csrf
				<div class="pustaka form-group row">
					<div class="col-md-8 record">
						<div class="subject">{{ $library->subject }}</div>
						<div>{{ $library->description }}</div>
						<div class = "download">
							@if(is_null($library->file))
							@else 
							<div class="file"><a href="/download/{{'library'}}/{{ $library->file }}" target="_blank">Download</a> </div>
							@endif
							@if(is_null($library->link))
							@else 
							<div class="link"><a href="{{ $library->link }}" target="_blank">Download</a></div>
							@endif
						</div>
						<a href="/pustaka/{{$library->id}}/edit"><button type="button" class="btn btn-primary"> Edit</button></a>
						<button @onclick type="submit" class="btn btn-danger"> Delete</button>
					</div>
				</div>
			</form>
			@endforeach
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
