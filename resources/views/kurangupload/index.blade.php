@extends('layouts.app')

@section('content')
<form method="post" action="/kurangupload" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-5">
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="tahun">
                            <h4>Tahun Kegiatan</h4>
                        </label>
                    </div>
                    <div class="col">
                        <select name="tahun" id="tahun" class="form-control input-lg dynamic" required>
                            <option value="">TAHUN</option>
                            @foreach($tahun as $thn)
                            <option value="{{$thn->tahun}}">{{$thn->tahun}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="kabupaten">
                            <h4>Kabupaten</h4>
                        </label>
                    </div>
                    <div class="col">
                        <select name="kabupaten" id="kabupaten" class="form-control input-lg dynamic">
                            <option value=""></option>
                            @foreach($kabupaten as $kab)
                            <option value="{{$kab->kode_kab}}">{{$kab->nama_kab}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1">
            <div class="text-center">
                <button type="submit" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
</form>

<table class="table table-striped table-dark table-bordered mt-3">
    <thead>
        <tr class="text-center">
            <th scope="col">MP2K</th>
            <th scope="col">OJT</th>
            <th scope="col">PELATIHAN KSM</th>
            <th scope="col">0%</th>
            <th scope="col">25%</th>
            <th scope="col">50%</th>
            <th scope="col">75%</th>
            <th scope="col">100%</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


@endsection