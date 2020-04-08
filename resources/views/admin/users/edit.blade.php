@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Edit User {{ $user->name }}</div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user)}}" method="post">
                        <div class="form-group row">
                            <label for="email" class="col-md-2 text-md-right">Email</label>
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-md-right">Name</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @csrf
                        {{ method_field('put') }}
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                                <label for="roles">Roles</label>
                            </div>

                            <div class="col-md-8">
                                @foreach($roles as $role)
                                <div class="form-check">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id}}" @if($user->roles->pluck('id')->contains($role->id)) checked @endif >
                                    <label>{{ $role->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>


    @endsection