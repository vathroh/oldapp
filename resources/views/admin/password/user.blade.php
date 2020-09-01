@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Ganti Password</h4>
		<p class="card-category"></p>
	</div>
	<div class="card-body">
        <form method="post" action="{{'/pass-by-user/' . Auth::user()->id }}" enctype="multipart/form-data">
        @method('put')
        @csrf
            <div class="form-group row my-5">
                <label for="password" class="col-md-4 text-md-right">Masukkan Password Baru</label>
                <div class="col-md-6">
					<input id="change_password" type="password" class="form-control" name="change_password">
                </div>
            </div>
            <div class="text-center">
				<a href = "/home"><button type="submit" class="btn btn-primary">Batal</button></a>
				<button type="submit" class="btn btn-primary">Ganti Password</button>
            </div>
    </form>
</div>


@endsection
