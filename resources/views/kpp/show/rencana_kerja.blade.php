<div class="form-group">

    <label>       
      Rencana Kerja
    </label>

    <div class="data-group-isi">
        <div class="input">
          {{ $kppdata->rencana_kerja }}
        </div>

        <div class="isifile">
          @php
          if(is_null($kppdata->scan_rencana_kerja)){
          echo "File belum diupload";
          }else{
          @endphp
          <p>File sudah diupload <a href="/kpp/rencana-kerja/{{$kppdata->id}}">Lihat</a></p> 
          @php
          }
          @endphp
        </div>
    
        <div class="button">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rencana_kerja_modal">
            Edit & Upload
          </button>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="rencana_kerja_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rencana Kerja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" action="/kpp/rencana-kerja/{{$kppdata->id}}" enctype="multipart/form-data">
          @method('patch')
          @csrf
          <div class="form-group">
            <label for="rencana_kerja">
              Apakah sudah memiliki Rencana Kerja?
            </label>
            <select name="rencana_kerja" id="rencana_kerja" class="form-control input-lg dynamic">
              <option value="{{$kppdata->rencana_kerja}}">{{$kppdata->rencana_kerja}}</option>
              <option value="Ada">Ada</option>
              <option value="Tidak Ada">Tidak Ada</option>
            </select>
          </div>
          <br>
          <p>Upload Scan Rencana Kerja</p>

          <input type="file" class="form-control-file" id="scan_rencana_kerja" name="scan_rencana_kerja">

          <button type="submit" class="btn btn-primary mt-5">Simpan</button>
        </form>


      </div>
    </div>
  </div>
</div>
