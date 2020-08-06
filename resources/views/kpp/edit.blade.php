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
    <h3>UPDATE DATA KPP</h3>
    <form method="post" action="/kpp/{{$kppdata->id}}" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="data-group data-kpp">

            <div class="form-group">
                <label for="lokasi_bdi">
                    lokasi BDI/BPM
                </label>
                <input type="text" class="form-control" id="lokasi_bdi" name="lokasi_bdi" value="{{ $kppdata->lokasi_bdi_bpm }}">
            </div>
            <div class="form-group">
                <label for="nama_kpp">Nama KPP</label>
                <input type="text" class="form-control" id="nama_kpp" name="nama_kpp" value="{{ $kppdata->nama_kpp }}">
            </div>
            <div class="form-group">
                <label for="anggota_pria">Jumlah Anggota pria</label>
                <input type="text" class="form-control" id="anggota_pria" name="anggota_pria" value="{{ $kppdata->anggota_pria }}">
            </div>
            <div class="form-group">
                <label for="anggota_wanita">Jumlah Anggota wanita</label>
                <input type="text" class="form-control" id="anggota_wanita" name="anggota_wanita" value="{{ $kppdata->anggota_wanita }}">
            </div>
            <div class="form-group">
                <label for="anggota_miskin">Jumlah Anggota Miskin</label>
                <input type="text" class="form-control" id="anggota_miskin" name="anggota_miskin" value="{{ $kppdata->anggota_miskin }}">
            </div>
        </div>

        <div class="text-center">
            <a href="/kpp"><button type="button" class="btn btn-primary mt-5">Batal</button></a>
            <button type="submit" class="btn btn-primary mt-5">Simpan</button>
        </div>
    </form>
</div>
</div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
