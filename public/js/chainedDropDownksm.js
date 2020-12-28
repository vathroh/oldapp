$(document).ready(function () {

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
                $("#ksm_ksm").append('<option value="' + ksmObj.KD_KSM + ' ">' + ksmObj.NAMA_KSM + '</option>');
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




});
