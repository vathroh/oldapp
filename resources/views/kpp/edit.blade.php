@extends('layouts.master1')

@section('head')
<link href="{{ asset('css/kpp/style.css') }}" rel="stylesheet">
@endsection

@section('content')


<div class="wrapper">

    <div class="mainbar">

        <h3>UPDATE DATA KPP</h3>




        <form method="post" action="/kpp/{{$kppdata->id}}" enctype="multipart/form-data">
            @method('patch')
            @csrf

            <div class="data-group data-lokasi">
                <div class="form-group">
                    <label for="kabupaten">
                        Kabupaten
                    </label>
                    <input type="text" class="form-control" id="kabupaten" name="kabupaten" value="{{ $kelurahan[0]->NAMA_KAB }}" readonly>
                    
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ $kelurahan[0]->NAMA_KEC }}" readonly>
                </div>
                <div class="form-group">
                    <label for="nama_kelurahan">
                        Kelurahan
                    </label>
                    <input type="text" class="form-control" id="nama_kelurahan" name="nama_kelurahan" value="{{ $kelurahan[0]->NAMA_DESA }}" readonly>
                </div>
                <div class="form-group">
                    <label for="nama_BKM">
                        Nama BKM
                    </label>
                    <input type="text" class="form-control" id="nama_BKM" name="nama_BKM" value="{{ $bkmdata[0]->bkm }}" readonly>
                </div>
            </div>


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

@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
