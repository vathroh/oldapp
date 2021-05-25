@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Wilayah Kerja</h4>
    </div>
    <div class="card-body">
        @include('admin.workZone.tim_faskel.navbar')

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
                <div class="col-10">{{ $workZone->kabupaten->NAMA_KAB }}</div>
            </div>
            <div class="row">
                <div class="col-2">Lokasi</div>
                <div class="col-10">{{ $workZone->zone_location ? $workZone->zone_location->location_type : '' }}</div>
           </div>
           <div class="row">
                <div class="col-2">Wilayah Kerja</div>
            </div>
            <div class="row">
                <div class="col-10">
                    <ol>
                        @foreach($workZone->villages as $village)
                        <li>{{$village->NAMA_DESA}} KECAMATAN {{$village->NAMA_KEC}}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
            <div class="row mt-3 p-3">
                <a href="/admin/areakerja">
                    <button class="btn btn-primary">Batal</button>
                </a>
                <a href="/admin/areakerja/{{ $workZone->id }}/edit">
                    <button class="btn btn-success">Edit</button>
                </a>
                <form action="/admin/areakerja/{{ $workZone->id }}/delete" method="post">
                    @method('delete')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
