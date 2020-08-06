@extends('layouts.master1')

@section('head')
<link href="{{ asset('css/kpp/style1.css') }}" rel="stylesheet">
    
@endsection

@section('content')


<div class="wrapper">

    <div class="mainbar">

        <h3>DATA KPP OSP-1 JAWA TENGAH</h3>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Input Data
      </button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Edit Data
      </button>

      <table class="table table-hover table-bordered">
        <thead>
            <tr class="text-center">
                <th rowspan="2">#</th>
                <th rowspan="2">KABUPATEN/KOTA</th>
                <th rowspan="2">KECAMATAN</th>
                <th rowspan="2">KELURAHAN/DESA</th>
                <th rowspan="2">NAMA BKM</th>
                <th rowspan="2">LOKASI BDI/BPM</th>
                <th rowspan="2">KODE KPP</th>
                <th rowspan="2">NAMA KPP</th>
                <th colspan="3">JUMLAH ANGGOTA</th>
                <th rowspan="2">STRUKTUR ORGANISASI</th>
                <th colspan="3">DASAR LEMBAGA</th>
                <th rowspan="2">RENCANA KERJA</th>
                <th rowspan="2">PERTEMUAN RUTIN</th>
                <th rowspan="2">ADMINISTRASI RUTIN</th>
                <th rowspan="2">BUKU ADMINISTRASI KEGIATAN</th>
                <th colspan="2">BOP</th>
                <th rowspan="2">PENGECEKAN FISIK</th>
                <th colspan="3">KEGIATAN PEMELIHARAAN</th>
                <th rowspan="2">KETERANGAN</th>
                <th rowspan="2">DIUPLOAD OLEH</th>
                <th rowspan="2">EDIT / DELETE</th>
            </tr>
            <tr class="text-center">
                <th scope="row">PRIA</th>
                <th scope="row">WANITA</th>
                <th scope="row">MISKIN</th>
                <th scope="row">AD</th>
                <th scope="row">ART</th>
                <th scope="row">SK</th>
                <th scope="row">SUMBER DANA</th>
                <th scope="row">JUMLAH</th>
                <th scope="row">TANGGAL</th>
                <th scope="row">SUMBER DANA</th>
                <th scope="row">JUMLAH DANA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kppdatas as $kppdata)

            @php
            $nama_desa=$kelurahan[0]->where('KD_KEL',$kppdata->kode_desa)->get()[0]['NAMA_DESA'];
            $nama_kecamatan = $kelurahan[0]->where('KD_KEL',$kppdata->kode_desa)->get()[0]['NAMA_KEC'];
            $nama_kabupaten = $kelurahan[0]->where('KD_KEL',$kppdata->kode_desa)->get()[0]['NAMA_KAB'];
            $uploader=$user[0]->where('id', $kppdata->user_id)->get()[0]['name'];
            @endphp

            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $nama_kabupaten }}</td>
                <td>{{ $nama_kecamatan }}</td>
                <td>{{ $nama_desa }}</td>
                <td></td>
                <td>{{ $kppdata->lokasi_bdi_bpm }}</td>
                <td></td>
                <td>{{ $kppdata->nama_kpp }}</td>
                <td>{{ $kppdata->lokasi_bdi_bpm }}</td>
                <td>{{ $kppdata->anggota_pria }} Orang</td>
                <td>{{ $kppdata->anggota_wanita }} Orang</td>
                <td>{{ $kppdata->anggota_miskin }} Orang</td>
                <td>{{ $kppdata->struktur_organisasi }}</td>
                <td>{{ $kppdata->anggaran_dasar }}</td>
                <td>{{ $kppdata->anggaran_rumah_tangga }}</td>
                <td>{{ $kppdata->surat_keputusan }}</td>
                <td>{{ $kppdata->rencana_kerja }}</td>
                <td>{{ $kppdata->pertemuan_rutin }}</td>
                <td>{{ $kppdata->buku_inventaris_kegiatan }}</td>
                <td>{{ $kppdata->sumber_dana_operasional }}</td>
                <td>{{ $kppdata->nilai_bop }}</td>
                <td>{{ $kppdata->kegiatan_pengecekan }}</td>
                <td>{{ $kppdata->tanggal_kegiatan_perbaikan }}</td>
                <td>{{ $kppdata->sumber_dana_perbaikan }}</td>
                <td>{{ $kppdata->nilai_perbaikan }}</td>
                <td>{{ $kppdata->keterangan_lain_lain }}</td>
                <td>{{ $uploader }}</td>
                <td><button type="button" class="btn btn-primary">Edit</button><button type="button" class="btn btn-danger">Delete</button></td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Data KPP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <form method="get" action="/kpp/create" enctype="multipart/form-data">

                    @csrf

                    <div class="data-group data-lokasi">
                        <div class="form-group">
                            <label for="kabupaten">
                                Kabupaten
                            </label>
                            <select name="kabupaten" id="kabupaten" class="form-control input-lg dynamic" required>
                                <option value="">Kabupaten</option>
                                @foreach($kabupaten as $kab)
                                <option value="{{$kab->kode_kab}}">{{$kab->nama_kab}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-control input-lg dynamic" required>
                                <option value="">Kecamatan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelurahan">
                                Kelurahan
                            </label>
                            <select name="kelurahan" id="kelurahan" class="form-control input-lg dynamic" required>
                                <option value="">Kelurahan</option>
                            </select>
                        </div>                
                    </div>


                    <div class="text-center">

                        <button type="button" class="btn btn-primary mt-5" data-dismiss="modal" aria-label="Close">Batal</button>
                        <button type="submit" class="btn btn-primary mt-5">Submit</button>
                    </div>
                </form>


            </div>

        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/kpp/chaineddropdown.js') }}" defer></script>
@endsection
