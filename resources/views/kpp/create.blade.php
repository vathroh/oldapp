@extends('layouts.MaterialDashboard')

@section('content')
@php
$nama_desa=$kelurahan[0]->where('KD_KEL',$request->kelurahan)->get()[0]['NAMA_DESA'];
$nama_kecamatan = $kelurahan[0]->where('KD_KEL',$request->kelurahan)->get()[0]['NAMA_KEC'];
$nama_kabupaten = $kelurahan[0]->where('KD_KEL',$request->kelurahan)->get()[0]['NAMA_KAB'];
$nama_bkm=$bkmdatas[0]->where('kelurahan_id', $request->kelurahan)->get()[0]['bkm'];
@endphp

<form method="post" action="/kpp" enctype="multipart/form-data">
    @csrf
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">KPP</h4>
        <p class="card-category">INPUT/UPDATE DATA KPP DESA/KELURAHAN : <span id="nama_kelurahan" name="nama_kelurahan">{{ $nama_desa }}</span> KECAMATAN : <span id="kecamatan" name="kecamatan">{{ $nama_kecamatan }}</span> KABUPATEN/KOTA : <span id="kabupaten" name="kabupaten">{{ $nama_kabupaten }}</span> </p>
    </div>
    <div class="card-body">

        <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ $request->kelurahan }}" style="color: transparent; border: none" readonly>

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
    </div>
</div>
</div>
</div>
</form>

@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
