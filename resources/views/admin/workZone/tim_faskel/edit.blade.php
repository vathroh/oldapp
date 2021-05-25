@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Wilayah Kerja</h4>
    </div>
    <div class="card-body">
        @include('admin.workZone.tim_faskel.navbar')

        <div class="col m-5 p-3" style="border: 1px solid grey; border-radius:3px; width:90%; box-shadow: 10px 10px 5px grey;">
            <form action="/admin/areakerja/timfaskel/{{$workZone->id}}" method="post" enctype="multipart/form-data">
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
                    <input type="hidden" name="zone_level_id" value="4">
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
                    <input name="index" type="hidden" value="KD_KEL">
                    <div class="col-2">Kabupaten</div>
                    <div class="col-10">
                        <select id="selectdistrict" name="district" class="form-select">
                            <option value="{{$workZone->district_id ?? $districts->where('kode_kab', $workZone->kabupaten->KD_KAB)->first()->id }}">{{ $workZone->kabupaten->NAMA_KAB ??'' }}</option>
                            @foreach($districts as $district)
                            <option value="{{$district->id}}">{{ $district->nama_kab }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">Lokasi</div>
                    <div class="col-10">
			<select name="zone_location" class="form-select">
				<option value="{{ $workZone->zone_location ? $workZone->zone_location->id : ''}}">{{ $workZone->zone_location ? $workZone->zone_location->location_type : ''}}</option>
				@foreach($locations as $location)
				<option value="{{ $location->id }}">{{ $location->location_type }}</option>
				@endforeach
                        </select>
                    </div>
               </div>
               <div class="row mt">
                    <div class="col-2">Wilayah Kerja</div>
                    <div class="col-10">
                        <div id="workzone">
                            <div id="workzonecontainer">
                            </div>
                            @foreach($workZone->villages as $village)
                            <div id="workzoneitem" class="d-flex">
                                <div class="col-5">
                                    <input type="checkbox" name="zones[]" value="{{ $village->id }}" id="workzoneitem" checked>
                                    <label for="workzoneitem">{{ $village->NAMA_DESA }} KECAMATAN {{ $village->NAMA_KEC }}</label>
                                </div>
                                <i id="removezoneicon" class="material-icons">delete</i>
                            </div>
                            @endforeach
                            <div id="addworkzone" class="mt-5">

                                <div class="d-flex">
                                    <select id="selectsubdistrict" class="form-select">
                                        <option selected>Pilih Kecamatan</option>
                                        @foreach($subdistricts->unique('KD_KEC') as $subdistrict)
                                        <option value="{{$subdistrict->KD_KEC}}">{{$subdistrict->NAMA_KEC}}</option>
                                        @endforeach
                                    </select>
                                    <select id="selectvillages" class="form-select">
                                        <option selected>Pilih Kelurahan</option>
                                    </select>
                                    <i id="addicon" class="material-icons">add_box</i>
                                </div>

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

    $("#selectsubdistrict").change(function() {
        var kode_kec = $(this).val();
        console.log(kode_kec)
        $.ajax({
            type: 'get',
            url: '/admin/kelurahan/areakerja',
            data: {
                'kode_kec': kode_kec
            },
            success: function(data) {
                console.log(data)
                $("#selectvillages").empty();
                $.each(data, function(index, kelurahanObj) {
                    $("#selectvillages").append(
                        '<option value="' + kelurahanObj.id + '">' + kelurahanObj.NAMA_DESA + '</option>'
                    );
                });
            }
        });
    });

    $("#addicon").click(function() {
        var workzoneitem = $("#selectvillages").val();
        var workzoneitemname = $("#selectvillages option:selected").text();
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
            '<label for="workzoneitem">' + workzoneitemname + ' KECAMATAN ' + subdistrict + '</label>' +
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
