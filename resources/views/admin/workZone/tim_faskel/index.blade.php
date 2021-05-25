@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Wilayah Kerja</h4>
    </div>
    <div class="card-body">
        @include('admin.workZone.tim_faskel.navbar')

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tahun</th>
                    <th>Kabupaten</th>
                    <th>Tim</th>
                    <th>Lokasi</th>
                    <th>Zona</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workZones as $workZone)
                <tr>
                    <td>{{$workZone->id}} </td>
                    <td>{{$workZone->year}} </td>
                    <td>{{$workZone->level}} {{$workZone->kabupaten->NAMA_KAB ?? $workZone->district}} </td>
                    <td>{{$workZone->team}} </td>
                    <td>{{$workZone->zone_location_id ? $workZone->zone_location->location_type : ''}} </td>
                    <td>
                        Kelurahan/Desa: <br>
                        @foreach($workZone->villages as $village)
                        {{ $village->NAMA_DESA }},
                        @endforeach
                    </td>
                    <td class="d-flex">
                        <a href="/admin/areakerja/timfaskel/{{$workZone->id}}">
                            <button>
                                <i class="material-icons">preview</i>
                            </button>
                        </a>
                        <a href="/admin/areakerja/timfaskel/{{$workZone->id}}/edit">
                            <button>
                                <i class="material-icons">mode_edit</i>
                            </button>
                        </a>
                        <form action="/admin/areakerja/timfaskel/{{$workZone->id}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" onclick="return confirm('yakin mau menghapus data?')">
                                <i class="material-icons">delete</i>
                            </button>
                        </form>
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
