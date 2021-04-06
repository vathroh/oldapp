@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Wilayah Kerja</h4>
    </div>
    <div class="card-body">
        @include('admin.workZone.tim_faskel.navbar')

        <div class="col m-5 p-3" style="border: 1px solid grey; border-radius:3px; width:90%; box-shadow: 10px 10px 5px grey;">
            <form action="/admin/areakerja/osp/{{$workZone->id}}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-2">Tahun</div>
                    <div class="col-10">
                        <select name="year" class="form-select">
                            <option selected value="{{$workZone->year}}">{{$workZone->year}}</option>
                            <option value="{{Carbon\carbon::now()->year-1 }}">{{Carbon\carbon::now()->year-1 }}</option>
                            <option value="{{Carbon\carbon::now()->year }}">{{Carbon\carbon::now()->year }}</option>
                            <option value="{{Carbon\carbon::now()->year+1 }}">{{Carbon\carbon::now()->year +1 }}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="zone_level_id" value="1">
                    <div class="col-2">Tingkat</div>
                    <div class="col-10">
                        <select id="level" name="level" class="form-select">
                            <option selected value="{{$workZone->level}}">{{$workZone->level}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">Tim</div>
                    <div class="col-10">
                        <input type="text" name="team" value="{{$workZone->team ??''}}">
                    </div>
                </div>
                <div class="row" id="district">
                    <input name="index" type="hidden" value="KD_KAB">
                    <input name="district" type="hidden" value="OSP">
                </div>
                <div class="row mt">
                    <div class="col-2">Wilayah Kerja</div>
                    <div class="col-10">
                        <div id="workzone">
                            <div id="workzonecontainer">
                            </div>
                            @foreach($workZone->districts as $district)
                            <div id="workzoneitem" class="d-flex">
                                <div class="col-5">
                                    <input type="checkbox" name="zones[]" value="{{ $district->id }}" id="workzoneitem" checked>
                                    <label for="workzoneitem">{{ $district->nama_kab }}</label>
                                </div>
                                <i id="removezoneicon" class="material-icons">delete</i>
                            </div>
                            @endforeach
                            <div id="addworkzone" class="mt-5">
                                <div class="d-flex">
                                    <select id="selectdistrict" class="form-select">
                                        <option selected>Pilih Kabupaten</option>
                                        @foreach($districts as $district)
                                        <option value="{{$district->id}}">{{$district->nama_kab}}</option>
                                        @endforeach
                                    </select>
                                    <i id="addicon" class="material-icons">add_box</i>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 p-3">
                        <a href="/admin/areakerja/osp">
                            <button type="button" class="btn btn-primary">Batal</button>
                        </a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $("#addicon").click(function() {
        var workzoneitem = $("#selectdistrict").val();
        var workzoneitemname = $("#selectdistrict option:selected").text();
        var subdistrict = $("#selectsubdistrict option:selected").text();
        console.log(workzoneitem);
        $("i#removezoneicon").click(function() {
            $(this).parent().empty();
            console.log('hehe');
        });
        $("#workzonecontainer").append(
            '<div id="workzoneitem" class="d-flex">' +
            '<div class="col-5">' +
            '<input type="checkbox" name="zones[]" value="' + workzoneitem + '" id="workzoneitem" checked>' +
            '<label for="workzoneitem">' + workzoneitemname + '</label>' +
            '</div>' +
            '<i id="removezoneicon" class="material-icons">delete</i>' +
            '</div>'
        );

    });

    $("i#removezoneicon").click(function() {
        $(this).parent().empty();
    });
</script>
@endsection