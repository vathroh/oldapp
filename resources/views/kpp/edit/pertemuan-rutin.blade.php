@extends('layouts.MaterialDashboard')

@section('head')
<link href="{{ asset('css/kpp/style.css') }}" rel="stylesheet">
@endsection

@section('content')


<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title ">KPP</h4>
    <p class="card-category"></p>
</div>
<div class="card-body">
    <h3>EDIT DATA PERTEMUAN</h3>
    <form method="post" action="/kpp/data-pertemuan/{{ $kpp_pertemuan->id }}" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="data-group data-kpp">

            <div class="form-group">
                <label for="tanggal">
                    TANGGAL PERTEMUAN
                </label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $kpp_pertemuan->tanggal }}">
            </div>
            <div class="form-group">
                <label for="pokok_bahasan">POKOK BAHASAN</label>
                <input type="text" class="form-control" id="pokok_bahasan" name="pokok_bahasan" value="{{ $kpp_pertemuan->pokok_bahasan }}">
            </div>
            <div class="form-group">
                <label for="keterangan">KETERANGAN</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows ="3">{{ $kpp_pertemuan->keterangan }}</textarea>
            </div>
            <div class = "image-wrapper">
                <div class = "form-image text-center">
                    <p>FOTO SETELAH PERBAIKAN</p>
                    <img src="{{ asset('/storage/kpp/' . $kpp_pertemuan->foto) }}">
                    <p>Ganti Foto?</p>
                    <input type="file" class="file-input" id="foto_pertemuan" name="foto_pertemuan">
                </div>
            </div>
        </div>
        <div class="text-center">
            <a href="/kpp/"><button type="button" class="btn btn-primary mt-5">Batal</button></a>
            <button type="submit" class="btn btn-primary mt-5">Simpan</button>
        </div>
    </form>
</div>
</div>
</div>

@endsection


