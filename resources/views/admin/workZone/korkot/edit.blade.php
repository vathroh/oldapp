@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Wilayah Kerja</h4>
    </div>
    <div class="card-body">
        @include('admin.workZone.korkot.navbar')
        <div class="col m-5 p-3" style="border: 1px solid grey; border-radius:3px; width:90%; box-shadow: 10px 10px 5px grey;">
            <form action="/admin/areakerja/korkot/{{$workZone->id}}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-2">Tahun</div>
                    <div class="col-10">
                        <select name="year" class="form-select">
                            <option selected value="{{$workZone->year}}">{{$workZone->year}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="zone_level_id" value="2">
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
                    <div class="col-2">Kabupaten</div>
                    <input name="index" type="hidden" value="KD_KAB">
                    <div class="col-10">
                        <select id="selectdistrict" name="district" class="form-select">
                            <option value="{{$workZone->districts[0]->id ?? '' }}">{{ $workZone->districts[0]->nama_kab ??'' }}</option>
                            @foreach($districts as $district)
                            <option value="{{$district->id}}">{{ $district->nama_kab }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt">
                    <div class="col-2">Wilayah Kerja</div>
                    <div class="col-10">
                        <div id="workzone">
                            <div id="workzonecontainer">
                                @if($workZone->level != "Tim Faskel" || $workZone->level != "Tim Faskel")
                                @foreach($workZone->districts as $district)
                                <div id="workzoneitem" class="d-flex">
                                    <div class="col-5">
                                        <input type="checkbox" name="zones[]" value="{{ $district->id ??'' }}" id="workzoneitem" checked>
                                        <label for="workzoneitem">{{ $district->nama_kab }}</label>
                                    </div>
                                    <i id="removezoneicon" class="material-icons">delete</i>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div id="addworkzone">
                                @if($workZone->level != "Tim Faskel" || $workZone->level != "Tim Faskel")
                                <div class="d-flex">
                                    <select id="selectworkzone" class="form-select">
                                        <option selected>Pilih Kabupaten</option>
                                        @foreach($districts as $district)
                                        <option value="{{$district->id}}">{{$district->nama_kab}}</option>
                                        @endforeach
                                    </select>
                                    <i id="addicon" class="material-icons">add_box</i>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 p-3">
                        <a href="/admin/areakerja">
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
    $("#level").change(function() {
        var level = $("#level").val();

        if (level == "Tim Faskel" || level == "Kelurahan") {
            $("#addworkzone").empty();
            $('#district').empty();
            $.ajax({
                type: 'get',
                url: '/admin/kabupaten/areakerja',
                success: function(data) {
                    $('#district').append(
                        '<div class="col-2">Kabupaten</div>' +
                        '<input name="index" type="hidden" value="KD_KEL">' +
                        '<div class="col-10">' +
                        '<select id="selectdistrict" name="district" class="form-select" aria-label="Default select example">' +
                        '<option>Pilih Kabupaten</option>' +
                        '</select>' +
                        '</div>'
                    );
                    $.each(data, function(index, kabupatenObj) {
                        $("#selectdistrict").append(
                            '<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama_kab + '</option>'
                        );
                    });

                    $("#selectdistrict").change(function() {
                        var kode_kab = $(this).val();
                        $.ajax({
                            type: 'get',
                            url: '/admin/kecamatan/areakerja',
                            data: {
                                'kode_kab': kode_kab
                            },
                            success: function(data) {
                                $("#addworkzone").empty();
                                $("#addworkzone").append(
                                    '<div class="d-flex">' +
                                    '<select id="selectworkzone" class="form-select">' +
                                    '<option>pilih Kecamatan</option>' +
                                    '</select>' +
                                    '<div id="addvillages"></div>' +
                                    '<div>'
                                );
                                $.each(data, function(index, kecamatanObj) {
                                    $("#selectworkzone").append(
                                        '<option value="' + kecamatanObj.KD_KEC + '">' + kecamatanObj.NAMA_KEC + '</option>'
                                    );
                                });
                                $("#selectworkzone").change(function() {
                                    $("#addvillages").empty();
                                    var kode_kec = $(this).val();
                                    $.ajax({
                                        type: 'get',
                                        url: '/admin/kelurahan/areakerja',
                                        data: {
                                            'kode_kec': kode_kec
                                        },
                                        success: function(data) {
                                            $("#addvillages").append(
                                                '<div class="d-flex">' +
                                                '<select id="selectvillages" class="form-select">' +
                                                '<option>Pilih Kelurahan</option>' +
                                                '</select>' +
                                                '<i id="addicon" class="material-icons">add_box</i>' +
                                                '<div>'
                                            );
                                            $.each(data, function(index, kelurahanObj) {
                                                $("#selectvillages").append(
                                                    '<option value="' + kelurahanObj.id + '">' + kelurahanObj.NAMA_DESA + '</option>'
                                                );
                                            });
                                            $("#addicon").click(function() {
                                                var workzoneitem = $("#selectvillages").val();
                                                var workzoneitemname = $("#selectvillages option:selected").text();
                                                $("i#removezoneicon").click(function() {
                                                    $(this).parent().empty();
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
                                        }
                                    });
                                });
                            }
                        });
                    });
                }
            });
        } else if (level == "OSP") {
            $('#district').empty();
            $('#district').append(
                '<input name="district" type="hidden" value="OSP">' +
                '<input name="index" type="hidden" value="KD_KAB">'
            );
            $("#addworkzone").empty();
            $.ajax({
                type: 'get',
                url: '/admin/kabupaten/areakerja',
                success: function(data) {
                    $("#addworkzone").append(
                        '<div class="d-flex">' +
                        '<select id="selectworkzone" class="form-select">' +
                        '</select>' +
                        '<i id="addicon" class="material-icons">add_box</i>' +
                        '<div>'
                    );
                    $.each(data, function(index, kabupatenObj) {
                        $("#selectworkzone").append(
                            '<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama_kab + '</option>'
                        );
                    });
                    $("#addicon").click(function() {
                        var workzoneitem = $("#selectworkzone").val();
                        var workzoneitemname = $("#selectworkzone option:selected").text();
                        $("i#removezoneicon").click(function() {
                            $(this).parent().empty();
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
                }
            });
        } else {
            $('#district').empty();
            $("#addworkzone").empty();
            $.ajax({
                type: 'get',
                url: '/admin/kabupaten/areakerja',
                success: function(data) {
                    $('#district').append(
                        '<div class="col-2">Kabupaten</div>' +
                        '<input name="index" type="hidden" value="KD_KAB">' +
                        '<div class="col-10">' +
                        '<select id="selectdistrict" name="district" class="form-select" aria-label="Default select example">' +
                        '</select>' +
                        '</div>'
                    );
                    $.each(data, function(index, districtObj) {
                        $("#selectdistrict").append(
                            '<option value="' + districtObj.id + '">' + districtObj.nama_kab + '</option>'
                        );
                    });

                    $("#addworkzone").append(
                        '<div class="d-flex">' +
                        '<select id="selectworkzone" class="form-select">' +
                        '</select>' +
                        '<i id="addicon" class="material-icons">add_box</i>' +
                        '<div>'
                    );
                    $.each(data, function(index, kabupatenObj) {
                        $("#selectworkzone").append(
                            '<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama_kab + '</option>'
                        );
                    });
                    $("#addicon").click(function() {
                        var workzoneitem = $("#selectworkzone").val();
                        var workzoneitemname = $("#selectworkzone option:selected").text();
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
                }
            });
        }
    });

    $("#addicon").click(function() {
        var workzoneitem = $("#selectworkzone").val();
        var workzoneitemname = $("#selectworkzone option:selected").text();
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