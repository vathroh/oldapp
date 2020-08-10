<div class="form-group">
    <label for="kelurahan">       
        KETUA
    </label>
    <input type="text" name="ketua_kpp" id="ketua_kpp" value="{{$pengurus_kpp->ketua_kpp}}" readonly>
</div>

<div class="form-group">
    <label for="kelurahan">       
        SEKRETARIS
    </label>
    <input type="text" name="sekretaris_kpp" id="sekretaris_kpp" value="{{$pengurus_kpp->sekretaris_kpp}}" readonly>
</div>

<div class="form-group">
    <label for="kelurahan">       
        BENDAHARA
    </label>
    <input type="text" name="bendahara_kpp" id="bendahara_kpp" value="{{$pengurus_kpp->bendahara_kpp}}" readonly>
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pengurus_modal">
    Edit
</button>


<!-- Modal -->
<div class="modal fade" id="pengurus_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kepengurusan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">

    <form method="post" action="/kpp/pengurus/{{$pengurus_kpp->id}}" enctype="multipart/form-data">
        @method('patch')
        @csrf

        <div class="document-group">
            <label>       
                Ketua
            </label>

            <div class="data-group-isi">
                <div class="input">
                    <input type="text" class="form-control" id="ketua_kpp" name="ketua_kpp" value="{{$pengurus_kpp->ketua_kpp}}" >
                </div>
            </div>

            <label>       
                No. HP Ketua
            </label>

            <div class="data-group-isi">
                <div class="input">
                    <input type="text" class="form-control" id="ketua_kpp_hp" name="ketua_kpp_hp" value="{{$pengurus_kpp->ketua_kpp_hp}}">
                </div>
            </div>
        </div>

        <div class="document-group">
            <label>       
                Sekretaris 
            </label>

            <div class="data-group-isi">
                <div class="input">
                    <input type="text" class="form-control" id="sekretaris_kpp" name="sekretaris_kpp" value="{{$pengurus_kpp->sekretaris_kpp}}">
                </div>
            </div>

            <label>       
                No. HP Sekretaris
            </label>

            <div class="data-group-isi">
                <div class="input">
                    <input type="text" class="form-control" id="sekretaris_kpp_hp" name="sekretaris_kpp_hp" value="{{$pengurus_kpp->sekretaris_kpp_hp}}">
                </div>
            </div>
        </div>

        <div class="document-group">
            <label>       
                Bendahara 
            </label>

            <div class="data-group-isi">
                <div class="input">
                    <input type="text" class="form-control" id="bendahara_kpp" name="bendahara_kpp" value="{{$pengurus_kpp->bendahara_kpp}}">
                </div>
            </div>

            <label>       
                No. HP Bendahara
            </label>

            <div class="data-group-isi">
                <div class="input">
                    <input type="text" class="form-control" id="bendahara_kpp_hp" name="bendahara_kpp_hp" value="{{$pengurus_kpp->bendahara_kpp_hp}}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-5">Simpan</button>

    </form>


</div>

</div>
</div>
</div>