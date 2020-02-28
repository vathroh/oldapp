@extends('layouts.app')

@section('content')

@if(session('status'))
<div class="alert alert-success">
    <h1>
        {{ session('status') }}
    </h1>
</div>
@endif


<div class="card text-center">
    <div class="card-header">
        <div class="row">
            <div class="col text-center">
                <a class="btn btn-primary" href="/doc">. F o t o .</a>
                <a class="btn btn-primary" href="/table">.Dokumen.</a>
                <a class="btn btn-primary" href="/rekap">.R e k a p.</a>
                <br><br>
                <a class="btn btn-primary" href="/create">Upload Dok BKM</a>
                <a class="btn btn-primary" href="/ksm">Upload Dok KSM</a>
                <a class="btn btn-primary" href="/foto">Upload Foto</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-8 md-12">

                @foreach( $documents as $document )
                <div class="card my-3">
                    <img src="https://drive.google.com/uc?export=view&id={{ $document->file_id }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h4>{{ $document->nama_desa }} , {{ $document->nama_kab }}</h4>
                        <p class="card-text">{{ $document->file_name }} telah diupload pada tanggal {{ $document->created_at }}</p>
                        <p class="card-text"><a href="{{ $document->link }}" class="" target="_blank">Klik disini</a> untuk melihat</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>




<!-- 
<div class="row mt-5">
    <div class="col"> -->
<!-- <iframe src="https://drive.google.com/file/d/1dU4hyFruGupxq5a67a_cYHE2qseHO4Jf/view&embedded=true" width="580px" height="480px"></iframe> -->
<!-- <iframe src="https://docs.google.com/gview?url=http://static.googleusercontent.com/media/research.google.com/en//pubs/archive/43934.pdf&embedded=true" style="width: 500px; max-width: 100%; height: 640px;"></iframe> -->
<!-- <embed src="https://drive.google.com/file/d/1dU4hyFruGupxq5a67a_cYHE2qseHO4Jf/view" type="apllication/pdf" width="70%" height="600px"/> -->
<!-- <a href="https://drive.google.com/uc?export=view&id=1VqK6wn0uX2T7w3q27v5QKb98aeoKl7eM"><img src="https://drive.google.com/uc?export=view&id=1VqK6wn0uX2T7w3q27v5QKb98aeoKl7eM" style="width: 500px; max-width: 100%; height: auto" title="Click for the larger version." /></a> -->
<!-- </div>
</div> -->
@endsection