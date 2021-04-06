@extends('layouts.MaterialDashboard')
@section('head')
<style>
    table {
        text-transform: uppercase;
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Wilayah Kerja</h4>
    </div>
    <div class="card-body">
        @include('admin.workZone.askot_mandiri.navbar')
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tahun</th>
                    <th>Kabupaten</th>
                    <th>Tim</th>
                    <th>Zona</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workZones as $workZone)
                <tr>
                    <td>{{$workZone->id}} </td>
                    <td>{{$workZone->year}} </td>
                    <td>{{$workZone->level}} {{$workZone->districts[0]->nama_kab ?? $workZone->district}} </td>
                    <td>{{$workZone->team}} </td>
                    <td>
                        Kabupaten: <br>
                        @foreach($workZone->districts as $district)
                        {{ $district->nama_kab }},
                        @endforeach
                    </td>
                    <td class="d-flex">
                        <a href="/admin/areakerja/askotmandiri/{{$workZone->id}}">
                            <button>
                                <i class="material-icons">preview</i>
                            </button>
                        </a>
                        <form action="/admin/areakerja/askotmandiri/{{$workZone->id}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" onclick="return confirm('Mau hapus data ini?');">
                                <i class="material-icons">delete</i>
                            </button>
                        </form>
                        <a href="/admin/areakerja/askotmandiri/{{$workZone->id}}/edit">
                            <button>
                                <i class="material-icons">mode_edit</i>
                            </button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row text-center">
            <div class="col justify-content-center">
                <span>{{ $workZones->links() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection