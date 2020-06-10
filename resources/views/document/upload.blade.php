@extends('layouts.app')

@section('content')

<section id="image-form-wrapper">
    <div class="card">
        <div class="card-header text-center">
            UPLOAD
        </div>
        <div class="card-body" id="app">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @elseif(session('message'))
            <div class="alert alert-info"> {{ session('message')}} </div>
            @endif

            <Formupload></Formupload>
        </div>
    </div>
</section>
<br>

@endsection

@section('script')
<script src="{{ asset('js/chainedDropDown.js') }}" defer></script>
@endsection