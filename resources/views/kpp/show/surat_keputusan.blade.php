<div class="form-group">

    <label>       
      Surat Keputusan
    </label>

    <div class="data-group-isi">
        <div class="input">
          {{ $kppdata->surat_keputusan }}
        </div>

        <div class="isifile">
          @php
          if(is_null($kppdata->scan_surat_keputusan)){
          echo "File belum diupload";
          }else{
          @endphp
          <p>File sudah diupload <a href="/kpp/surat-keputusan/{{$kppdata->id}}">Lihat</a></p> 
          @php
          }
          @endphp
        </div>
    
        <div class="button">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#surat_keputusan_modal">
            Edit & Upload
          </button>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="surat_keputusan_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Surat Keputusan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" action="/kpp/surat-keputusan/{{$kppdata->id}}" enctype="multipart/form-data">
          @method('patch')
          @csrf
          <div class="form-group">
            <label for="surat_keputusan">
              Apakah sudah memiliki Surat Keputusan?
            </label>
            <select name="surat_keputusan" id="surat_keputusan" class="form-control input-lg dynamic">
              <option value="{{$kppdata->surat_keputusan}}">{{$kppdata->surat_keputusan}}</option>
              <option value="Ada">Ada</option>
              <option value="Tidak Ada">Tidak Ada</option>
            </select>
          </div>
          <br>
          <p>Upload Scan Surat Keputusan</p>
          <input type="file" class="form-control-file" id="scan_surat_keputusan" name="scan_surat_keputusan">
          <button type="submit" class="btn btn-primary mt-5">Simpan</button>
        </form>
        
      </div>
    </div>
  </div>
</div>
