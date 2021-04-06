@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Wilayah Kerja</h4>
    </div>
    <div class="card-body">
        @include('admin.workZone.osp.navbar')
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tahun</th>
                    <th>Tingkat</th>
                    <th>Zona</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workZones as $workZone)
                <tr>
                    <td>{{$workZone->id}} </td>
                    <td>{{$workZone->year}} </td>
                    <td>{{$workZone->level}} </td>
                    <td>
                        Kabupaten: <br>
                        @foreach($workZone->districts as $district)
                        {{ $district->nama_kab }},
                        @endforeach
                    </td>
                    <td class="d-flex">
                        <a href="/admin/areakerja/osp/{{$workZone->id}}">
                            <button>
                                <i class="material-icons">preview</i>
                            </button>
                        </a>
                        <a href="/admin/areakerja/osp/{{$workZone->id}}/edit">
                            <button>
                                <i class="material-icons">mode_edit</i>
                            </button>
                        </a>
                        <form action="/admin/areakerja/osp/{{$workZone->id}}" method="post">
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
<script>
    $("#addteambutton").click(function() {
        $("#addteam").empty();
        $("#addteam").append(
            '<button class="btn" id="addteambutton">' +
            '<i class="material-icons">add_box</i> Tambah Data' +
            '</button>' +
            '<a href="/admin/areakerja/timfaskel/create">' +
            '<button class="btn">Tim Faskel</button></a>' +
            '<a href="/admin/areakerja/korkot/create">' +
            '<button class="btn">Korkot/Askot Mandiri</button></a>' +
            '<a href="/admin/areakerja/timfaskel/create">' +
            '<button class="btn">OSP</button></a>'
        );
        console.log('heloo');
    });
</script>
@endsection