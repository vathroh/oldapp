@extends('layouts.MaterialDashboard')

@section('head')
<link href="{{ asset('css/kpp/style.css')  }}" rel="stylesheet">
@endsection


@section('content')

<div class="card">
    <div class="card-header-primary">Personil OSP 1 Jawa Tengah1</div>
        <div id="users" class="card-body">
            @include('admin.users.navbar')
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama</td>
                        <td>Posisi</td>
                        <td>Kabupaten/Kota</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->user()->first()->name }}</td>
                        <td>{{ $user->posisi()->first()->job_title }}</td>
                        <td>{{ $user->kabupaten->first()->NAMA_KAB }}
                    </tr>
                    @endforeach 
                </tbody>
            </table>            
         </div>
    </div>
</div>


@endsection
