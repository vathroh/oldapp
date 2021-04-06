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
                {{ $username }}
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
</body>

</html>


<!-- <!DOCTYPE html>
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

        img {
            position: absolute;
            height: 187mm;
            width: 275mm;
        }

        .name {
            position: absolute;
            font-family: 'Anton', sans-serif;
            text-transform: uppercase;
            font-size: 44px;
            height: 100mm;
            width: 275mm;
            text-align: center;
            margin-top: 41mm;
        }

        .as {
            position: absolute;
            font-family: 'EB Garamond', serif;
            text-transform: capitalize;
            font-size: 30px;
            width: 275mm;
            text-align: center;
            margin-top: 61mm;
        }

        .activity_name {
            text-transform: uppercase;
            font-size: 24px;
            position: absolute;
            height: 187mm;
            width: 275mm;
            text-align: center;
            margin-top: 92mm;
            margin-left: 5mm;
            font-weight: bold;
        }

        .nsup {
            text-transform: capitalize;
            font-size: 20px;
            position: absolute;
            height: 187mm;
            width: 265mm;
            text-align: center;
            margin-top: 110mm;
            margin-left: 5mm;
            font-weight: bold;
        }

        .date {
            text-transform: capitalize;
            font-size: 18px;
            position: absolute;
            height: 187mm;
            width: 265mm;
            text-align: center;
            margin-top: 120mm;
            margin-left: 5mm;

        }
    </style>
</head>

<body>
    <img src="{{ public_path('SERTIFIKAT_01.png') }}"> -->
<!-- <img src="{{ asset('SERTIFIKAT_01.png') }}">
<div class="name" style="">
    <h4>{{ $username }}</h4>
</div>
<div class="as" style="">
    <h4>Sebagai {{$role}}</h4>
</div>
</body>

</html> -->