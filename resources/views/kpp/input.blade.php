@extends('layouts.master1')

@section('head')
<link href="{{ asset('css/kpp/style.css') }}" rel="stylesheet">
@endsection

@section('content')


<div class="wrapper">

    <div class="mainbar">

        <h3>UPDATE DATA KPP</h3>

        <form method="post" action="kpp" enctype="multipart/form-data">

            @csrf

            <div class="data-group data-lokasi">
                <div class="form-group">
                    <label for="kabupaten">
                        Kabupaten
                    </label>
                    <select name="kabupaten" id="kabupaten" class="form-control input-lg dynamic" required>
                        <option value="">Kabupaten</option>
                        @foreach($kabupaten as $kab)
                        <option value="{{$kab->kode_kab}}">{{$kab->nama_kab}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan" class="form-control input-lg dynamic" required>
                        <option value="">Kecamatan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kelurahan">
                        Kelurahan
                    </label>
                    <select name="kelurahan" id="kelurahan" class="form-control input-lg dynamic" required>
                        <option value="">Kelurahan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="BKM">
                        Nama BKM
                    </label>
                    <select name="BKM" id="BKM" class="form-control input-lg dynamic" required>
                        <option value="">BKM</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="lokasi_bdi">
                        lokasi BDI/BPM
                    </label>
                    <select name="lokasi_bdi" id="lokasi_bdi" class="form-control input-lg dynamic" required>
                        <option value="">lokasi_bdi</option>
                    </select>
                </div>
            </div>

            <div class="data-group data-kpp">
                <div class="form-group">
                    <label for="kode_kpp">Kode KPP</label>
                    <input type="text" class="form-control" id="kode_kpp">
                </div>
                <div class="form-group">
                    <label for="nama_kpp">Nama KPP</label>
                    <input type="text" class="form-control" id="nama_kpp">
                </div>
                <div class="form-group">
                    <label for="anggota_laki-laki">Jumlah Anggota Laki-Laki</label>
                    <input type="text" class="form-control" id="anggota_laki-laki">
                </div>
                <div class="form-group">
                    <label for="anggota_perempuan">Jumlah Anggota Perempuan</label>
                    <input type="text" class="form-control" id="anggota_perempuan">
                </div>
                <div class="form-group">
                    <label for="anggota_miskin">Jumlah Anggota Miskin</label>
                    <input type="text" class="form-control" id="anggota_miskin">
                </div>
            </div>

            <div class="data-group document">

                <h5>Upload Dokumen</h5>

                <div class="document-group">

                    <div class="document_item struktur_organisasi">

                        <h6>Struktur Organisasi</h6>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="struktur_organisasi" id="struktur_organisasi" value="Tidak Ada" checked>
                            <label class="form-check-label" for="struktur_organisasi">
                                Tidak Ada
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="struktur_organisasi" id="struktur_organisasi1" value="Ada">
                            <label class="form-check-label" for="struktur_organisasi1">
                                Ada
                            </label>
                        </div>

                        <p>Upload Scan</p>

                        <input type="file" class="form-control-file" id="scan_struktur_organisasi">
                    </div>
                </div>

                <div class="document-group">

                    <h6>Pengesahan/Dasar Lembaga KPP</h6>

                    <div class="document_item pembentukan">                    
                        <h6>Anggaran Dasar</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="anggaran_dasar" id="exampleRadios1" value="Tidak Ada" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Tidak Ada
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="anggaran_dasar" id="exampleRadios2" value="Ada">
                            <label class="form-check-label" for="exampleRadios2">
                                Ada
                            </label>
                        </div>

                        <p>Upload Scan</p>

                        <input type="file" class="form-control-file" id="scan_struktur_organisasi">
                    </div>

                    <div class="document_item pembentukan">                    
                        <h6>Anggaran Rumah Tangga</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="anggaran_rumah_tangga" id="exampleRadios1" value="Tidak Ada" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Tidak Ada
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="anggaran_rumah_tangga" id="exampleRadios2" value="Ada">
                            <label class="form-check-label" for="exampleRadios2">
                                Ada
                            </label>
                        </div>

                        <p>Upload Scan</p>

                        <input type="file" class="form-control-file" id="anggaran_rumah_tangga">
                    </div>

                    <div class="document_item pembentukan">                    
                        <h6>Surat Keputusan</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="surat_keputusan" id="exampleRadios1" value="Tidak Ada" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Tidak Ada
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="surat_keputusan" id="exampleRadios2" value="Ada">
                            <label class="form-check-label" for="exampleRadios2">
                                Ada
                            </label>
                        </div>

                        <p>Upload Scan</p>

                        <input type="file" class="form-control-file" id="surat_keputusan">
                    </div>
                </div>

                <div class="document-group">

                    <div class="document_item rencana_kerja">

                        <h6>Rencana Kerja</h6>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rencana_kerja" id="rencana_kerja" value="Tidak Ada" checked>
                            <label class="form-check-label" for="rencana_kerja">
                                Tidak Ada
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rencana_kerja" id="rencana_kerja1" value="Ada">
                            <label class="form-check-label" for="rencana_kerja1">
                                Ada
                            </label>
                        </div>

                        <p>Upload Scan</p>

                        <input type="file" class="form-control-file" id="scan_struktur_organisasi">
                    </div>
                </div>

                <div class="document-group">

                    <div class="document_item pertemuan_rutin">

                        <h6>Pertemuan Rutin</h6>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pertemuan_rutin" id="pertemuan_rutin" value="Tidak Ada" checked>
                        <label class="form-check-label" for="pertemuan_rutin">
                            Setiap Bulan
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pertemuan_rutin" id="pertemuan_rutin1" value="Ada">
                        <label class="form-check-label" for="pertemuan_rutin1">
                            Setiap Tiga Bulan
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pertemuan_rutin" id="pertemuan_rutin1" value="Ada">
                        <label class="form-check-label" for="pertemuan_rutin1">
                            Setiap Enam Bulan
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pertemuan_rutin" id="pertemuan_rutin1" value="Ada">
                        <label class="form-check-label" for="pertemuan_rutin1">
                            Insidentil (sesuai kebutuhan)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pertemuan_rutin" id="pertemuan_rutin1" value="Ada">
                        <label class="form-check-label" for="pertemuan_rutin1">
                            Tidak Pernah (dalam satu tahun)
                        </label>
                    </div>
                </div>

                <div class="document-group">

                    <div class="document_item pertemuan_rutin">

                        <h6>Pencatatan/Administrasi Rutin</h6>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="administrasi_rutin" id="administrasi_rutin" value="Tidak Ada" checked>
                        <label class="form-check-label" for="administrasi_rutin">
                            Administrasi Bulanan Lengkap
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="administrasi_rutin" id="administrasi_rutin1" value="Ada">
                        <label class="form-check-label" for="administrasi_rutin1">
                            Administrasi Bulanan Minimalis
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="administrasi_rutin" id="administrasi_rutin1" value="Ada">
                        <label class="form-check-label" for="administrasi_rutin1">
                            Administrasi Triwulan/Selebihnya
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="administrasi_rutin" id="administrasi_rutin1" value="Ada">
                        <label class="form-check-label" for="administrasi_rutin1">
                            Tidak Ada
                        </label>
                    </div>
                    
                    <p>Upload Scan</p>
                    <input type="file" class="form-control-file" id="scan_struktur_organisasi">
                </div>

                <div class="document-group">

                    <div class="document_item buku_inventaris_kegiatan">

                        <h6>Buku Inventaris Kegiatan</h6>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="buku_inventaris_kegiatan" id="buku_inventaris_kegiatan" value="Tidak Ada" checked>
                            <label class="form-check-label" for="buku_inventaris_kegiatan">
                                Tidak Ada
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="buku_inventaris_kegiatan" id="buku_inventaris_kegiatan1" value="Ada">
                            <label class="form-check-label" for="buku_inventaris_kegiatan1">
                                Ada
                            </label>
                        </div>

                        <p>Upload Scan</p>

                        <input type="file" class="form-control-file" id="scan_struktur_organisasi">
                    </div>
                </div>

                <div class="document-group">

                    <div class="document_item biaya_operasional">

                        <h6>Biaya Operasional  KPP</h6>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="biaya_operasional" id="biaya_operasional" value="Tidak Ada" checked>
                            <label class="form-check-label" for="biaya_operasional">
                                Tidak Ada
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="biaya_operasional" id="biaya_operasional1" value="Ada">
                            <label class="form-check-label" for="biaya_operasional1">
                                Ada
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="anggota_miskin">Sumber Dana</label>
                        <input type="text" class="form-control" id="anggota_miskin">
                    </div>
                    <div class="form-group">
                        <label for="anggota_miskin">Nilai BOP</label>
                        <input type="text" class="form-control" id="anggota_miskin">
                    </div>
                </div>

                <div class="document-group">

                    <div class="document_item pengecekan_fisik">

                        <h6>Pengecekan Fisik</h6>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="struktur_organisasi" id="struktur_organisasi" value="Tidak Ada" checked>
                            <label class="form-check-label" for="struktur_organisasi">
                                Belum Dilakukan
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="struktur_organisasi" id="struktur_organisasi1" value="Ada">
                            <label class="form-check-label" for="struktur_organisasi1">
                                Sudah Dilakukan
                            </label>
                        </div>
                        <p>Upload Foto</p>
                        <input type="file" class="form-control-file" id="scan_struktur_organisasi">
                    </div>
                </div>

                <div class="document-group">

                    <div class="document_item kegiatan_pemeliharaan_fisik">

                        <h6>kegiatan_pemeliharaan_fisik</h6>

                    </div>
                    <div class="form-group">
                        <label for="anggota_miskin">Tanggal</label>
                        <input type="text" class="form-control" id="anggota_miskin">
                    </div>
                    <div class="form-group">
                        <label for="anggota_miskin">Sumber Dana</label>
                        <input type="text" class="form-control" id="anggota_miskin">
                    </div>
                    <div class="form-group">
                        <label for="anggota_miskin">Jumlah Dana</label>
                        <input type="text" class="form-control" id="anggota_miskin">
                    </div>

                    <p>Upload Scan</p>

                    <input type="file" class="form-control-file" id="scan_struktur_organisasi">
                </div>


                <div class="document-group">
                    <div class="document_item kegiatan_pemeliharaan_fisik">

                        <label for="exampleFormControlTextarea1">Keterangan Tambahan</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="7"></textarea>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="/home"><button type="button" class="btn btn-primary mt-5">Batal</button></a>
                <button type="submit" class="btn btn-primary mt-5">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/chainedDropDown.js') }}" defer></script>
@endsection
