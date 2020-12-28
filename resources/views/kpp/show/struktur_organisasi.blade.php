<div class="form-group">

    <label>       
      Struktur Organisasi
    </label>

    <div class="data-group-isi">
        <div class="input">
          {{ $kppdata->struktur_organisasi }}
        </div>

        <div class="isifile">
            @php
            if(is_null($kppdata->scan_struktur_organisasi)){
                  echo "File Belum Diupload";
            }else{
            @endphp
				<p>File sudah diupload <a href="/kpp/struktur-organisasi/{{$kppdata->id}}">Lihat</a></p> 
            @php
            }
            @endphp
        </div>
    
        <div class="button">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#struktur_organisasi_modal">
            Edit & Upload
          </button>
        </div>

    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="struktur_organisasi_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Struktur Organisasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" action="/kpp/struktur-organisasi/{{$kppdata->id}}" enctype="multipart/form-data">
          @method('patch')
          @csrf

          @php

          @endphp


          <div class="form-group">
            <label for="struktur_organisasi">
              Apakah sudah memiliki struktur organisasi?
            </label>
            <select name="struktur_organisasi" id="struktur_organisasi" class="form-control input-lg dynamic">
              <option value="{{$kppdata->struktur_organisasi}}">{{$kppdata->struktur_organisasi}}</option>
              <option value="Ada">Ada</option>
              <option value="Tidak Ada">Tidak Ada</option>
            </select>
          </div>
          <br>
          <p>Upload Scan Struktur Organisasi</p>

          <input type="file" class="form-control-file" id="scan_struktur_organisasi" name="scan_struktur_organisasi">

          <button type="submit" class="btn btn-primary mt-5">Simpan</button>

        </form>


      </div>

    </div>
  </div>
</div>
