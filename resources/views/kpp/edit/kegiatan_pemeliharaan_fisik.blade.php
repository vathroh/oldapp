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
    <form method="post" action="/kpp/" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="data-group data-kpp">

            <div class="form-group">
                <label for="lokasi_bdi">
                    TANGGAL MULAI
                </label>
                <input type="date" class="form-control" id="lokasi_bdi" name="lokasi_bdi" value="{{ $infrastruktures_maintenance->tanggal_mulai }}">
            </div>
            <div class="form-group">
                <label for="nama_kpp">TANGGAL SELESAI</label>
                <input type="date" class="form-control" id="nama_kpp" name="nama_kpp" value="{{ $infrastruktures_maintenance->tanggal_selesai }}">
            </div>
            <div class="form-group">
                <label for="anggota_pria">SUMBER DANA</label>
                <input type="text" class="form-control" id="anggota_pria" name="anggota_pria" value="{{ $infrastruktures_maintenance->sumber_dana }}">
            </div>
            <div class="form-group">
                <label for="anggota_wanita">JUMLAH</label>
                <input type="text" class="form-control" id="anggota_wanita" name="anggota_wanita" value="{{ $infrastruktures_maintenance->jumlah }}">
            </div>
            <div class="form-group">
                <label for="anggota_miskin">FOTO SEBELUM PERBAIKAN</label>               
            </div>
                <input type="file" class="file-input" id="foto_sebelum_perbaikan" name="foto_sebelum_perbaikan" value="{{ $infrastruktures_maintenance->foto_sebelum_perbaikan }}">
            <div class="form-group">
                <label for="anggota_miskin">FOTO SEBELUM PERBAIKAN</label>               
            </div>
                <input type="file" class="file-input" id="foto_sebelum_perbaikan" name="foto_sebelum_perbaikan" required>
            <div class="form-group">
                <label for="anggota_miskin">FOTO SEBELUM PERBAIKAN</label>               
            </div>
                <input type="file" class="file-input" id="foto_sebelum_perbaikan" name="foto_sebelum_perbaikan" required>
            
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


