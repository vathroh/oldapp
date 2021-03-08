@extends('layouts.MaterialDashboard')

@section('head')
<style>
    .container {
        display: flex;
        justify-content: space-around;
        align-items: center;
        height: 300px;
    }

    .item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 200px;
        height: 75px;
        border: 2px solid grey;
        border-radius: 5px;
        background-color: grey;
        font-size: 24px;
        color: whitesmoke;
        box-shadow: 4px 4px 6px black;
        text-shadow: 2px 2px 5px black;
        text-transform: uppercase;
    }

    .container a {
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Wilayah Kerja</h4>
    </div>
    <div class="card-body">
        <div class="container">
            <a href="/admin/areakerja/timfaskel">
                <div class="item">
                    Tim Faskel
                </div>
            </a>
            <a href="/admin/areakerja/korkot">
                <div class="item">
                    Korkot
                </div>
            </a>
            <a href="/admin/areakerja/askotmandiri">
                <div class="item">
                    Askot Mandiri
                </div>
            </a>
            <a href="/admin/areakerja/osp">
                <div class="item">
                    OSP
                </div>
            </a>
        </div>
    </div>
</div>
@endsection