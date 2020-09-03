@extends('layouts.MaterialDashboard')

@section('head')
<link href="{{ asset('css/kpp/style.css')  }}" rel="stylesheet">
@endsection

@section('content')

            <div class="card">
                <div class="card-header-primary">Users</div>

                <div class="card-body">
                    @foreach($users as $user)
                    <div class = "row">
                        <div class = "column" style = "width: 25px">
                            {{ $loop->iteration }}
                        </div>
                        <div class = "column" style = "width: 200px">
                            {{ $user->name }}
                        </div>
                        <div class = "column" style = "width: 160px">
                            {{ $user->job_title }}
                        </div>
                        <div class = "column" style = "width: 150px">
                            {{ $user->district }} {{$user->nama_kab}}
                        </div>
                        <div class = "column" style = "width: 200px">
                            {{ $user->email}}
                        </div>
                        <div class = "column" style = "width: 150px">
                            {{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}
                        </div>
                        <div class = "column" style = "width: 300px">
                            @can('delete-users')
                                <a href="{{'/pass-by-admin/' . $user->id . '/edit'}}"><button type="button" class="btn btn-primary">Ganti Password</button></a>
                            @endcan
                            @can('delete-users')
                                <a href="{{ route('admin.users.edit', $user->id) }}"><button type="button" class="btn btn-warning">Edit</button></a>
                            @endcan
                            @can('delete-users')
                                <a href="{{ route('admin.users.show', $user->id) }}"><button type="button" class="btn btn-danger">Delete</button></a>
                            @endcan

                        </div>
                    </div>
                    @endforeach 
                </div>
            </div>


<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Yakin delete {{ $user }}? 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <form action="{{ route('admin.users.destroy', $user) }}" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-warning">Delete</button>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
