<div class="form-group">

    <label>       
      Pertemuan Rutin
    </label>

    <div class="data-group-isi">
      <form>
        <div class="input">
          <input type="text" class="form-control" id="pertemuan_rutin" name="pertemuan_rutin" value="{{ $kppdata->pertemuan_rutin }}" readonly>
        </div>

        <div class="isifile">
          @php
          if(is_null($kppdata->scan_pertemuan_rutin)){
          echo "Scan belum diupload";
          }else{
          @endphp
          <button type="submit" class="btn btn-primary">File sudah diupload</button>
          @php
          }
          @endphp
        </div>
    
        <div class="button">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pertemuan_rutin_modal">
            Edit & Upload
          </button>
        </div>
      </form>
    </div>
</div>



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
          <p>Upload Foto Terbaik Pertemuan Rutin</p>

          <input type="file" class="form-control-file" id="foto_pertemuan_rutin" name="foto_pertemuan_rutin">

          <button type="submit" class="btn btn-primary mt-5">Simpan</button>

        </form>


      </div>

    </div>
  </div>
</div>