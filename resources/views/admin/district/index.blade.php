@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Kabupaten</h4>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Kabupaten</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($districts as $district)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $district->kode_kab }}</td>
                    <td>{{ $district->nama_kab }}</td>
                    <td>
                        <i class="material-icons">preview</i>
                        <i class="material-icons">delete</i>
                        <i class="material-icons">mode_edit</i>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection