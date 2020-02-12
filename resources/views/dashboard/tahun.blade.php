@extends('layouts.app')
@section('content')
<div class="section">
    <div class="row">
        <div class="col-4">
            <form action="/inputyear" method="post">
                @csrf
                <div class="form-group">
                    <label for="Tahun">Tahun</label>
                    <input type="text" class="form-control" id="tahun" name="tahun">
                </div>
                <div class="form-group">
                    <label for="namablm">Nama BLM</label>
                    <input type="text" class="form-control" id="namablm" name="namablm">
                </div>
                <a href="/dashboard"> <button type="button" class="btn btn-primary">Batal</button></a>
                <button type="submit" class="btn btn-primary">Input</button>
            </form>
        </div>
    </div>
</div>
@endsection