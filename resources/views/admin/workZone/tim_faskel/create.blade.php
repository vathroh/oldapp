@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Wilayah Kerja</h4>
    </div>
    <div class="card-body">
        @include('admin.workZone.tim_faskel.navbar')

        <div class="col m-5 p-3" style="border: 1px solid grey; border-radius:3px; width:90%; box-shadow: 10px 10px 5px grey;">
            <form action="/admin/areakerja/timfaskel" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-2">Tahun</div>
                    <div class="col-10">
                        <select name="year" class="form-select" aria-label="multiple select example">
                            <option selected>Pilih Tahun</option>
                            <option value="{{Carbon\carbon::now()->year-1 }}">{{Carbon\carbon::now()->year-1 }}</option>
                            <option value="{{Carbon\carbon::now()->year }}">{{Carbon\carbon::now()->year }}</option>
                            <option value="{{Carbon\carbon::now()->year+1 }}">{{Carbon\carbon::now()->year +1 }}</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="level" value="Tim Faskel">
                <input type="hidden" name="zone_level_id" value="4">
                <div class="row" id="district">
                    <div class="col-2">Kabupaten</div>
                    <input name="index" type="hidden" value="KD_KEL">
                    <div class="col-10">
                        <select id="selectdistrict" name="district" class="form-select">
                            <option value="{{$workZone->districts[0]->id ?? '' }}">{{ $workZone->districts[0]->nama_kab ??'' }}</option>
                            @foreach($districts as $district)
                            <option value="{{$district->id}}">{{ $district->nama_kab }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">Tim</div>
                    <div class="col-10">
                        <input type="text" name="team">
                    </div>
                </div>
                <div class="row mt">
                    <div class="col-2">Wilayah Kerja</div>
                    <div class="col-10">
                        <div id="workzone">
                            <div id="workzonecontainer">
                            </div>
                            <div id="workzoneitem" class="d-flex mt-5">
                                <div class="d-flex">
                                </div>
                                <div class="d-flex">
                                    <select id="selectSubDistricts" class="form-select">
                                        <option>pilih Kecamatan</option>
                                    </select>

                                    <select id="selectvillages" class="form-select">
                                        <option>Pilih Kelurahan</option>
                                    </select>
                                    <i id="addicon" class="material-icons">add_box</i>
                                </div>
                            </div>
                            <div id="addworkzone">

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
            </form>
        </div>
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
                $("#selectSubDistricts").empty();
                $("#selectSubDistricts").append(
                    '<option>Pilih Kecamatan</option>'
                );
                $.each(data, function(index, kecamatanObj) {
                    $("#selectSubDistricts").append(
                        '<option value="' + kecamatanObj.KD_KEC + '">' + kecamatanObj.NAMA_KEC + '</option>'
                    );
                });
            }
        });
    });

    $("#selectSubDistricts").change(function() {
        var kode_kec = $(this).val();
        $.ajax({
            type: 'get',
            url: '/admin/kelurahan/areakerja',
            data: {
                'kode_kec': kode_kec
            },
            success: function(data) {
                $("#selectvillages").empty();
                $("#selectvillages").append(
                    '<option>Pilih Kelurahan</option>'
                );
                $.each(data, function(index, villagesObj) {
                    $("#selectvillages").append(
                        '<option value="' + villagesObj.id + '">' + villagesObj.NAMA_DESA + '</option>'
                    );
                });
            }
        });
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
</script>
@endsection