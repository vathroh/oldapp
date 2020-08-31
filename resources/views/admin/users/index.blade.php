@extends('layouts.MaterialDashboard')

@section('content')

            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Posisi/Jabatan</th>
                                <th scope="col">Kabupaten/Kota</th>
                                <th scope="col">Email</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <th scope="row">{{$user->id}}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->job_title }}</td>
                                <td>{{ $user->district }} {{ $user->nama_kab }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
                                <td>
                                    @can('edit-users')
                                    <a href="{{ route('admin.users.edit', $user->id) }}"><button type="button" class="btn btn-primary float-left">Kelola</button></a>
                                    @endcan
                                    @can('delete-users')
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="post" class="float-left">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-warning">Delete</button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


@endsection
