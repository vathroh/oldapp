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
            font-family: 'Anton', sans-serif;
            text-transform: uppercase;
            font-size: 44px;
            position: absolute;
            height: 187mm;
            width: 275mm;
            text-align: center;
            margin-top: 55mm;
        }

        .as {
            font-family: 'EB Garamond', serif;
            text-transform: capitalize;
            font-size: 24px;
            position: absolute;
            height: 187mm;
            width: 275mm;
            text-align: center;
            margin-top: 78mm;
        }
    </style>
</head>

<body>
    <img src="{{ asset('SERTIFIKAT.png') }}">
    <div class="name" style="">
        <h4>{{ auth()->user()->name }}</h4>
    </div>
    <div class="as" style="">
        <h4>Sebagai {{auth()->user()->role}}</h4>
    </div>
</body>

</html>