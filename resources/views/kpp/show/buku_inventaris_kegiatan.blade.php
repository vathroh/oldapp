<div class="form-group">

    <label>       
      Buku Inventaris Kegiatan
    </label>

    <div class="data-group-isi">
        <div class="input">
          {{ $kppdata->buku_inventaris_kegiatan }}
        </div>

        <div class="isifile">
          @php
          if(is_null($kppdata->scan_buku_inventaris_kegiatan)){
          echo "File Kosong";
          }else{
          @endphp
          <p>File sudah diupload <a href="/kpp/buku-inventaris-kegiatan/{{$kppdata->id}}">Lihat</a></p> 
          @php
          }
          @endphp
        </div>
    
        <div class="button">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#buku_inventaris_kegiatan_modal">
            Edit & Upload
          </button>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="buku_inventaris_kegiatan_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buku/Inventaris Kegiatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" action="/kpp/buku-inventaris-kegiatan/{{$kppdata->id}}" enctype="multipart/form-data">
          @method('patch')
          @csrf
          <div class="form-group">
            <label for="buku_inventaris_kegiatan">
              Apakah sudah memili?
            </label>
            <select name="buku_inventaris_kegiatan" id="buku_inventaris_kegiatan" class="form-control input-lg dynamic">
              <option value="{{$kppdata->buku_inventaris_kegiatan}}">{{$kppdata->buku_inventaris_kegiatan}}</option>
              <option value="Ada">Ada </option>
              <option value="Tidak Ada">Tidak Ada</option>
            </select>
          </div>
          <br>
          <p>Upload Scan Pencatatan/Administrasi Rutin</p>

          <input type="file" class="form-control-file" id="scan_buku_inventaris_kegiatan" name="scan_buku_inventaris_kegiatan">

          <button type="submit" class="btn btn-primary mt-5">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
