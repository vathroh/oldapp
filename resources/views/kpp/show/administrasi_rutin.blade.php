<!-- <div class="document_item administrasi_rutin"> -->
  <div class="form-group">

    <label>       
      Pencatatan/Administrasi Rutin
    </label>

    <div class="data-group-isi">
      <form>
        <div class="input">
          <input type="text" class="form-control" id="administrasi_rutin" name="administrasi_rutin" value="{{ $kppdata->administrasi_rutin }}" readonly>
        </div>

        <div class="isifile">
          @php
          if(is_null($kppdata->scan_administrasi_rutin)){
          echo "Scan belum diupload";
          }else{
          @endphp
          <button type="submit" class="btn btn-primary">File sudah diupload</button>
          @php
          }
          @endphp
        </div>
    
        <div class="button">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#administrasi_rutin_modal">
            Edit & Upload
          </button>
        </div>
      </form>
    </div>
</div>
<!-- </div> -->


<!-- Modal -->
<div class="modal fade" id="administrasi_rutin_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pencatatan/Administrasi Rutin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" action="/kpp/administrasi-rutin/{{$kppdata->id}}" enctype="multipart/form-data">
          @method('patch')
          @csrf
          <div class="form-group">
            <label for="administrasi_rutin">
              Jenis Pencatatan/Administrasi Rutin yang dilaksanakan?
            </label>
            <select name="administrasi_rutin" id="administrasi_rutin" class="form-control input-lg dynamic">
              <option value="{{$kppdata->administrasi_rutin}}">{{$kppdata->administrasi_rutin}}</option>
              <option value="Administrasi Bulanan Lengkap">Administrasi Bulanan Lengkap </option>
              <option value="Administrasi Bulanan Minimalis">Administrasi Bulanan Minimalis</option>
              <option value="Administrasi Triwulan/Selebihnya">Administrasi Triwulan/Selebihnya</option>
              <option value="Tidak Ada">Tidak Ada</option>
            </select>
          </div>
          <br>
          <p>Upload Scan Pencatatan/Administrasi Rutin</p>

          <input type="file" class="form-control-file" id="scan_administrasi_rutin" name="scan_administrasi_rutin">

          <button type="submit" class="btn btn-primary mt-5">Simpan</button>

        </form>


      </div>

    </div>
  </div>
</div>