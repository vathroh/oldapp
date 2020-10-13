    $("#search").keyup(function () {
        var kelurahan = $("#search").val();
        $.get('/searchindexkpp?kelurahan=' + kelurahan, function (data) {
          console.log(data);
            $("tbody").empty();
            $("#indexKPPpagination").empty();
            $.each(data[0], function (index, kppObj) {
                $("tbody").append('<tr><td>' + (index+1) + '</td><td>'+ kppObj.NAMA_KAB + '</td><td>'+ kppObj.NAMA_KEC +'</td><td><a href = "/kpp/' + kppObj.id + '">'+ kppObj.NAMA_DESA +'</a></td><td>'+ kppObj.bkm +'</td><td>'+ kppObj.lokasi_bdi_bpm +'</td><td>'+ kppObj.Status +'</td><td>'+ kppObj.nama_kpp + '</td><td>'+ kppObj.ketua_kpp +'</td><td>'+ kppObj.ketua_kpp_hp +'</td><td>'+ kppObj.anggota_pria +'</td><td>'+ kppObj.anggota_wanita +'</td><td>'+ kppObj.anggota_miskin +'</td><td>'+ function(){ return kppObj.struktur_organisasi} +'</td><td>'+ kppObj.anggaran_dasar +'</td><td>'+ kppObj.anggaran_rumah_tangga +'</td><td>'+ kppObj.surat_keputusan +'</td><td>'+ kppObj.rencana_kerja +'</td><td>'+ kppObj.pertemuan_rutin +'</td><td>'+ kppObj.administrasi_rutin +'</td><td>'+ kppObj.buku_inventaris_kegiatan +'</td><td>'+ '</td><td>' +'</td><td>'+ kppObj.kegiatan_pengecekan +'</td><td>'+ kppObj.tanggal_mulai +'</td><td>'+ kppObj.sumber_dana +'</td><td>'+ kppObj.jumlah +'</td><td>'+ kppObj.keterangan_lain_lain +'</td><td>'+ kppObj.name +'</td></tr>');
            });
        });
    });

