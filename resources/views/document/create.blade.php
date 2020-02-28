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
                        <a class="btn btn-primary" href="/rekap">.R e k a p.</a>
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
        </div>
    </div>
</div>



@endsection