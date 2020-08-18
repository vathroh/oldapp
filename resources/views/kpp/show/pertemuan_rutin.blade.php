<div class="form-group">

    <label>       
      Frekwensi Pertemuan Rutin
    </label>

    <div class="data-group-isi">
        <div class="input">
          <input type="text" id="pertemuan_rutin" name="pertemuan_rutin" value="{{ $kppdata->pertemuan_rutin }}" readonly>
        </div>
    
        <div class="button">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pertemuan_rutin_modal">
            Edit
          </button>
        </div>
    </div>
</div>

<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th scope="col">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input_pertemuan_rutin_modal">
            Input
          </button>
        </th>
      <th scope="col">Tanggal</th>
      <th scope="col">Pokok Bahasan</th>
      <th scope="col">Keterangan</th>
      <th scope="col">Foto</th>
    </tr>
  </thead>
  <tbody>
	  @foreach($kpp_pertemuans as $pertemuan)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td>{{$pertemuan->tanggal}}</td>
      <td>{{$pertemuan->pokok_bahasan}}</td>
      <td>{{$pertemuan->keterangan}}</td>
      <td><img src = "{{ asset('storage/kpp/'. $pertemuan->foto )}}" style = "height:100px;"></td>
    </tr>
    @endforeach
  </tbody>
</table>



<!-- Modal -->
<div class="modal fade" id="pertemuan_rutin_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pertemuan Rutin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" action="/kpp/pertemuan-rutin/{{$kppdata->id}}" enctype="multipart/form-data">
          @method('patch')
          @csrf
          <div class="form-group">
            <label for="pertemuan_rutin">
              Sesering apakah mengadakan Pertemuan Rutin?
            </label>
            <select name="pertemuan_rutin" id="pertemuan_rutin" class="form-control input-lg dynamic">
              <option value="{{$kppdata->pertemuan_rutin}}">{{$kppdata->pertemuan_rutin}}</option>
              <option value="Setiap Bulan">Setiap Bulan</option>
              <option value="Setiap Tiga Bulan">Setiap Tiga Bulan</option>
              <option value="Setiap Enam Bulan">Setiap Enam Bulan</option>
              <option value="Insidentil (sesuai kebutuhan) ">Insidentil (sesuai kebutuhan)</option>
              <option value="Tidak Pernah (dalam satu tahun)">Tidak Pernah (dalam satu tahun)</option>
            </select>
          </div>
          <br>     
		  <button type="submit" class="btn btn-primary mt-5">Simpan</button>
        </form>

      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="input_pertemuan_rutin_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Input Data Pertemuan Rutin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" action="/kpp/data-pertemuan" enctype="multipart/form-data">
			@csrf          
          
			<div class="document-group" style=" margin-top: 5	0px;" >
				<input type="text" id="kelurahan_id" name="kelurahan_id" value="{{$kppdata->kode_desa}}" readonly>
				<div class="form-group">
					<label>Tanggal</label>
					<input type="date" class="form-control" id="tanggal_pertemuan_rutin" name="tanggal_pertemuan_rutin" placeholder="Tanggal" >
				</div>
				<div class="form-group">
					<label>Pokok Bahasan</label>
					<input type="text" class="form-control" id="pokok_bahasan" name="pokok_bahasan" placeholder="Pokok Bahasan" >
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
				</div>
				<p class="mt-3">Upload Foto Terbaik Pertemuan Rutin</p>
				<input type="file" class="form-control-file" id="foto_pertemuan_rutin" name="foto_pertemuan_rutin">
			</div>

			<button type="submit" class="btn btn-primary mt-5">Simpan</button>

        </form>


      </div>

    </div>
  </div>
</div>
