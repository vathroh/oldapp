@extends('layouts.MaterialDashboard')

@section('content')
    @php
    $file = $kppdata[0]['scan_struktur_organisasi']; 
    @endphp<div class="card">

    <div class="card-header card-header-primary">
        <h4 class="card-title ">KPP {{ $kppdata[0]['nama_kpp'] }}</h4>
        <p class="card-category"> Struktur Organisasi </p>
    </div>

    <div class="card-body">

        <embed src="{{ asset('storage/kpp/'.$file) }}"  type="application/pdf" width="100%" height="300%">
    </div>
</div>
 @endsection
