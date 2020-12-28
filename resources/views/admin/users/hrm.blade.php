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
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Posisi</th>
                        <th scope="col">Kabupaten/Kota</th>
                        <th scope="col">Email/Username</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kabupaten as $kab)
                    <tr>
                        <th colspan="5">{{ $kab->NAMA_KAB }}</php>
                    </tr>
                    @foreach($users[$kab->KD_KAB] as $user )
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->user()->pluck('name')->first()}}</td>
                        <td>{{ $user->posisi()->pluck('job_title')->first() }}</td>
                        <td>{{ $user->kabupaten()->pluck('NAMA_KAB')->first() }}</td>
                        <td>{{ $user->user()->pluck('email')->first()}}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>            
         </div>
    </div>
</div>


@endsection
