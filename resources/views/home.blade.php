@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">


        <div class="card">
            <div class="card-header"></div>
            <div class="row" style="margin-top: 200px">
                <div class="col text-center" style="height: 300px">
                    <h1><a href="/doc">Silahkan Klik untuk melanjutkan</a></h1>
                </div>
            </div>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>



@endsection