@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Wilayah Kerja</h4>
    </div>
    <div class="card-body">
        @include('admin.workZone.osp.navbar')
        <div class="col m-5 p-3" style="border: 1px solid grey; border-radius:3px; width:90%; box-shadow: 10px 10px 5px grey;">
            <div class="row">
                <div class="col-2">No. Wilayah Kerja</div>
                <div class="col-10">{{ $workZone->id }}</div>
            </div>
            <div class="row">
                <div class="col-2">Tahun</div>
                <div class="col-10">{{ $workZone->year }}</div>
            </div>
            <div class="row">
                <div class="col-2">Level</div>
                <div class="col-10">{{ $workZone->level }}</div>
            </div>
            <div class="row">
                <div class="col-2">Kabupaten</div>
                <div class="col-10">{{ $workZone->district }}</div>
            </div>
            <div class="row">
                <div class="col-2">Wilayah Kerja</div>
                <div class="col-10">
                    <ol>
                        @if( $workZone->level == "Tim Faskel" || $workZone->level == "Kelurahan")
                        @foreach($workZone->villages as $village)
                        <li>{{$village->NAMA_DESA}} KECAMATAN {{$village->NAMA_KEC}}</li>
                        @endforeach
                        @else
                        @foreach($workZone->districts as $district)
                        <li>{{$district->nama_kab}} </li>
                        @endforeach
                        @endif
                    </ol>
                </div>
            </div>
            <div class="row mt-3 p-3">
                <a href="/admin/areakerja/osp/">
                    <button class="btn btn-primary">Batal</button>
                </a>
                <a href="/admin/areakerja/osp/{{ $workZone->id }}/edit">
                    <button class="btn btn-success">Edit</button>
                </a>
                <form action="/admin/areakerja/osp/{{ $workZone->id }}/delete" method="post">
                    @method('delete')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection