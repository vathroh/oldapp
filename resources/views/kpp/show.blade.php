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
    @if(Auth::user()->job_desc)
    <h3>PROFIL KPP {{ $kppdata->nama_kpp }}</h3>
    <div class="data-group data-lokasi">
        <div class="data-group-title">
            ALAMAT
        </div>
        <div class="form-group">
            <label for="kelurahan">
                DESA/KELURAHAN 
            </label>
            <input type="text" name="nama_kelurahan" id="nama_kelurahan" value="{{$kelurahan->NAMA_DESA}}" readonly>
        </div>
        <div class="form-group">
            <label for="kecamatan">       
                KECAMATAN
            </label>                
            <input type="text" name="nama_kecamatan" id="nama_kecamatan" value="{{$kelurahan->NAMA_KEC}}" readonly="">
        </div>
        <div class="form-group">
            <label for="kabupaten">       
                KABUPATEN/KOTA
            </label>
            <input type="text" name="nama_kabupaten" id="nama_kabupaten" value="{{$kelurahan->NAMA_KAB}}" readonly>
        </div>      
        <div class="form-group">
            <label for="lokasi_bdi">
                LOKASI BDI/BPM
            </label>
            <input type="text" id="lokasi_bdi" name="lokasi_bdi" value="{{ $kppdata->lokasi_bdi_bpm }}" readonly>
        </div>

        <div class="form-group">
            <label>JUMLAH ANGGOTA</label>
            <div class="data-group-isi justify-content-between">
                <div class="data-group-label1">
                    PRIA
                </div>
                <div class="data-group-isi1">
                    {{ $kppdata->anggota_pria }} 
                </div>
                <div class="data-group-label1">
                    WANITA
                </div>
                <div class="data-group-isi1">
                    {{ $kppdata->anggota_wanita }}
                </div>
                <div class="data-group-label1">
                    MISKIN
                </div>
                <div class="data-group-isi1">
                    {{ $kppdata->anggota_miskin }}
                </div>                    
            </div>
        </div>
        <div class="nav">
            <a href="/kpp/{{$kppdata->id}}/edit"><button type="button" class="btn btn-primary">Edit</button></a>
        </div>
    </div>
    <div class="data-group kepengurusan">
        <div class="data-group-title">
            KEPENGURUSAN
        </div>

        <div class="document-group">
            @include('kpp.show.pengurus')
        </div>        
    </div>

    <div class="data-group document">
        <div class="data-group-title">
            DOKUMEN DAN ADMINISTRASI
        </div>

        <div class="document-group">
            @include('kpp.show.struktur_organisasi')
        </div>

        <div class="document-group">
            <h6>Pengesahan/Dasar Lembaga KPP</h6>
            @include('kpp.show.anggaran_dasar')
            @include('kpp.show.anggaran_rumah_tangga')
            @include('kpp.show.surat_keputusan')
        </div>

        <div class="document-group">
            @include('kpp.show.rencana_kerja')
        </div>

        <div class="document-group">
            @include('kpp.show.administrasi_rutin')
        </div>

        <div class="document-group">
            @include('kpp.show.buku_inventaris_kegiatan')
        </div>

    </div>

    <div class="data-group pertemuan_rutin">
        <div class="data-group-title">
            PERTEMUAN RUTIN
        </div>
        <div class="document-group">
            @include('kpp.show.pertemuan_rutin')
        </div>
    </div>

    <div class="data-group pertemuan_rutin">
        <div class="data-group-title">
            BIAYA OPERASIONAL
        </div>

        <div class="document-group">
            @include('kpp.show.biaya_operasional')
        </div>
    </div>


    <div class="data-group pengecekan_fisik">
        <div class="data-group-title">
            PENGECEKAN FISIK
        </div>

        <div class="document-group">
            @include('kpp.show.pengecekan_fisik')
        </div>
    </div>

    <div class="data-group kegiatan_pemeliharaan_fisik">
        <div class="data-group-title">
            KEGIATAN PERBAIKAN INFRASTRUKTUR
        </div>
        <div class="document-group">
            @include('kpp.show.kegiatan_pemeliharaan_fisik')
        </div>
    </div>

    <div class="data-group keterangan_tambahan">
        <div class="data-group-title">
            KETERANGAN
        </div>
        <div class="document-group">
            @include('kpp.show.keterangan_tambahan')
        </div>
    </div>
    @endif
</div>


</div>
</div>


<script src="{{ asset('js/cleave.js') }}"></script>
<script>


    var cleave = new Cleave('.halo', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });

    var cleave = new Cleave('.halo1', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });

    var cleave = new Cleave('.nomer', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });

    var cleave = new Cleave('.nomer1', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });




</script>

@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>

@endsection
