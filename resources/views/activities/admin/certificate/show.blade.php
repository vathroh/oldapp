@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">{{ $activity->name }}</h4>
    </div>
    @include('activities.organizer.navbar')
    <div class="card-body">
        <div class="my-5">

            <form method="post" action="/kegiatan/panitia/download-sertifikat/{{ $activity->id }}">
                @csrf
                <div style="width:100%;" class="text-center">
                    <button type="submit" class="btn btn-primary">Download Sertifikat</button>
                </div>
            </form>

        </div>
    </div>
    @endsection

    @section('script')
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
    @endsection