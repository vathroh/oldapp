@extends('layouts.MaterialDashboard')

@section('content')
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
@endsection

@section('script')
<script src="{{ asset('js/kpp/chaineddropdown.js') }}" defer></script>
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
