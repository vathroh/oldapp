<div class="document_item biaya_operasional">
    <h6>Biaya Operasional  KPP</h6>
    <input type="text" class="form-control" id="biaya_operasional" name="biaya_operasional" value="{{$kppdata->bop}}" readonly>
</div>
<div class="form-group">
    <label for="sumber_dana">Sumber Dana</label>
    <input type="text" class="form-control" id="sumber_dana" name="sumber_dana" value="{{$kppdata->sumber_dana_operasional}}" readonly>
</div>
<div class="form-group">
    <label for="nilai_bop">Nilai BOP</label>
    <input type="text" class="halo1" id="nilai_bop" name="nilai_bop" value="{{$kppdata->nilai_bop}}" readonly>
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#biaya_operasional_modal">
    Edit
</button>


<!-- Modal -->
<div class="modal fade" id="biaya_operasional_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Biaya Operasional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="/kpp/biaya-operasional/{{$kppdata->id}}" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="form-group">
                        <label for="biaya_operasional">
                            Apakah sudah memiliki BOP?
                      </label>
                      <select name="biaya_operasional" id="biaya_operasional" class="form-control input-lg dynamic">
                        <option value="{{$kppdata->bop}}">{{$kppdata->bop}}</option>
                        <option value="Ada">Ada</option>
                        <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sumber_dana">Sumber Dana</label>
                    <input type="text" class="form-control" id="sumber_dana" name="sumber_dana" value="{{$kppdata->sumber_dana_operasional}}">
                </div>
                <div class="form-group">
                    <label for="nilai_bop">Nilai BOP</label>
                    <input type="text" class="nomer1" id="nilai_bop" name="nilai_bop" value="{{$kppdata->nilai_bop}}">
                </div>
                <br>
                <button type="submit" class="btn btn-primary mt-5">Simpan</button>
            </form>
        </div>
    </div>
</div>
</div>



