$(document).ready(function () {
    $("#kabupaten").change(function () {
        // console.log();
        // var kode_kab = e.target.value;
        var kode_kab = $("#kabupaten").val();
        //ajax

        $.get('/ajax?kode_kab=' + kode_kab, function (data) {
            console.log(data);
            $("#kelurahan").empty();
            $("#kelurahan").append('<option value=" "> PILIH KELURAHAN </option>');
            $.each(data, function (index, kelurahanObj) {
                $("#kelurahan").append('<option value="' + kelurahanObj.KD_KEL + '">' + kelurahanObj.NAMA_DESA + '</option>');
            });
        });
    });

    $("#ksm_kabupaten").change(function () {
        // console.log();
        // var kode_kab = e.target.value;
        var kode_kab = $("#ksm_kabupaten").val();
        //ajax

        $.get('/ajaxkab?kode_kab=' + kode_kab, function (data) {
            console.log(data);
            $("#ksm_kelurahan").empty();
            $("#ksm_kelurahan").append('<option value=" "> PILIH KELURAHAN </option>');
            $.each(data, function (index, kelurahanObj) {
                $("#ksm_kelurahan").append('<option value="' + kelurahanObj.KD_KEL + '">' + kelurahanObj.NAMA_DESA + '</option>');
            });
        });
    });

    $("#ksm_kelurahan").change(function () {

        var kode_kel = $("#ksm_kelurahan").val();

        $.get('/ajaxksm?kode_kel=' + kode_kel, function (data) {
            console.log(data);
            $("#ksm_ksm").empty();
            $("#ksm_ksm").append('<option value=" ">PILIH KSM</option>');
            $.each(data, function (index, ksmObj) {
                $("#ksm_ksm").append('<option value="' + ksmObj.NAMA_KSM + ' ">' + ksmObj.NAMA_KSM + '</option>');
            });
        });
    });


    var macamDokumen_ksm = document.getElementById('macamDokumen_ksm');
    var label_macamDokumen_ksm = document.getElementById('label_macamDokumen_ksm');
    macamDokumen_ksm.style.visibility = 'hidden';
    label_macamDokumen_ksm.style.visibility = 'hidden';
    $("#jenisDokumen_ksm").change(function () {
        var jenisDokumen = $("#jenisDokumen_ksm").val();
        if (jenisDokumen == 3) {
            visible();
        } else if (jenisDokumen == 4) {
            visible();
        } else if (jenisDokumen == 5) {
            visible();
        } else {
            hide();
        }
    });

    function hide() {
        var macamDokumen_ksm = document.getElementById('macamDokumen_ksm');
        var label_macamDokumen_ksm = document.getElementById('label_macamDokumen_ksm');
        macamDokumen_ksm.style.visibility = 'hidden';
        label_macamDokumen_ksm.style.visibility = 'hidden';
        macamDokumen_ksm.append('<option value=""></option>');
        dropchainDokumen();
    }

    function visible() {
        var macamDokumen_ksm = document.getElementById('macamDokumen_ksm');
        var label_macamDokumen_ksm = document.getElementById('label_macamDokumen_ksm');
        label_macamDokumen_ksm.style.visibility = 'visible';
        macamDokumen_ksm.style.visibility = 'visible';
        dropchainDokumen();
    }

    function dropchainDokumen() {
        var jenisDokumen_ksm = $("#jenisDokumen_ksm").val();
        $.get('/dokumen?jenisDokumen_ksm=' + jenisDokumen_ksm, function (data) {
            console.log(data);
            $("#macamDokumen_ksm").empty();
            $("#macamDokumen_ksm").append('<option value="">PILIH DOKUMEN</option>');
            $.each(data, function (index, dokObj) {
                $("#macamDokumen_ksm").append('<option value="' + dokObj.JenisDokumen + '  ' + ' ">' + dokObj.JenisDokumen + '</option>');
            });
        });
    }


    $("#foto_kabupaten").change(function () {
        var kode_kab = $("#foto_kabupaten").val();

        $.get('/ajaxfoto?foto_kabupaten=' + kode_kab, function (data) {
            console.log(data);
            $("#foto_kelurahan").empty();
            $("#foto_kelurahan").append('<option value=" "> PILIH KELURAHAN </option>');
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
            $("#foto_kegiatan").append('<option value=" "> PILIH KEGIATAN </option>');
            $.each(data, function (index, fotokegiatanObj) {
                $("#foto_kegiatan").append('<option value="' + fotokegiatanObj.KEGIATAN + ' ' + fotokegiatanObj.RTRW + ' ">' + fotokegiatanObj.KEGIATAN + ' di ' + fotokegiatanObj.RTRW + '</option>');
            });
        });
    });

});
