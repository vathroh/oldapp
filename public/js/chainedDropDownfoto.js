$(document).ready(function () {
    $("#foto_kabupaten").change(function () {
        var kode_kab = $("#foto_kabupaten").val();

        $.get('/ajaxfoto?foto_kabupaten=' + kode_kab, function (data) {
            console.log(data);
            $("#foto_kelurahan").empty();
            $("#foto_kelurahan").append('<option value="">' + '</option>');
            $.each(data, function (index, fotokelurahanObj) {
                $("#foto_kelurahan").append('<option value="' + fotokelurahanObj.KD_KEL + '">' + fotokelurahanObj.NAMA_DESA + '</option>');
            });
        });
    });

    $("#foto_kelurahan").change(function () {
        var foto_kelurahan = $("#foto_kelurahan").val();

        $.get('/ajaxfotoksm?foto_kelurahan=' + foto_kelurahan, function (data) {
            console.log(data);
            $("#foto_ksm").empty();
            $("#foto_ksm").append('<option value=" ">PILIH KSM</option>');
            $.each(data, function (index, ksmfotoObj) {
                $("#foto_ksm").append('<option value="' + ksmfotoObj.KD_KSM + ' ">' + ksmfotoObj.NAMA_KSM + '</option>');
            });
        });
    });

    var lokasirtdantitik = document.getElementById('lokasirtdantitik');
    lokasirtdantitik.style.visibility = 'hidden';
    $("#jenisDokumenFoto").change(function () {
        var jenisDokumen = $("#jenisDokumenFoto").val();
        if (jenisDokumen == 1) {
            hidelokasi();
        } else if (jenisDokumen == 2) {
            hidelokasi();
        } else if (jenisDokumen == 3) {
            hidelokasi();
        } else {
            showlokasi();
        }

    });

    function hidelokasi() {
        var lokasirtdantitik = document.getElementById('lokasirtdantitik');
        lokasirtdantitik.style.visibility = 'hidden';
        $("#foto_kegiatan").empty()
    }

    function showlokasi() {
        var lokasirtdantitik = document.getElementById('lokasirtdantitik');
        lokasirtdantitik.style.visibility = 'visible';
    }


    $("#foto_ksm").change(function () {
        var foto_ksm = $("#foto_ksm").val();

        $.get('/ajaxfotokegiatan?foto_ksm=' + foto_ksm, function (data) {
            console.log(data);
            $("#foto_kegiatan").empty();
            $.each(data, function (index, fotokegiatanObj) {
                $("#foto_kegiatan").append('<option value="' + fotokegiatanObj.KD_KEGIATAN + ' ">' + fotokegiatanObj.KEGIATAN + ' di ' + fotokegiatanObj.RTRW + '</option>');
            });
        });
    });




});
