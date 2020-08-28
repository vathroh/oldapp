<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#kegiatan_pemeliharaan_fisik_modal">
	Input
</button>

<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Tanggal Mulai</th>
      <th scope="col">Tanggal Selesai</th>
      <th scope="col">Sumber Dana</th>
      <th scope="col">Jumlah</th>
      <th scope="col">Foto Sebelum</th>
      <th scope="col">Foto Perbaikan</th>
      <th scope="col">Foto Setelah</th>
      <th scope="col">Edit</th>
    </tr>
  </thead>
  <tbody>
	  @foreach($infrastruktures_maintenances as $infrastruktures_maintenance)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $infrastruktures_maintenance->tanggal_mulai }}</td>
      <td>{{ $infrastruktures_maintenance->tanggal_selesai }}</td>
      <td>{{ $infrastruktures_maintenance->sumber_dana }}</td>
      <td>{{ $infrastruktures_maintenance->jumlah }}</td>
      <td><img src ="{{ asset('storage/kpp/' . $infrastruktures_maintenance->foto_sebelum_perbaikan) }}" style = "height:100px;"></td>
      <td><img src ="{{ asset('storage/kpp/' . $infrastruktures_maintenance->foto_perbaikan) }}" style = "height:100px;"></td>
      <td><img src ="{{ asset('storage/kpp/' . $infrastruktures_maintenance->foto_sesudah_perbaikan) }}" style = "height:100px;"></td>
      <td><a href="/kpp/kegiatan-pemeliharaan-fisik/{{ $infrastruktures_maintenance->id}}/edit" ><button class="btn btn-primary">Edit</button></a></td>

    </tr>
    @endforeach
  </tbody>
</table>




<!-- Modal -->
<div class="modal fade" id="kegiatan_pemeliharaan_fisik_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Kegiatan Perbaikan Infrastruktur</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form method="post" action="/kpp/kegiatan-pemeliharaan-fisik" enctype="multipart/form-data">
					@csrf
					<input type="text" id="kelurahan_id" name="kelurahan_id" value="{{$kppdata->kode_desa}}" style = "border:none; color:transparent" readonly>
					<div class="dates">
						<div class="form-group">
							<label for="tanggal_mulai_perbaikan">Tanggal Mulai</label>
							<input type="date" class="form-control" id="tanggal_mulai_perbaikan" name="tanggal_mulai_perbaikan" required>
						</div>
						<div class="form-group">
							<label for="tanggal_selesai_perbaikan">Tanggal Selesai</label>
							<input type="date" class="form-control" id="tanggal_selesai_perbaikan" name="tanggal_selesai_perbaikan">
						</div>
					</div>
					<div class="form-group">
						<label for="sumber_dana_perbaikan">Sumber Dana</label>
						<input type="text" class="form-control" id="sumber_dana_perbaikan" name="sumber_dana_perbaikan" required>
					</div>
					<div class="form-group">
						<label for="jumlah_dana">Jumlah Dana</label>
						<input type="text" class="nomer" id="jumlah_dana" name="jumlah_dana" required>
					</div>					
					<div class="form-group">
						<label for="foto_sebelum_perbaikan">Foto Sebelum Perbaikan</label>						
					</div>
					<input type="file" class="file-input" id="foto_sebelum_perbaikan" name="foto_sebelum_perbaikan" required>
					<div class="form-group">
						<label for="foto_perbaikan">Foto Perbaikan</label>						
					</div>
					<input type="file" class="file-input" id="foto_perbaikan" name="foto_perbaikan">
					<div class="form-group">
						<label for="foto_sesudah_perbaikan">Foto Sesudah Perbaikan</label>						
					</div>
					<input type="file" class="file-input" id="foto_sesudah_perbaikan" name="foto_sesudah_perbaikan">					
					<br>
					<button type="submit" class="btn btn-primary mt-5">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>
