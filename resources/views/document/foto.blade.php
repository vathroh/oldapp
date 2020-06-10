@extends('layouts.app')

@section('content')
<div class="row" style="height: 600px">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="row text-center">
                    <div class="col">
                        <a class="btn btn-primary" href="/doc">. F o t o .</a>
                        <a class="btn btn-primary" href="/table">.Dokumen.</a>
                        <a class="btn btn-primary" href="/rekapKab">.R e k a p.</a>
                        <br><br>
                        <a class="btn btn-primary" href="/create">Upload Dok BKM</a>
                        <a class="btn btn-primary" href="/ksm">Upload Dok KSM</a>
                        <a class="btn btn-primary" href="/foto">Upload Foto</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
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


                            <div class="row" id="lokasirtdantitik">
                                <div class="col">
                                   <div class="form-group">
                                    <label for="foto_ksm">
                                        <h4>Pilih KSM</h4>
                                    </label>
                                    <select name="foto_ksm" id="foto_ksm" class="form-control input-lg dynamic" required>
                                        <option value="0"></option>
                                    </select>
                                </div>

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
                                        <?php for ($i = 1; $i <= 20; $i++) { ?>
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
@endsection

@section('script')
<script src="{{ asset('js/chainedDropDownfoto.js') }}" defer></script>
@endsection