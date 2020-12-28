@extends('layouts.app')

@section('content')



<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col text-center">
                {{ $kegiatan[0]['KEGIATAN'] }} KSM {{ $ksm[0]['NAMA_KSM'] }}, Desa {{ $documents[0]['nama_desa'] }}, {{ $documents[0]['nama_kab'] }}
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="row">
            @foreach($documents as $document)
            <div class="col-4 my-3">
                <div class="card">
                    <img src="https://drive.google.com/uc?export=view&id={{ $document->file_id }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-center"> {{ $document->jenis_dokumen }} </h5>
                        <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row text-center">
            <div class="col justify-content-center">
                <span>{{ $documents->links() }}</span>
            </div>
        </div>
    </div>
</div>

@endsection