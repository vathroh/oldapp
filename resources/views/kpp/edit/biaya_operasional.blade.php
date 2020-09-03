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
    <h3>EDIT DATA BOP KPP</h3>
    <form method="post" action="/kpp/data-bop/{{$bop->id}}" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="data-group data-kpp">
            <div class="form-group">
                <label for="tanggal">
                    TANGGAL PENERIMAAN
                </label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{$bop->tanggal}}">
            </div>
            <div class="form-group">
                <label for="sumber_dana">SUMBER DANA</label>
                <input type="text" class="form-control" id="sumber_dana" name="sumber_dana" value="{{ $bop->sumber_dana }}">
            </div>
            <div class="form-group">
                <label for="jumlah_dana">JUMLAH</label>
                <input type="text" class="form-control" id="jumlah_dana" name="jumlah_dana" value="{{ $bop->jumlah }}">
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


