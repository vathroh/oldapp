
<div class="form-group">
	<label for="sumber_dana">Tanggal</label>
	<input type="text" class="form-control" id="sumber_dana" name="sumber_dana" value="{{$kppdata->tanggal_kegiatan_perbaikan}}" readonly>
</div>
<div class="form-group">
	<label for="nilai_bop">Sumber Dana</label>
	<input type="text" class="form-control" id="nilai_bop" name="nilai_bop" value="{{$kppdata->sumber_dana_perbaikan}}" readonly>
</div>
<div class="form-group">
	<label for="nilai_bop">Jumlah Dana</label>
	<input type="text" class="halo" id="nilai_perbaikan" name="nilai_perbaikan" value="{{$kppdata->nilai_perbaikan}}" readonly>
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#kegiatan_pemeliharaan_fisik_modal">
	Edit
</button>




<!-- Modal -->
<div class="modal fade" id="kegiatan_pemeliharaan_fisik_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Biaya Perbaikan Infrastruktur</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form method="post" action="/kpp/kegiatan-pemeliharaan-fisik/{{$kppdata->id}}" enctype="multipart/form-data">
					@method('patch')
					@csrf
					<div class="dates">
						<div class="form-group">

							<label for="sumber_dana">Tanggal</label>
							<input type="date" class="form-control" id="usr1" name="tanggal_kegiatan_perbaikan" value="{{$kppdata->tanggal_kegiatan_perbaikan}}" >
						</div>
					</div>
					<div class="form-group">
						<label for="nilai_bop">Sumber Dana</label>
						<input type="text" class="form-control" id="sumber_dana_perbaikan" name="sumber_dana_perbaikan" value="{{$kppdata->sumber_dana_perbaikan}}" >
					</div>
					<div class="form-group">
						<label for="nilai_bop">Jumlah Dana</label>
						<input type="text" class="nomer" id="nilai_perbaikan" name="nilai_perbaikan" value="{{$kppdata->nilai_perbaikan}}">
					</div>
					<br>
					<button type="submit" class="btn btn-primary mt-5">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>