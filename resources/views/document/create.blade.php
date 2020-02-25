@extends('layouts.app')

@section('content')
<div class="row" style="height: 600px">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-primary" href="/doc">Lihat Data</a>
            </div>
            <div class="row">
                <div class="col">

                </div>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Kelurahan & BKM</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">KSM</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">FOTO</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <!-- Kelurahan dan BKM ===========================================++++++++++++++++++=========== -->
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row" style="margin-top: 50px">
                            <div class="col">
                                <form method="post" action="/doc" enctype="multipart/form-data">

                                    @csrf
                                    <div class="form-group">
                                        <label for="kabupaten">
                                            <h4>Tahun Kegiatan</h4>
                                        </label>
                                        <select name="tahunBKM" id="tahunBKM" class="form-control input-lg dynamic" required>
                                            <option value="">TAHUN</option>
                                            @foreach($tahun as $thn)
                                            <option value="{{$thn->tahun}}">{{$thn->tahun}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="kabupaten">
                                            <h4>Pilih Kabupaten</h4>
                                        </label>
                                        <select name="kabupaten" id="kabupaten" class="form-control input-lg dynamic" required>
                                            <option value="">KABUPATEN</option>
                                            @foreach($kabupaten as $kab)
                                            <option value="{{$kab->kode_kab}}">{{$kab->nama_kab}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="kelurahan">
                                            <h4>Pilih Kelurahan</h4>
                                        </label>
                                        <select name="kelurahan" id="kelurahan" class="form-control input-lg dynamic" required>
                                            <option value="">KELURAHAN</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="jenisDokumen">
                                            <h4>Pilih Dokumen</h4>
                                        </label>
                                        <select name="jenisDokumen" id="jenisDokumen" class="form-control input-lg dynamic" required>
                                            <option value="">PILIH DOKUMEN YANG AKAN DIUPLOAD</option>
                                            <option value="PRA DESAIN">PRA DESAIN</option>
                                            <option value="BERITA ACARA PEMAKETAN">BERITA ACARA PEMAKETAN</option>
                                            <option value="PEMBENTUKAN KPP">PEMBENTUKAN KPP</option>
                                            <option value="RENCANA KERJA KPP">RENCANA KERJA KPP</option>
                                            <option value="PENCAIRAN TAHAP 1">PENCAIRAN TAHAP 1</option>
                                            <option value="PENCAIRAN TAHAP 2">PENCAIRAN TAHAP 2</option>
                                            <option value="LPJ BKM">LPJ BKM</option>
                                        </select>
                                    </div>
                                    <div class="custom-file my-3">
                                        <input type="file" class="form-control" id="file" name="file" required>
                                    </div>
                                    <div class="text-center">
                                        <a href="/home"><button type="button" class="btn btn-primary mt-5">Batal</button></a>
                                        <button type="submit" class="btn btn-primary mt-5">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Kelurahan dan BKM ==========================================++++++++++++============ -->

                    <!-- KSM ====================================================================================== -->
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="row" style="margin-top: 50px">
                            <div class="col">
                                <form method="post" action="/ksm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="kabupaten">
                                            <h4>Tahun Kegiatan KSM</h4>
                                        </label>
                                        <select name="tahunKSM" id="tahunKSM" class="form-control input-lg dynamic" required>
                                            <option value="">TAHUN</option>
                                            @foreach($tahun as $thn)
                                            <option value="{{$thn->tahun}}">{{$thn->tahun}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="ksm_kabupaten">
                                            <h4>Pilih Kabupaten</h4>
                                        </label>
                                        <select name="ksm_kabupaten" id="ksm_kabupaten" class="form-control input-lg dynamic" required>
                                            <option value="">KABUPATEN</option>
                                            @foreach($kabupaten as $kab)
                                            <option value="{{$kab->kode_kab}}">{{$kab->nama_kab}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ksm_kelurahan">
                                            <h4>Pilih Kelurahan</h4>
                                        </label>
                                        <select name="ksm_kelurahan" id="ksm_kelurahan" class="form-control input-lg dynamic" required>
                                            <option value="">KELURAHAN</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ksm_ksm">
                                            <h4>Pilih KSM</h4>
                                        </label>
                                        <select name="ksm_ksm" id="ksm_ksm" class="form-control input-lg dynamic" required>
                                            <option value="0">KSM</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="jenisDokumen_ksm">
                                            <h4>Pilih Dokumen</h4>
                                        </label>
                                        <select name="jenisDokumen_ksm" id="jenisDokumen_ksm" class="form-control input-lg dynamic" required>
                                            <option value="">DOKUMEN YANG AKAN DIUPLOAD</option>
                                            <option value="1">DOKUMEN TEKNIS</option>
                                            <option value="2">RENCANA KERJA KSM</option>
                                            <option value="3">MP2K</option>
                                            <option value="4">OJT</option>
                                            <option value="5">PELATIHAN KSM</option>
                                            <option value="6">PENGADAAN</option>
                                            <option value="7">LPJ KSM</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label id="label_macamDokumen_ksm" for="macamDokumen_ksm">
                                            <h4>Pilih Dokumen</h4>
                                        </label>
                                        <select name="macamDokumen_ksm" id="macamDokumen_ksm" class="form-control input-lg dynamic" required>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="custom-file my-3">
                                        <input type="file" class="form-control" id="file_ksm" name="file_ksm" required>
                                    </div>
                                    <div class="text-center">
                                        <a href="/home"><button type="button" class="btn btn-primary mt-5">Batal</button></a>
                                        <button type="submit" class="btn btn-primary mt-5">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir KSM ================================================================================ -->

                    <!-- foto ===================================================================================== -->
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="row" style="margin-top: 50px">
                            <div class="col">
                                <form method="post" action="/foto" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="kabupaten">
                                            <h4>Tahun Kegiatan</h4>
                                        </label>
                                        <select name="tahunFOTO" id="tahunFOTO" class="form-control input-lg dynamic" required>
                                            <option value="">TAHUN</option>
                                            @foreach($tahun as $thn)
                                            <option value="{{$thn->tahun}}">{{$thn->tahun}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="jenisDokumenFoto">
                                            <h4>Pilih Dokumen</h4>
                                        </label>
                                        <select name="jenisDokumenFoto" id="jenisDokumenFoto" class="form-control input-lg dynamic" required>
                                            <option value="1">MP2K</option>
                                            <option value="2">PELATIHAN KSM</option>
                                            <option value="3">OJT</option>
                                            <option value="4">FOTO 0%</option>
                                            <option value="5">FOTO 25%</option>
                                            <option value="6">FOTO 50%</option>
                                            <option value="7">FOTO 75%</option>
                                            <option value="8">FOTO 100%</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto_kabupaten">
                                            <h4>Pilih Kabupaten</h4>
                                        </label>
                                        <select name="foto_kabupaten" id="foto_kabupaten" class="form-control input-lg dynamic" required>
                                            <option value=""></option>
                                            @foreach($kabupaten as $kab)
                                            <option value="{{$kab->kode_kab}}">{{$kab->nama_kab}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto_kelurahan">
                                            <h4>Pilih Kelurahan</h4>
                                        </label>
                                        <select name="foto_kelurahan" id="foto_kelurahan" class="form-control input-lg dynamic" required>
                                            <option value="0"></option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="foto_ksm">
                                            <h4>Pilih KSM</h4>
                                        </label>
                                        <select name="foto_ksm" id="foto_ksm" class="form-control input-lg dynamic" required>
                                            <option value="0"></option>
                                        </select>
                                    </div>

                                    <div class="row" id="lokasirtdantitik">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="foto_kegiatan">
                                                    <h4>Pilih KEGIATAN</h4>
                                                </label>
                                                <select name="foto_kegiatan" id="foto_kegiatan" class="form-control input-lg dynamic" required>
                                                    <option value="0"></option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="TitikFoto">
                                                    <h4>Pilih Titik Lokasi</h4>
                                                </label>
                                                <select name="TitikFoto" id="TitikFoto" class="form-control input-lg dynamic" required>
                                                    <option>Pilih Titik Lokasi</option>
                                                    <?php for ($i = 1; $i <= 10; $i++) { ?>
                                                        <option value="Titik <?php echo $i; ?>">Titik <?php echo $i; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="custom-file my-3">
                                        <input type="file" class="form-control" id="file_foto" name="file_foto" required>
                                    </div>
                                    <div class="text-center">
                                        <a href="/home"><button type="button" class="btn btn-primary mt-5">Batal</button></a>
                                        <button type="submit" class="btn btn-primary mt-5">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection