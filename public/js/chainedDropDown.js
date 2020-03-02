$(document).ready(function () {
    $("#kabupaten").change(function () {
        // console.log();
        // var kode_kab = e.target.value;
        var kode_kab = $("#kabupaten").val();
        //ajax

        $.get('/ajax?kode_kab=' + kode_kab, function (data) {
            console.log(data);
            $("#kelurahan").empty();
            $.each(data, function (index, kelurahanObj) {
                $("#kelurahan").append('<option value="' + kelurahanObj.KD_KEL + '">' + kelurahanObj.NAMA_DESA + '</option>');
            });
        });
    });


});
