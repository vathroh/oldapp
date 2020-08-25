<div class="document_item biaya_operasional">
    <h6>Biaya Operasional  KPP</h6>
    <input type="text" class="form-control" id="biaya_operasional" name="biaya_operasional" value="{{$kppdata->bop}}" readonly>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#biaya_operasional_modal">
    Edit
	</button>
</div>
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th scope="col">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input_biaya_operasional_modal">
			Input
		</button>
      </th>
      <th scope="col">Tanggal Penerimaan Dana</th>
      <th scope="col">Sumber Dana</th>
      <th scope="col">Jumlah</th>
      <th scope="col">Diinput oleh</th>
    </tr>
  </thead>
  <tbody>
	  @foreach($kpp_operating_funds as $kpp_operating_fund)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $kpp_operating_fund->tanggal }}</td>
      <td>{{ $kpp_operating_fund->sumber_dana }}</td>
      <td style="text-align:right"></td>
      <td>{{ $user[0]->where('id', $kpp_operating_fund->inputby_id)->get()[0]['name'] }}</td>
    </tr>
    @endforeach
    <tr>
      <td colspan="3">Jumlah</td>
      @php
		$jumlah1 = str_replace('[{"jumlah":"', '', $jumlah);
		$jumlah2 = str_replace('"}]', '', $jumlah1);	
      @endphp
      <td style="text-align:right">{{ $jumlah2 }}</td>
    </tr>
  </tbody>
</table>


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
                <br>
                <button type="submit" class="btn btn-primary mt-5">Simpan</button>
            </form>
        </div>
    </div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="input_biaya_operasional_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Biaya Operasional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="/kpp/data-bop" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="text" id="kelurahan_id" name="kelurahan_id" value="{{$kppdata->kode_desa}}" readonly>
					<div class="form-group">
						<label for="sumber_dana">Tanggal Penerimaan Dana</label>
						<input type="date" class="form-control" id="tanggal" name="tanggal" required>
					</div>
					<div class="form-group">
						<label for="sumber_dana">Pemberi Dana</label>
						<input type="text" class="form-control" id="sumber_dana" name="sumber_dana" required>
					</div>
					<div class="form-group">
						<label for="nilai_bop">Nilai BOP</label>
						<input type="text" class="nomer1" id="rupiah" name="nilai_bop" required>
					</div>
					<br>
					<button type="submit" class="btn btn-primary mt-5">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	
var rupiah = document.getElementById("rupiah");
rupiah.addEventListener("keyup", function(e) {
  // tambahkan 'Rp.' pada saat form di ketik
  // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
  rupiah.value = formatRupiah(this.value, "Rp. ");
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}


</script>


