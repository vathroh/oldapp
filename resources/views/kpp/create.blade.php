@extends('layouts.master1')

@section('head')
<link href="{{ asset('css/kpp/style.css') }}" rel="stylesheet">
@endsection

@section('content')


<div class="wrapper">

    <div class="mainbar">

        <h3>UPDATE DATA KPP</h3>

        $uploader=$user[0]->where('id', $kppdata->user_id)->get()[0]['name'];

        @php
        $nama_desa=$kelurahan[0]->where('KD_KEL',$request->kelurahan)->get()[0]['NAMA_DESA'];
        $nama_kecamatan = $kelurahan[0]->where('KD_KEL',$request->kelurahan)->get()[0]['NAMA_KEC'];
        $nama_kabupaten = $kelurahan[0]->where('KD_KEL',$request->kelurahan)->get()[0]['NAMA_KAB'];
        $nama_bkm=$bkmdatas[0]->where('kelurahan_id', $request->kelurahan)->get()[0]['bkm'];
        @endphp


        <form method="post" action="/kpp" enctype="multipart/form-data">

            @csrf

            <div class="data-group data-lokasi">
                <div class="form-group">
                    <label for="kabupaten">
                        Kabupaten
                    </label>
                    <input type="text" class="form-control" id="kabupaten" name="kabupaten" value="{{ $nama_kabupaten }}">
                    
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ $nama_kecamatan }}">
                </div>
                    <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ $request->kelurahan }}">
                <div class="form-group">
                    <label for="nama_kelurahan">
                        Kelurahan
                    </label>
                    <input type="text" class="form-control" id="nama_kelurahan" name="nama_kelurahan" value="{{ $nama_desa }}">
                </div>
                <div class="form-group">
                    <label for="nama_BKM">
                        Nama BKM
                    </label>
                    <input type="text" class="form-control" id="nama_BKM" name="nama_BKM" value="{{ $nama_bkm }}">
                </div>
            </div>


            <div class="data-group data-kpp">

                <div class="form-group">
                    <label for="lokasi_bdi">
                        lokasi BDI/BPM
                    </label>
                    <input type="text" class="form-control" id="lokasi_bdi" name="lokasi_bdi">
                </div>
                <div class="form-group">
                    <label for="nama_kpp">Nama KPP</label>
                    <input type="text" class="form-control" id="nama_kpp" name="nama_kpp">
                </div>
                <div class="form-group">
                    <label for="anggota_pria">Jumlah Anggota pria</label>
                    <input type="text" class="form-control" id="anggota_pria" name="anggota_pria">
                </div>
                <div class="form-group">
                    <label for="anggota_wanita">Jumlah Anggota wanita</label>
                    <input type="text" class="form-control" id="anggota_wanita" name="anggota_wanita">
                </div>
                <div class="form-group">
                    <label for="anggota_miskin">Jumlah Anggota Miskin</label>
                    <input type="text" class="form-control" id="anggota_miskin" name="anggota_miskin">
                </div>
            </div>

            <div class="text-center">
                <a href="/kpp"><button type="button" class="btn btn-primary mt-5">Batal</button></a>
                <button type="submit" class="btn btn-primary mt-5">Selanjutnya</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
