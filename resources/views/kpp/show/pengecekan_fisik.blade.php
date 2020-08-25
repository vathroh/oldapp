<div class="form-group">
    <label>       
      Pengecekan Fisik
    </label>
    <div class="data-group-isi">
      <form>
        <div class="input">
          <input type="text" class="form-control" id="pengecekan_fisik" name="pengecekan_fisik" value="{{ $kppdata->kegiatan_pengecekan }}" readonly>
        </div>    
        <div class="button">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pengecekan_fisik_modal">
            Edit
          </button>
        </div>
      </form>
    </div>
</div>

<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th scope="col"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input_pengecekan_fisik_modal">
            Input
          </button></th>
      <th scope="col">Tanggal</th>
      <th scope="col">Keterangan</th>
      <th scope="col">Foto</thT
  <tbody>
	@foreach($data_pengecekan_fisiks as $data_pengecekan_fisik)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $data_pengecekan_fisik->tanggal }}</td>
      <td>{{ $data_pengecekan_fisik->keterangan }}</td>
      <td><img src ="{{ asset('storage/kpp/' . $data_pengecekan_fisik->foto_pengecekan_fisik) }}" style = "height:100px;"></td>
    </tr>
    @endforeach
  </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="pengecekan_fisik_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pengecekan Fisik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" action="/kpp/pengecekan-fisik/{{$kppdata->id}}" enctype="multipart/form-data">
          @method('patch')
          @csrf
          <div class="form-group">
            <label for="pengecekan_fisik">
              Apakah Pengecekan Fisik sudah dilaksanakan?
            </label>
            <select name="pengecekan_fisik" id="pengecekan_fisik" class="form-control input-lg dynamic">
              <option value="{{$kppdata->kegiatan_pengecekan}}">{{$kppdata->kegiatan_pengecekan}}</option>
              <option value="Belum Pernah">Belum Pernah </option>
              <option value="Belum Dilakukan">Belum Dilakukan</option>
              <option value="Sudah Dilakukan">Sudah Dilakukan</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary mt-5">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="input_pengecekan_fisik_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pengecekan Fisik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" action="/kpp/data-pengecekan-fisik" enctype="multipart/form-data">
          @csrf
          <input type="text" id="kelurahan_id" name="kelurahan_id" value="{{$kppdata->kode_desa}}" readonly>
          <div class="form-group">
            <label>
              Tanggal
            </label>
            <input type="date" class="form-control" id="tanggal_pengecekan_fisik" name="tanggal_pengecekan_fisik" required>
          </div>
          <div class="form-group">
            <label>
              Keterangan
            </label>
            <input type="text" class="form-control" id="keterangan_pengecekan_fisik" name="keterangan_pengecekan_fisik">
          </div>
          <br>
          <p>Upload Foto Pengecekan Fisik</p>
          <input type="file" class="form-control-file" id="foto_pengecekan_fisik" name="foto_pengecekan_fisik" required>
          <button type="submit" class="btn btn-primary mt-5">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
