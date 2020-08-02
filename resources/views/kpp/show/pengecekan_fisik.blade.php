<div class="form-group">

    <label>       
      Pengecekan Fisik
    </label>

    <div class="data-group-isi">
      <form>
        <div class="input">
          <input type="text" class="form-control" id="pengecekan_fisik" name="pengecekan_fisik" value="{{ $kppdata->kegiatan_pengecekan }}" readonly>
        </div>

        <div class="isifile">
          @php
          if(is_null($kppdata->foto_kegiatan_pengecekan)){
          echo "Scan belum diupload";
          }else{
          @endphp
          <button type="submit" class="btn btn-primary">Foto sudah diupload</button>
          @php
          }
          @endphp
        </div>
    
        <div class="button">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pengecekan_fisik_modal">
            Edit & Upload
          </button>
        </div>
      </form>
    </div>
</div>


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
          <br>
          <p>Upload Foto Pengecekan Fisik</p>

          <input type="file" class="form-control-file" id="foto_pengecekan_fisik" name="foto_pengecekan_fisik">

          <button type="submit" class="btn btn-primary mt-5">Simpan</button>

        </form>
      </div>
    </div>
  </div>
</div>