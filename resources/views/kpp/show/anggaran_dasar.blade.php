<div class="form-group">

    <label>       
      Anggaran Dasar
    </label>

    <div class="data-group-isi">
      <form>
        <div class="input">
          <input type="text" class="form-control" id="anggaran_dasar" name="anggaran_dasar" value="{{ $kppdata->anggaran_dasar }}" readonly>
        </div>

        <div class="isifile">
          @php
          if(is_null($kppdata->scan_anggaran_dasar)){
          echo "Scan ";
          }else{
          @endphp
          <button type="submit" class="btn btn-primary">Scan sudah diupload</button>
          @php
          }
          @endphp
        </div>
    
        <div class="button">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#anggaran_dasar_modal">
            Edit & Upload
          </button>
        </div>
      </form>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="anggaran_dasar_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Anggaran Dasar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">

    <form method="post" action="/kpp/anggaran-dasar/{{$kppdata->id}}" enctype="multipart/form-data">
      @method('patch')
      @csrf          
      <div class="form-group">
        <label for="struktur_organisasi">
          Apakah sudah memiliki Anggaran Dasar?
      </label>
      <select name="anggaran_dasar" id="anggaran_dasar" class="form-control input-lg dynamic">
          <option value="{{$kppdata->anggaran_dasar}}">{{$kppdata->anggaran_dasar}}</option>
          <option value="Ada">Ada</option>
          <option value="Tidak Ada">Tidak Ada</option>
      </select>
  </div>
  <br>
  <p>Upload Scan Anggaran Dasar</p>

  <input type="file" class="form-control-file" id="scan_anggaran_dasar" name="scan_anggaran_dasar">

  <button type="submit" class="btn btn-primary mt-5">Simpan</button>
</form>


</div>

</div>
</div>
</div>