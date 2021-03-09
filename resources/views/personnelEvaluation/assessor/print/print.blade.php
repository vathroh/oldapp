<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        KOTAKU OSP-1 JATENG-1
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->

    <style>
        #evaluatorSign {
            display: flex;
            flex-wrap: wrap;
            text-align: center;
            text-transform: uppercase;
            justify-content: center;
        }

        #personnelEvaluator {
            margin-top: 20px;
            width: 40%;
        }

        .evaluatorTitle {
            text-transform: uppercase;
            font-size: 18px;
            margin: 30px 0 0px 0;
            text-align: center;
            font-weight: bold;
        }

        #kop {
            width: 100%;
        }

        @media print {
            .btn-print {
                display: none;
            }

            h2 {
                page-break-after: always;
            }

            #break {
                page-break-after: left;
            }

            #avoidbreak {
                page-break-inside: avoid;
            }
        }
    </style>

    <!-- CSS Files -->
    <link href="{{ asset('MaterialDashboard/css/material-dashboard.css?v=2.1.2') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/MaterialDashboard/css/bootstrap.min.css') }}">
    <script src="{{ asset('MaterialDashboard/js/core/jquery.min.js') }}"></script>
</head>


<body class="">
    <button class="btn-print" onClick="window.print()">Print</button>
    @foreach($evaluationSetting->evaluationValue->whereIn('userId', $currentjobDesc->pluck('user_id')) as $value)
    <div id="break">
        <img src="{{ asset('images/kop_atas.png') }}" id="kop">
        <div class="form-group text-center">
            <h3>PROGRAM KOTA TANPA KUMUH</h3>
            <h3>OSP 1 PROVINSI JAWA TENGAH</h3>
            <h4>Evaluasi Kinerja {{ $evaluationSetting->jobTitle->job_title}}</h4>
            <h4>Kuartal {{ $evaluationSetting->quarter }} Tahun {{ $evaluationSetting->year }}</h4>
        </div>
        <table style="width:100%;">
            <tbody>
                <tr>
                    <td style="width:20%" class="text-uppercase">Nama Personil</td>
                    <td class="text-uppercase">:{{ $value->user->name}} </td>
                </tr>
                <tr>
                    <td style="width:20%">Tim</td>
                    <td>:{{$value->team}} </td>
                </tr>
                <tr>
                    <td style="width:20%">Kabupaten/Kota</td>
                    <td>:{{ $currentjobDesc->where('user_id', $value->user->id)->first()->kabupaten[0] ->NAMA_KAB ?? '' }} </td>
                </tr>
            </tbody>
        </table>

        <table class="table-striped table-bordered" style="width:100%;">
            <thead>
                <tr>
                    <th class="text-center" scope="col">No</th>
                    <th class="text-center" scope="col">Aspek Kinerja</th>
                    <th class="text-center" scope="col">Variabel Target</th>
                    <th class="text-center" scope="col">Tercapai %</th>
                    <th class="text-center" scope="col">Penilaian Ketercapaian (%)</th>
                    <th class="text-center" scope="col">Skor</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 0; $i < count(unserialize($evaluationSetting->aspectId)); $i++ )
                    <tr>
                        <td>
                            {{ unserialize($evaluationSetting->aspectId)[$i][0] }}
                        </td>
                        <td colspan="5">
                            {{ $criterias->find(unserialize($evaluationSetting->aspectId)[$i][0])->criteria }}
                        </td>
                    </tr>
                    @for($x = 1; $x < count(unserialize($evaluationSetting->aspectId)[$i]); $x++ )
                        <tr>
                            <td>{{ $x }}</td>
                            <td>{{ $aspects->find(unserialize($evaluationSetting->aspectId)[$i][$x])->aspect }}</td>
                            <td>
                                <input type="checkbox" @if(isset(unserialize($value->content)[$criterias->find(unserialize($evaluationSetting->aspectId)[$i][0])->id][$aspects->find(unserialize($evaluationSetting->aspectId)[$i][$x])->id])) @if(isset(unserialize($value->content)[$criterias->find(unserialize($evaluationSetting->aspectId)[$i][0])->id][$aspects->find(unserialize($evaluationSetting->aspectId)[$i][$x])->id]['variabel'])) @if(unserialize($value->content)[$criterias->find(unserialize($evaluationSetting->aspectId)[$i][0])->id][$aspects->find(unserialize($evaluationSetting->aspectId)[$i][$x])->id]['variabel'] == 1) checked @endif @endif @endif disabled>
                            </td>
                            <td>{{ unserialize($value->content)[$criterias->find(unserialize($evaluationSetting->aspectId)[$i][0])->id][$aspects->find(unserialize($evaluationSetting->aspectId)[$i][$x])->id]['capaian'] ?? '' }} </td>
                            <td>{{ unserialize($value->content)[$criterias->find(unserialize($evaluationSetting->aspectId)[$i][0])->id][$aspects->find(unserialize($evaluationSetting->aspectId)[$i][$x])->id]['assessment'] ?? '' }} </td>
                            <td>{{ unserialize($value->content)[$criterias->find(unserialize($evaluationSetting->aspectId)[$i][0])->id][$aspects->find(unserialize($evaluationSetting->aspectId)[$i][$x])->id]['score'] ?? ''}} </td>
                        </tr>
                        @endfor
                        <tr>
                            <th class="text-center" colspan="2">Jumlah </th>
                            <th class="text-center">{{ unserialize($value->content)[$criterias->find(unserialize($evaluationSetting->aspectId)[$i][0])->id]['sumVariabel'] ?? ''}}</th>
                            <th colspan="2"></th>
                            <th class="text-center">{{ unserialize($value->content)[$criterias->find(unserialize($evaluationSetting->aspectId)[$i][0])->id]['sumScores'] ?? ''}}</th>
                        </tr>
                        @endfor
                        <tr>
                            <th class="text-center" colspan="2">T O T A L</th>
                            <th class="text-center">{{ unserialize($value->content)['totalVariabel'] ?? ''}} </th>
                            <th colspan="2"></th>
                            <th class="text-center">{{ unserialize($value->content)['totalScores'] ?? ''}} </th>
                        </tr>
            </tbody>
        </table>
        <div class="row mt-5" id="avoidbreak">
            <div class="col-md-6">
                <div>
                    REKOMENDASI PERBAIKAN
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="4">{{ $value->recommendation }}</textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div>
                    MASALAH DAN SARAN
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="4">{{ $value->issue }}</textarea>
                </div>
            </div>
        </div>

        <div id="avoidbreak">
            <div class="mt-3" style="width:100%; border: 1px solid grey; border-radius: 5px; padding: 30px;">
                <div style="width: 600px; margin:auto;">
                    <div class="row">
                        Status Blacklist
                    </div>

                    <div>
                        <input type="hidden" id="user_id" value="{{$value->user->id}}">
                        @foreach($blacklists as $blacklist)
                        <div class="form-check">
                            <input type="checkbox" id="blacklist" name="blacklists[]" data-id={{$blacklist->id}} value="{{ $blacklist->id}}" @if($value->user->blacklists->pluck('id')->contains($blacklist->id)) checked @endif disabled>
                            <label>{{ $blacklist->categories }}</label>
                        </div>
                        @endforeach
                    </div>

                    <div class="row mt-1" style="background-color:#befc9f; padding:10px 0;">
                        <div class="col" style="font-weight: bold; font-size:14px;">
                            Hasil Akhir/Kualifikasi Kinerja
                        </div>
                        <div class="col">
                            <h6 class="text-center" style="vertical-align: bottom;">
                                {{ $value->finalResult }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="evaluatorTitle">
                TIM PENILAI
            </div>

            <div id="evaluatorSign">

                @foreach($currentjobDesc->whereIn('job_title_id', $evaluationSetting->assessor->pluck('evaluator'))->whereIn('work_zone_id', $districts->where('kode_kab', $value->areaKerja[0]->district)->first()->work_zone->pluck('id') )->whereNotIn('job_title_id', [1,2,14]) as $jobDesc1)

                <div id="personnelEvaluator">
                    <div>
                        {{$jobDesc1->user->name }}
                    </div>
                    <br><br><br>
                    <div>
                        {{$jobDesc1->user->posisi->job_title }}
                    </div>
                </div>

                @endforeach
            </div>

            <div class="evaluatorTitle">
                MENGETAHUI DAN MENYETUJUI
            </div>


            <div id="evaluatorSign">
                @if($value->evaluationSetting->jobTitle->level == "Korkot" || $value->evaluationSetting->jobTitle->level == "Askot Mandiri")

                @foreach($currentjobDesc->whereIn('work_zone_id', $districts->where('kode_kab', $value->areaKerja[0]->district)->first()->work_zone->pluck('id'))->whereIn('job_title_id', [14]) as $job_desc2)

                <div id="personnelEvaluator">
                    <div>
                        {{ $job_desc2->user->name }}
                    </div>
                    <br><br><br>
                    <div>
                        {{ $job_desc2->user->posisi->job_title }}
                    </div>
                </div>
                @endforeach
                @else
                @foreach($currentjobDesc->whereIn('work_zone_id', $workZones->where('district_id', $value->areaKerja[0]->district_id)->pluck('id'))->whereIn('job_title_id', [1,2]) as $job_desc2)

                <div id="personnelEvaluator">
                    <div>
                        {{ $job_desc2->user->name }}
                    </div>
                    <br><br><br>
                    <div>
                        {{ $job_desc2->user->posisi->job_title }}
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    @endforeach

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script>
        var form = $('.form'),
            cache_width = form.width(),
            a4 = [595.28, 990.89]; // for a4 size paper width and height

        var canvasImage,
            winHeight = a4[1],
            formHeight = form.height(),
            formWidth = form.width();

        var imagePieces = [];

        // on create pdf button click
        $('#create_pdf').on('click', function() {
            $('body').scrollTop(0);
            imagePieces = [];
            imagePieces.length = 0;
            main();
        });

        // main code
        function main() {
            getCanvas().then(function(canvas) {
                canvasImage = new Image();
                canvasImage.src = canvas.toDataURL('image/png');
                canvasImage.onload = splitImage;
            });
        }

        // create canvas object
        function getCanvas() {
            form.width(a4[0] * 1.33333 - 80).css('max-width', 'none');
            return html2canvas(form, {
                imageTimeout: 2000,
                removeContainer: true,
            });
        }

        // chop image horizontally
        function splitImage(e) {
            var totalImgs = Math.round(formHeight / winHeight);
            for (var i = 0; i < totalImgs; i++) {
                var canvas = document.createElement('canvas'),
                    ctx = canvas.getContext('2d');
                canvas.width = formWidth;
                canvas.height = winHeight;
                //                    source region                   dest. region
                ctx.drawImage(
                    canvasImage,
                    0,
                    i * winHeight,
                    formWidth,
                    winHeight,
                    0,
                    0,
                    canvas.width,
                    canvas.height,
                );

                imagePieces.push(canvas.toDataURL('image/png'));
            }
            console.log(imagePieces.length);
            createPDF();
        }

        // crete pdf using chopped images
        function createPDF() {
            var totalPieces = imagePieces.length - 1;
            var doc = new jsPDF({
                unit: 'px',
                format: 'a4',
            });
            imagePieces.forEach(function(img) {
                doc.addImage(img, 'JPEG', 20, 40);
                if (totalPieces) doc.addPage();
                totalPieces--;
            });
            doc.save('techumber-html-to-pdf.pdf');
            form.width(cache_width);
        }
    </script>
</body>

</html>