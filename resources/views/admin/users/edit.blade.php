@extends('layouts.MaterialDashboard')

@section('content')


<div class="card">
    <div class="card-header">Edit User {{ $user->name }}</div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user)}}" method="post">
            @csrf
            {{ method_field('put') }}
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label for="email">Email</label>
                </div>
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
                <div class="col-md-2 text-md-right">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-8">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
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

            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label for="job_title">
                        Posisi / Jabatan
                    </label>
                </div>
                <div class="col-md-8">
                    <select name="job_title" id="job_title" class="form-control input-lg dynamic" required>
                        <option value="{{ $user->job_title_id}}">{{ $user->job_title }} </option>
                        @foreach($job_titles as $job_title)
                        <option value="{{ $job_title->id}}">{{ $job_title->job_title}} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label for="district">
                        Kabupaten / Kota
                    </label>
                </div>
                <div class="col-md-8">
                    <select name="district" id="district" class="form-control input-lg dynamic" required>
                        <option value="{{ $user->district }}">{{ $user->district }} {{ $user->nama_kab }}</option>
                        @foreach($kabupaten as $kab)
                        <option value="{{ $kab->district }}">{{ $kab->district }} {{ $kab->NAMA_KAB }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label for="starting_date">
                        Tanggal Mulai Menjabat
                    </label>
                </div>
                <div class="col-md-8">
                    <input class="form-control input-lg dynamic" type="date" id="starting_date" name="starting_date" value="{{ $user->job_desc? $user->job_desc->starting_date: '' }}" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                    <label for="finishing_date">
                        Tanggal Selesai Menjabat
                    </label>
                </div>
                <div class="col-md-8">
                    <input class="form-control input-lg dynamic" type="date" id="finishing_date" name="finishing_date" value="{{ $user->job_desc? $user->job_desc->finishing_date: '' }}" required>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
            </div>
        </form>
    </div>


    @endsection
