@extends('layouts.MaterialDashboard')

@section('head')
<script src="https://kit.fontawesome.com/e3a45180d4.js" crossorigin="anonymous"></script>
<style>
    #activity {
        display: flex;
    }

    .number {
        width: 30px;
    }

    .nama_pelatihan {
        width: 400px;
    }

    .icon {
        display: flex;
        font-size: 24px;
        width: 70px;
        text-align: center;
    }

    .index {
        margin-top: 50px;
        margin-bottom: 50px;
    }

    .container {
        display: flex;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">SETUP SERTIFIKAT</h4>
    </div>
    <div class="card-body">
        @include('activities.certificate.setup.navbar')
        <div class="container">
            <div class="index">
                @foreach($activities as $activity)
                <div id="activity">
                    <div class="icon">
                        @if($activity->certificate)
                        <i class="fas fa-check-circle" style="color: green;"></i>
                        @else
                        <i class="fas fa-times-circle" style="color: red;"></i>
                        @endif
                    </div>
                    <div class="nama_pelatihan">
                        {{$activity->name}}
                    </div>
                    <div class="icon">
                        @if($activity->certificate)
                        <a href="/kegiatan/panitia/setup/sertifikat/{{ $activity->certificate->id }}/edit">
                            <button class="btn">
                                <i class="fas fa-cogs" style="color: blue;"></i>
                            </button>
                        </a>
                        <form action="/kegiatan/panitia/setup/sertifikat/{{ $activity->certificate->id }}" method="post" enctype="multipart/form-data">
                            @method('delete')
                            @csrf
                            <button class="btn">
                                <i class="fas fa-trash-alt" style="color: red;"></i>
                            </button>
                        </form>
                        @else
                        <form action="/kegiatan/panitia/setup/sertifikat" method="post" enctype="multipart/form-data">
                            @csrf
                            <input name="activity_id" type="hidden" value="{{ $activity->id }}">
                            <button class="btn">
                                <i class="fab fa-creative-commons-share" style="color: green;"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection