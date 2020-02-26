@extends('layouts.app')

@section('content')
<div class="section">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">KD_KSM</th>
                <th scope="col">KEGIATAN</th>
                <th scope="col">RT/RW</th>
                <th scope="col">created_at</th>
                <th scope="col">updated_at</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($kegiatanksmnew as $abab)
                <th scope="row">{{$abab->id}}</th>
                <td>{{$abab->KD_KSM}}</td>
                <td>{{$abab->KEGIATAN}}</td>
                <td>
                    <?php

                    $rtrw = DB::table('kegiatanksm')
                        ->where('KD_KSM', $abab->KD_KSM)
                        ->where('KEGIATAN', $abab->KEGIATAN)
                        ->get('RTRW');
                    echo $rtrw;

                    ?>
                    @foreach($kegiatanksm as $bibi)
                    @endforeach
                </td>
                <td>{{$abab->created_at}}</td>
                <td>{{$abab->updated_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection