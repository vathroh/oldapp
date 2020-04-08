@extends('layouts.app')

@section('content')
<div class="form-group">
    <select name="nama_kabupaten" id="nama_kabupaten" class="form-control input-lg dynamic" data-dependent="state">
        <option value="WONOSOBO">WONOSOBO</option>
        <option value="REMBANG">REMBANG</option>
        <option value="PATI">PATI</option>
        <option value="KUDUS">KUDUS</option>
        <option value="JEPARA">JEPARA</option>
        <option value="DEMAK">DEMAK</option>
        <option value="SEMARANG">SEMARANG</option>
        <option value="TEMANGGUNG">TEMANGGUNG</option>
        <option value="KENDAL">KENDAL</option>
        <option value="BATANG">BATANG</option>
        <option value="PEKALONGAN">PEKALONGAN</option>
        <option value="PEMALANG">PEMALANG</option>
        <option value="TEGAL">TEGAL</option>
        <option value="KOTA SEMARANG">KOTA SEMARANG</option>
        <option value="KOTA PEKALONGAN">KOTA PEKALONGAN</option>
    </select>
</div>
<br />
<select name="nama_kelurahan" id="nama_kelurahan" class="form-control input-lg dynamic" data-dependent="state">
</select>


<div class="form-group">
    <select name="state" id="state" class="form-control input-lg dynamic" data-dependent="city">



        <?php

        use App\village;

        // echo $kabupaten;

        $desa = village::where('NAMA_KAB', 'PEMALANG')->get('NAMA_DESA');
        $hitung = count($desa);
        for ($i = 0; $i < $hitung; $i++) {

        ?>
            <option value="">
                <?php
                $r = $desa[$i]['NAMA_DESA'];
                echo $r;
                ?>
            </option>
        <?php
        }
        ?>


    </select>
</div>
<br />
<div class="form-group">
    <select name="city" id="city" class="form-control input-lg">
        <option value="">Select City</option>
    </select>
</div>

@endsection