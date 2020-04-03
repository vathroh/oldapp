@extends('layouts.app')

@section('content')

<h3 class="text-center my-5">{{$kegiatan[0]['NAMA_KAB']}} Tahun 2019</h3>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">FOTO 0%</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">FOTO 25%</a>
        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">FOTO 50%</a>
        <a class="nav-item nav-link" id="nav-75-tab" data-toggle="tab" href="#nav-75" role="tab" aria-controls="nav-75" aria-selected="false">FOTO 75%</a>
        <a class="nav-item nav-link" id="nav-100-tab" data-toggle="tab" href="#nav-100" role="tab" aria-controls="nav-75" aria-selected="false">FOTO 100%</a> </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <table class="table table-striped table-dark table-bordered mt-3">
            <thead>
                <tr class="text-center">
                    <th rowspan="2">NO</th>
                    <th rowspan="2">KABUPATEN</th>
                    <th rowspan="2">KELURAHAN</th>
                    <th rowspan="2">KSM</th>
                    <th rowspan="2">KEGIATAN</th>
                    <th rowspan="2">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatan->where('FOTO_0', 0) as $keg)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$keg->NAMA_KAB}}</td>
                    <td>{{$keg->NAMA_DESA}}</td>
                    <td>{{$keg->KSM}}</td>
                    <td>{{$keg->KEGIATAN}}</td>
                    <td><button type="submit" class="btn btn-primary">UPLOAD</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <table class="table table-striped table-dark table-bordered mt-3">
            <thead>
                <tr class="text-center">
                    <th rowspan="2">NO</th>
                    <th rowspan="2">KABUPATEN</th>
                    <th rowspan="2">KELURAHAN</th>
                    <th rowspan="2">KSM</th>
                    <th rowspan="2">KEGIATAN</th>
                    <th rowspan="2">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatan->where('FOTO_25', 0) as $keg)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$keg->NAMA_KAB}}</td>
                    <td>{{$keg->NAMA_DESA}}</td>
                    <td>{{$keg->KSM}}</td>
                    <td>{{$keg->KEGIATAN}}</td>
                    <td><button type="submit" class="btn btn-primary">UPLOAD</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
        <table class="table table-striped table-dark table-bordered mt-3">
            <thead>
                <tr class="text-center">
                    <th rowspan="2">NO</th>
                    <th rowspan="2">KABUPATEN</th>
                    <th rowspan="2">KELURAHAN</th>
                    <th rowspan="2">KSM</th>
                    <th rowspan="2">KEGIATAN</th>
                    <th rowspan="2">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatan->where('FOTO_50', 0) as $keg)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$keg->NAMA_KAB}}</td>
                    <td>{{$keg->NAMA_DESA}}</td>
                    <td>{{$keg->KSM}}</td>
                    <td>{{$keg->KEGIATAN}}</td>
                    <td><button type="submit" class="btn btn-primary">UPLOAD</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="nav-75" role="tabpanel" aria-labelledby="nav-75-tab">
        <table class="table table-striped table-dark table-bordered mt-3">
            <thead>
                <tr class="text-center">
                    <th rowspan="2">NO</th>
                    <th rowspan="2">KABUPATEN</th>
                    <th rowspan="2">KELURAHAN</th>
                    <th rowspan="2">KSM</th>
                    <th rowspan="2">KEGIATAN</th>
                    <th rowspan="2">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatan->where('FOTO_75', 0) as $keg)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$keg->NAMA_KAB}}</td>
                    <td>{{$keg->NAMA_DESA}}</td>
                    <td>{{$keg->KSM}}</td>
                    <td>{{$keg->KEGIATAN}}</td>
                    <td><button type="submit" class="btn btn-primary">UPLOAD</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="nav-100" role="tabpanel" aria-labelledby="nav-100-tab">
        <table class="table table-striped table-dark table-bordered mt-3">
            <thead>
                <tr class="text-center">
                    <th rowspan="2">NO</th>
                    <th rowspan="2">KABUPATEN</th>
                    <th rowspan="2">KELURAHAN</th>
                    <th rowspan="2">KSM</th>
                    <th rowspan="2">KEGIATAN</th>
                    <th rowspan="2">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatan->where('FOTO_100', 0) as $keg)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$keg->NAMA_KAB}}</td>
                    <td>{{$keg->NAMA_DESA}}</td>
                    <td>{{$keg->KSM}}</td>
                    <td>{{$keg->KEGIATAN}}</td>
                    <td><button type="submit" class="btn btn-primary">UPLOAD</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection