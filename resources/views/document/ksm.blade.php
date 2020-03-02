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
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/chainedDropDownksm.js') }}" defer></script>
@endsection