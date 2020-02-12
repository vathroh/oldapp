@extends('layouts.app')

@section('content')
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tahun-tab" data-toggle="tab" href="#tahun" role="tab" aria-controls="tahun" aria-selected="true">Tahun</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent" style="margin-top: 50px">
                    <div class="row">
                        <div class="col">
                            <a name="tambahTahun" id="tambahTahun" class="btn btn-primary" href="/inputyear" role="button">Tambah Tahun</a>
                            <a name="document" id="document" class="btn btn-primary" href="/doc" role="button">Lihat Folder & Documen</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="tab-pane fade show active" id="tahun" role="tabpanel" aria-labelledby="tahun-tab">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">NO</th>
                                            <th scope="col">TAHUN</th>
                                            <th scope="col">NAMA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tahun as $thn)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $thn->tahun }}</td>
                                            <td>{{ $thn->nama_tahun }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection