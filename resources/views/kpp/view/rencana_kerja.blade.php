@extends('layouts.MaterialDashboard')

@section('head')
<script src="{{ asset('pdfobject.min.js') }}"></script>
<style>
.pdfobject-container { height: 40rem; border: 1rem solid rgba(0,0,0,.1); }
</style>
@endsection

@section('content')
    @php
    $file = $kppdata[0]['scan_rencana_kerja']; 
    echo $file;
    @endphp<div class="card">

    <div class="card-header card-header-primary">
        <h4 class="card-title ">KPP {{ $kppdata[0]['nama_kpp'] }}</h4>
        <p class="card-category"> Rencana Kerja </p>
    </div>
    <div class="card-body">
		<div id="example1"></div>
    </div>
</div>
 @endsection

@section('script')
<script>PDFObject.embed("{{ asset('/storage/kpp/' . $file) }}", "#example1");</script>
@endsection
