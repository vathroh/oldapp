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
    <img src="{{ public_path('SERTIFIKAT_01.png') }}">
    <!-- <img src="{{ asset('SERTIFIKAT_01.png') }}"> -->
    <div class="name" style="">
        <h4>{{ $username }}</h4>
    </div>
    <div class="as" style="">
        <h4>Sebagai {{$role}}</h4>
    </div>
</body>

</html>