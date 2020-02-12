@extends('layouts.app')

@section('content')

<div class="card text-center">
    <div class="card-header">
        <div class="row">
            <div class="col text-center">
                <a href="/create" class="btn btn-primary">Upload Dokumen/Foto</a>
                <a href="/doc" class="btn btn-primary">Bentuk Card</a>
                <a href="/table" class="btn btn-primary">Bentuk Tabel</a>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="row text-bold text-light mt-3">
            <div class=" col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Desa/Kelurahan</th>
                            <th scope="col">Kecamatan</th>
                            <th scope="col">Kabupaten</th>
                            <th scope="col">Jenis Dokumen</th>
                            <th scope="col">Lihat File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $documents->sortByDesc('created_at') as $document )
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $document->desa }}</td>
                            <td>{{ $document->kecamatan }}</td>
                            <td>{{ $document->kabupaten }}</td>
                            <td>{{ $document->jenis_dokumen }}</td>
                            <td><a href="{{ $document->link }}" target="_blank">Lihat File</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col justify-content-center">
                <span>{{ $documents->links() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection