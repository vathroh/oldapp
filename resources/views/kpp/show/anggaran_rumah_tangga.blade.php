

 <div class="form-group">

    <label>       
      Anggaran Rumah Tangga
    </label>

    <div class="data-group-isi">
      <form>
        <div class="input">
          <input type="text" class="form-control" id="anggaran_rumah_tangga" name="anggaran_rumah_tangga" value="{{ $kppdata->anggaran_rumah_tangga }}" readonly>
        </div>

        <div class="isifile">
          @php
          if(is_null($kppdata->scan_anggaran_rumah_tangga)){
          echo "File belum diupload";
          }else{
          @endphp
          <p>File sudah diupload <a href="/kpp/anggaran-rumah-tangga/{{$kppdata->id}}">Lihat</a></p> 
          @php
          }
          @endphp
        </div>
    
        <div class="button">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#anggaran_rumah_tangga_modal">
            Edit & Upload
          </button>
        </div>
      </form>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="anggaran_rumah_tangga_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Anggaran Rumah Tangga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" action="/kpp/anggaran-rumah-tangga/{{$kppdata->id}}" enctype="multipart/form-data">
          @method('patch')
          @csrf

          <div class="form-group">
            <label for="anggaran_rumah_tangga">
              Apakah sudah memiliki Anggaran Rumah Tangga?
            </label>
            <select name="anggaran_rumah_tangga" id="anggaran_rumah_tangga" class="form-control input-lg dynamic">
              <option value="{{$kppdata->anggaran_rumah_tangga}}">{{$kppdata->anggaran_rumah_tangga}}</option>
              <option value="Ada">Ada</option>
              <option value="Tidak Ada">Tidak Ada</option>
            </select>
          </div>
          <br>
          <p>Upload Scan Anggaran Rumah Tangga</p>

          <input type="file" class="form-control-file" id="scan_anggaran_rumah_tangga" name="scan_anggaran_rumah_tangga">

          <button type="submit" class="btn btn-primary mt-5">Simpan</button>

        </form>


      </div>

    </div>
  </div>
</div>
