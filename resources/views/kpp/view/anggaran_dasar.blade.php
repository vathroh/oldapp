@extends('layouts.MaterialDashboard')

@section('head')
    <link rel="stylesheet" href="{{ asset('/css/pdfstyles.css') }}" />
@endsection

@section('content')
@php
    $file = $kppdata[0]['scan_anggaran_dasar']; 
@endphp
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title "><a href = "/kpp/{{ $kppdata[0]['id'] }}">KPP {{ $kppdata[0]['nama_kpp'] }}</a></h4>
        <p class="card-category"> Anggaran Dasar </p>
    </div>
    <div class="card-body">		
		<div id="app">
			<div role="toolbar" id="toolbar">
				<div id="pager">
					<button data-pager="prev">Sebelum</button>
					<button data-pager="next">Sesudah</button>
				</div>
				<div id="page-mode">
					<label>Page Mode <input type="number" value="1" min="1"/></label>
				</div>
			</div>
			<div id="viewport-container"><div role="main" id="viewport"></div></div>
		</div>
    </div>
</div>
@endsection
    
    
    @section('script')
    <script src="https://unpkg.com/pdfjs-dist@2.0.489/build/pdf.min.js"></script>
    <script src="{{ asset('/js/indexpdf.js') }}"></script>
    <script>
      initPDFViewer("{{ asset('/storage/kpp/' . $file) }}");
    </script>
@endsection

