$(document).ready(function () {
    $("#kabupaten").change(function () {
        // console.log();
        // var kode_kab = e.target.value;
        var kode_kab = $("#kabupaten").val();
        //ajax

        $.get('/kppkecamatan?kode_kab=' + kode_kab, function (data) {
            console.log(data);
            $("#kecamatan").empty();
            $("#kecamatan").append('<option value="">Kecamatan</option>');
            $.each(data, function (index, kecamatanObj) {
                $("#kecamatan").append('<option value="' + kecamatanObj.KD_KEC + '">' + kecamatanObj.NAMA_KEC + '</option>');
            });
        });
    });

    $("#kecamatan").change(function () {

        var kode_kec = $("#kecamatan").val();

        $.get('/kppkelurahan?kode_kec=' + kode_kec, function (data) {
            console.log(data);
            $("#kelurahan").empty();
            $.each(data, function (index, kelurahanObj) {
                $("#kelurahan").append('<option value="' + kelurahanObj.KD_KEL + '">' + kelurahanObj.NAMA_DESA + '</option>');
            });
        });
    });


});
