<div class="document_item keterangan_tambahan">
    {{$kppdata->keterangan_lain_lain}}
</div>
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#keterangan_lain_lain_modal">
    Edit
    </button>


<!-- Modal -->
<div class="modal fade" id="keterangan_lain_lain_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Keterangan Lain Lain</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="/kpp/keterangan-lain-lain/{{$kppdata->id}}" enctype="multipart/form-data">
          	@method('patch')
	        @csrf
			<textarea autofocus class="form-control" id="keterangan_tambahan" name="keterangan_tambahan" rows="7">{{$kppdata->keterangan_lain_lain}}</textarea>
          <button type="submit" class="btn btn-primary mt-5">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
