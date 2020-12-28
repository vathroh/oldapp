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
    <h3>EDIT DATA KEGIATAN PEMELIHARAAN FISIK</h3>
    <form method="post" action="/kpp/kegiatan-pemeliharaan-fisik/{{ $infrastruktures_maintenance->id }}" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="data-group data-kpp">

            <div class="form-group">
                <label for="tanggal_mulai">
                    TANGGAL MULAI
                </label>
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ $infrastruktures_maintenance->tanggal_mulai }}">
            </div>
            <div class="form-group">
                <label for="tanggal_selesai">TANGGAL SELESAI</label>
                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ $infrastruktures_maintenance->tanggal_selesai }}">
            </div>
            <div class="form-group">
                <label for="sumber_dana">SUMBER DANA</label>
                <input type="text" class="form-control" id="sumber_dana" name="sumber_dana" value="{{ $infrastruktures_maintenance->sumber_dana }}">
            </div>
            <div class="form-group">
                <label for="jumlah_dana">JUMLAH</label>
                <input type="text" class="form-control" id="jumlah_dana" name="jumlah_dana" value="{{ $infrastruktures_maintenance->jumlah }}">
            </div>

            <div class = "image-wrapper">
                <div class = "form-image text-center">
                    <p>FOTO SEBELUM PERBAIKAN</p>
                    <img src="{{ asset('/storage/kpp/' . $infrastruktures_maintenance->foto_sebelum_perbaikan) }}">
                    <p>Ganti Foto?</p>
                    <input type="file" class="file-input" id="foto_sebelum_perbaikan" name="foto_sebelum_perbaikan">
                </div>
                <div class = "form-image text-center">
                    <p>FOTO PERBAIKAN</p>
                    <img src="{{ asset('/storage/kpp/' . $infrastruktures_maintenance->foto_perbaikan) }}">
                    <p>Ganti Foto?</p>
                    <input type="file" class="file-input" id="foto_perbaikan" name="foto_perbaikan">
                </div>
                <div class = "form-image text-center">
                    <p>FOTO SETELAH PERBAIKAN</p>
                    <img src="{{ asset('/storage/kpp/' . $infrastruktures_maintenance->foto_sesudah_perbaikan) }}">
                    <p>Ganti Foto?</p>
                    <input type="file" class="file-input" id="foto_sesudah_perbaikan" name="foto_sesudah_perbaikan">
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


