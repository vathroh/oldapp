<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        SERTIFIKAT PELATIHAN
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <style>
        body {
            @import url('https://fonts.googleapis.com/css2?family=Anton&family=EB+Garamond:wght@600&display=swap');
            background-color: grey;
        }

        .certificate-body {
            height: 187mm;
            width: 275mm;
        }

        img {
            position: absolute;
            height: 187mm;
            width: 275mm;
        }

        .name {
            font-family: 'Anton', sans-serif;
            text-transform: uppercase;
            position: absolute;
            height: 187mm;
            width: 275mm;
            text-align: center;
        }

        .as {
            font-family: 'EB Garamond', serif;
            text-transform: capitalize;
            position: absolute;
            height: 187mm;
            width: 275mm;
            text-align: center;
        }

        .pada-kegiatan {
            font-family: Arial, Helvetica, sans-serif;
            position: absolute;
            height: 187mm;
            width: 275mm;
            text-align: center;
        }

        .kotaku {
            font-family: Arial, Helvetica, sans-serif;
            position: absolute;
            height: 187mm;
            width: 275mm;
            text-align: center;
        }

        .tanggal {
            font-family: Arial, Helvetica, sans-serif;
            position: absolute;
            height: 187mm;
            width: 275mm;
            text-align: center;
        }

        .city {
            font-family: Arial, Helvetica, sans-serif;
            position: absolute;
            height: 187mm;
            width: 275mm;
            text-align: center;
        }

        .OSP {
            font-family: Arial, Helvetica, sans-serif;
            position: absolute;
            height: 187mm;
            width: 275mm;
            text-align: center;
        }

        .signedBy {
            font-family: Arial, Helvetica, sans-serif;
            position: absolute;
            height: 187mm;
            width: 275mm;
            text-align: center;
        }

        .panel {
            background-color: burlywood;
            font-size: 10px;
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
        }

        .panel-item {
            border: 1px solid black;
            border-radius: 5px;
            margin: 10px;
            padding: 10px;
            width: 300px;
        }

        @media print {
            .panel {
                display: none;
            }
        }
    </style>
</head>



<body>
    <div class="certificate-body">
        <img src="{{ asset($certificates->background) }}">
        <div class="name">
            <h4 style="font-size: {{unserialize($certificates->name)['font-size'] ?? 12}}px; margin-top: {{unserialize($certificates->name)['margin-top'] ?? 55}}mm;">
                ini adalah nama saya yang panjang
            </h4>
        </div>
        <div class="as">
            <h4 style="font-size: {{unserialize($certificates->as)['font-size'] ?? 12}}px; margin-top: {{unserialize($certificates->as)['margin-top'] ?? 80}}mm;">
                Sebagai {{ auth()->user()->ActivityParticipant->first()->role}}
            </h4>
        </div>
        <div class="pada-kegiatan">
            <div style="width:80%; margin: auto;">
                <h4 style="font-size: {{unserialize($certificates->activity)['font-size'] ?? 12}}px; margin-top: {{unserialize($certificates->activity)['margin-top'] ?? 80}}mm;">
                    @isset(unserialize($certificates->activity)['text'])
                    @foreach(unserialize($certificates->activity)['text'] as $text)
                    {{ $text }}<br>
                    @endforeach
                    @endif
                </h4>
            </div>
        </div>

        <div class="kotaku">
            <div style="width:80%; margin: auto;">
                <h4 style="font-size: {{unserialize($certificates->kotaku)['font-size'] ?? 12}}px; margin-top: {{unserialize($certificates->kotaku)['margin-top'] ?? 80}}mm;">
                    @isset(unserialize($certificates->kotaku)['text'])
                    @foreach(unserialize($certificates->kotaku)['text'] as $text)
                    {{ $text }}<br>
                    @endforeach
                    @else
                    NATIONAL SLUM UPGRADING PROGRAM (NSUP) PROGRAM KOTA TANPA KUMUH (KOTAKU)
                    @endif
                </h4>
            </div>
        </div>
        <div class="tanggal">
            <h4 style="font-size: {{unserialize($certificates->tanggal)['font-size'] ?? 12}}px; margin-top: {{unserialize($certificates->tanggal)['margin-top'] ?? 120}}mm;">
                @isset(unserialize($certificates->tanggal)['text'])
                @foreach(unserialize($certificates->tanggal)['text'] as $text)
                {{ $text }}<br>
                @endforeach
                @endif
            </h4>
        </div>
        <div class="city">
            <div style="width:80%; margin: auto;">
                <h4 style="font-size: {{unserialize($certificates->city)['font-size'] ?? 12}}px; margin-top: {{unserialize($certificates->city)['margin-top'] ?? 120}}mm;">
                    @isset(unserialize($certificates->city)['text'])
                    @foreach(unserialize($certificates->city)['text'] as $text)
                    {{ $text }}<br>
                    @endforeach
                    @else
                    Semarang, 12 September 2020
                    @endif
                </h4>
            </div>
        </div>
        <div class="OSP">
            <div style="width:80%; margin: auto;">
                <h4 style="font-size: {{unserialize($certificates->osp)['font-size'] ?? 12}}px; margin-top: {{unserialize($certificates->osp)['margin-top'] ?? 142}}mm;">
                    @isset(unserialize($certificates->osp)['text'])
                    @foreach(unserialize($certificates->osp)['text'] as $text)
                    {{ $text }}<br>
                    @endforeach
                    @else
                    Oversight Service Provider (OSP) 1 Provinsi Jawa Tengah 1
                    @endif
                </h4>
            </div>
        </div>
        <div class="signedBy">
            <div style="width:80%; margin: auto;">
                <h4 style="font-size: {{unserialize($certificates->signedBy)['font-size'] ?? 12}}px; margin-top: {{unserialize($certificates->signedBy)['margin-top'] ?? 168}}mm;">
                    <span style="text-decoration:underline;">Drs. Slamet Nurhidayat</span>
                    <br>Team Leader
                </h4>
            </div>
        </div>
    </div>


    <div class="panel">
        <div class="panel-item toname">
            <form action="/kegiatan/panitia/setup/sertifikat/name/{{$certificates->id}}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div>Nama</div>
                <div>
                    Ukuran <input size="2" type="text" name="name[font-size]" value="{{unserialize($certificates->name)['font-size'] ?? 0 }}">
                    Jarak <input size="2" type="text" name="name[margin-top]" value="{{unserialize($certificates->name)['margin-top'] ?? 0 }}">
                    <button type="submit">OK</button>
                </div>
            </form>
            <form action="/kegiatan/panitia/setup/sertifikat/as/{{$certificates->id}}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div>Sebagai</div>
                <div>
                    Ukuran <input size="2" type="text" name="as[font-size]" value="{{unserialize($certificates->as)['font-size'] ?? 0 }}">
                    Jarak <input size="2" type="text" name="as[margin-top]" value="{{unserialize($certificates->as)['margin-top'] ?? 0 }}">
                    <button>OK</button>
                </div>
            </form>
            <form action="/kegiatan/panitia/setup/sertifikat/signedby/{{$certificates->id}}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div>Nama dan Jabatan</div>
                <div>
                    Ukuran <input size="2" type="text" name="signedBy[font-size]" value="{{unserialize($certificates->signedBy)['font-size'] ?? 0 }}">
                    Jarak <input size="2" type="text" name="signedBy[margin-top]" value="{{unserialize($certificates->signedBy)['margin-top'] ?? 0 }}">
                    <button>OK</button>
                </div>
            </form>
        </div>

        <div class="panel-item toname">
            <form action="/kegiatan/panitia/setup/sertifikat/activity/{{$certificates->id}}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div>Nama Kegiatan</div>
                <div>
                    Text 1 <input size="25" type="text" name="activity[text][1]" value="{{unserialize($certificates->activity)['text'][1] ?? '' }}">
                    Text 2 <input size=" 25" type="text" name="activity[text][2]" value="{{unserialize($certificates->activity)['text'][2] ?? '' }}">
                    Text 3 <input size="25" type="text" name="activity[text][3]" value="{{unserialize($certificates->activity)['text'][3] ?? '' }}">
                </div>
                <div>
                    Ukuran <input size="2" type="text" name="activity[font-size]" value="{{unserialize($certificates->activity)['font-size'] ?? 0 }}">
                    Jarak <input size="2" type="text" name="activity[margin-top]" value="{{unserialize($certificates->activity)['margin-top'] ?? 0 }}">
                    <button>OK</button>
                </div>
            </form>
        </div>
        <div class="panel-item toname">
            <form action="/kegiatan/panitia/setup/sertifikat/kotaku/{{$certificates->id}}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div>NSUP</div>
                <div>
                    Text 1 <input size="25" type="text" name="kotaku[text][]" value="{{unserialize($certificates->kotaku)['text'][0] ?? '' }}">
                    Text 2 <input size="25" type="text" name="kotaku[text][]" value="{{unserialize($certificates->kotaku)['text'][1] ?? '' }}">
                </div>
                <div>
                    Ukuran <input size="2" type="text" name="kotaku[font-size]" value="{{unserialize($certificates->kotaku)['font-size'] ?? 0 }}">
                    Jarak <input size="2" type="text" name="kotaku[margin-top]" value="{{unserialize($certificates->kotaku)['margin-top'] ?? 0 }}">
                    <button>OK</button>
                </div>
            </form>
        </div>
        <div class="panel-item toname">
            <form action="/kegiatan/panitia/setup/sertifikat/tanggal/{{$certificates->id}}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div>Tanggal</div>
                <div>
                    Text 1 <input size="25" type="text" name="tanggal[text][]" value="{{unserialize($certificates->tanggal)['text'][0] ?? '' }}">
                    Text 2 <input size="25" type="text" name="tanggal[text][]" value="{{unserialize($certificates->tanggal)['text'][1] ?? '' }}">
                </div>
                <div>
                    Ukuran <input size=" 2" type="text" name="tanggal[font-size]" value="{{unserialize($certificates->tanggal)['font-size'] ?? 0 }}">
                    Jarak <input size="2" type="text" name="tanggal[margin-top]" value="{{unserialize($certificates->tanggal)['margin-top'] ?? 0 }}">
                    <button>OK</button>
                </div>
            </form>
        </div>
        <div class="panel-item toname">
            <form action="/kegiatan/panitia/setup/sertifikat/kota/{{$certificates->id}}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div>Kota dan Tanggal Terbit</div>
                <div>
                    Text <input size="25" type="text" name="city[text][]" value="{{unserialize($certificates->city)['text'][0] ?? 0 }}">
                </div>
                <div>
                    Ukuran <input size="2" type="text" name="city[font-size]" value="{{unserialize($certificates->city)['font-size'] ?? 0 }}">
                    Jarak <input size="2" type="text" name="city[margin-top]" value="{{unserialize($certificates->city)['margin-top'] ?? 0 }}">
                    <button>OK</button>
                </div>
            </form>
        </div>
        <div class="panel-item toname">
            <form action="/kegiatan/panitia/setup/sertifikat/osp/{{$certificates->id}}" method="post" enctype="multipart/form-data">@csrf @method('put')
                <div>OSP</div>
                <div>
                    text 1 <input size="25" type="text" name="osp[text][]" value="{{unserialize($certificates->osp)['text'][0] ?? '' }}">
                    text 2 <input size="25" type="text" name="osp[text][]" value="{{unserialize($certificates->osp)['text'][1] ?? '' }}">
                </div>
                <div>
                    Ukuran <input size="2" type="text" name="osp[font-size]" value="{{unserialize($certificates->osp)['font-size'] ?? 0 }}">
                    Jarak <input size="2" type="text" name="osp[margin-top]" value="{{unserialize($certificates->osp)['margin-top'] ?? 0 }}">
                    <button>OK</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>