@extends('layouts.MaterialDashboard')



@section('content')
<div class="card">

    <div class="card-header card-header-primary">
        <h4 class="card-title ">Evaluasi Kinerja</h4>
        <p class="card-category">Kriteria</p>
    </div>

    <div class="card-body">
        @include('personnelEvaluation.beingAssessed.navbar')

        <div id="ready" class="form-group text-center my-3" data-ready="{{ $value->ready }}" data-ready="{{ $value->ready }}">
            <h4>Evaluasi Kinerja {{ $value->evaluationSetting->jobTitle->job_title }}</h4>
            <h4>Triwulan {{ $value->evaluationSetting->quarter }} Tahun {{ $value->evaluationSetting->year }} </h4>
        </div>

        <div>
            <div class="row">
                <div class="col-md-3">
                    <h6>Nama Personil</h6>
                </div>
                <div class="col-md-9">
                    <h6>: {{ $value->user->name }}</h6>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <h6>Tim</h6>
                </div>
                <div class="col-md-9">
                    <h6>: <input type="text" id="team" data-value="{{ $value->id }}" value="@isset($job_desc[0]->areaKerja){{ $job_desc[0]->areaKerja->team}}  @endif"></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h6>Kabupaten/Kota</h6>
                </div>
                <div class="col-md-9">
                    <h6>: @isset($job_desc[0]->kabupaten[0]->NAMA_KAB){{ $job_desc[0]->kabupaten[0]->NAMA_KAB }} @endif</h6>
                    </h6>
                </div>
            </div>
        </div>
        <table class=" table table-bordered" style="width:100%;">
            <thead>
                <tr>
                    <th class="text-center" scope="col">No</th>
                    <th class="text-center" scope="col">Aspek Kinerja</th>
                    <th class="text-center" scope="col">Variabel Target</th>
                    <th class="text-center" scope="col">Tercapai %</th>
                    <th class="text-center" scope="col">Penilaian Ketercapaian %</th>
                    <th class="text-center" scope="col">Skor</th>
                    <th class="text-center" scope="col">Bukti</th>
                    <th class="text-center" scope="col" colspan="2"></th>
                </tr>
            </thead>
            <tbody>

                @forelse(collect(unserialize($value->evaluationSetting->aspectId)) as $criteria)
                <tr style="background-color:#c2f0fc;">
                    <td colspan="9">{{ $criterias->find($criteria[0])->criteria }}</td>
                </tr>

                @foreach(collect($criteria) as $aspect)
                @if($loop->index !=0 )
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{ $aspects->find(collect($aspect)[0])->aspect }}</td>
                    <td class="text-center">
                        <input type="checkbox" value="1" id="checkbox" name="checkbox" data-id="{{ $criteria[0] }}-{{ $aspect }}" data-aspect="{{ $aspect }}" data-criteria="{{ $criteria[0] }}" data-value="{{ $value->id }}" @isset($content[$criteria[0]][$aspect]["variabel"]) data-variabel="{{ $content[$criteria[0]][$aspect]["variabel"] }}" @if($content[$criteria[0]][$aspect]['variabel']==1) checked @endif @endif>
                        
                    </td>
                    <td class=" text-center">
                        @if($criterias->find($criteria[0])->id == 1)
                        <input class="capaian" type="Text" size="2" id="{{ $criteria[0] }}-{{ $aspect }}" data-aspect="{{ $aspect }}" data-criteria="{{ $criteria[0] }}" data-value="{{ $value->id }}" @isset($content[$criteria[0]][$aspect]['variabel']) @if($content[$criteria[0]][$aspect]['variabel']==0 ) disabled style="background-color:grey;" @endif @else disabled style="background-color:grey;" @endif @isset($content[$criteria[0]][$aspect]['capaian']) value="{{ $content[$criteria[0]][$aspect]['capaian'] }}" @endif disabled>
                        @else
                        <select class="capaian" type="Text" id="{{ $criteria[0] }}-{{ $aspect }}" data-aspect="{{ $aspect }}" data-criteria="{{ $criteria[0] }}" data-value="{{ $value->id }}" @isset($content[$criteria[0]][$aspect]['variabel']) @if($content[$criteria[0]][$aspect]['variabel']==0 ) disabled style="background-color:grey;" @endif @else disabled style="background-color:grey;" @endif disabled>
                            @isset($content[$criteria[0]][$aspect]['capaian'])
                            <option value="{{ $content[$criteria[0]][$aspect]['capaian'] }}"> {{ $content[$criteria[0]][$aspect]['capaian'] }} </option>
                            @endif
                            <option value=0>0</option>
                            <option value=1>1</option>
                        </select>
                        @endif
                    </td>
                    <td class=" text-center">
                        @if($criterias->find($criteria[0])->id == 1)
                        <input class="assessment" type="Text" size="2" id="{{ $criteria[0] }}-{{ $aspect }}" data-aspect="{{ $aspect }}" data-criteria="{{ $criteria[0] }}" data-value="{{ $value->id }}" @isset($content[$criteria[0]][$aspect]['variabel']) @if($content[$criteria[0]][$aspect]['variabel']==0 ) disabled style="background-color:grey;" @endif @else disabled style="background-color:grey;" @endif @isset($content[$criteria[0]][$aspect]['assessment']) value="{{ $content[$criteria[0]][$aspect]['assessment'] }}" @endif>
                        @else
                        <select class="assessment" type="Text" id="{{ $criteria[0] }}-{{ $aspect }}" data-aspect="{{ $aspect }}" data-criteria="{{ $criteria[0] }}" data-value="{{ $value->id }}" @isset($content[$criteria[0]][$aspect]['variabel']) @if($content[$criteria[0]][$aspect]['variabel']==0 ) disabled style="background-color:grey;" @endif @else disabled style="background-color:grey;" @endif>
                            @isset($content[$criteria[0]][$aspect]['assessment'])
                            <option value="{{ $content[$criteria[0]][$aspect]['assessment'] }}"> {{ $content[$criteria[0]][$aspect]['assessment'] }} </option>
                            @endif
                            <option value=0>0</option>
                            <option value=1>1</option>
                        </select>
                        @endif
                    </td>
                    <td>
                        <input class="score" type="Text" size="2" id="{{ $criteria[0] }}-{{ $aspect }}" data-aspect="{{ $aspect }}" data-criteria="{{ $criteria[0] }}" data-value="{{ $value->id }}" @isset($content[$criteria[0]][$aspect]['variabel']) data-variabel="{{ $content[$criteria[0]][$aspect]['variabel'] }}" @endif @isset($content[$criteria[0]][$aspect]['score']) value="{{ $content[$criteria[0]][$aspect]['score'] }}" @endif disabled>
                    </td>
                    <td>
                        @foreach($files->where('personnel_evaluation_criteria_id', $criteria[0])->where('personnel_evaluation_aspect_id', $aspect) as $file)
                        @if(is_null($file->google))
                        @else
                        <a href="https://drive.google.com/file/d/{{$file->google->file_id}}/view" target="_blank">
                            @endif
                            bukti-{{ $loop->iteration }}
                        </a>
                        @endforeach
                    </td>
                    <td class="eachAspectsButton"><button type="button" class="eachAspects btn btn-primary" data-id="{{ $criteria[0] }}-{{ $aspect }}" data-value="{{ $value->id }}" data-aspect="{{ $aspect }}" data-criteria="{{ $criteria[0] }}">Simpan</button></td>
                    <td>
                        <div type="text" size="6" class="save text-center" id="{{ $criteria[0] }}-{{ $aspect }}" style="font-size: 20px;"></div>
                    </td>
                </tr>
                @endif
                @endforeach
                <tr>
                    <th class=" text-center" colspan="2">Jumlah</th>
                    <th class="text-center" id="sumVariabel{{ $criteria[0] }}">
                        @isset($content[$criteria[0]]['sumVariabel'])
                        {{ $content[$criteria[0]]['sumVariabel'] }}
                        @endif
                    </th>
                    <th colspan="2"></th>
                    <th data-proportion="{{ $criterias->find($criteria[0])->proportion }}" class="text-center" id="sumScores{{ $criteria[0] }}">
                        @isset($content[$criteria[0]]['sumScores'])
                        {{ $content[$criteria[0]]['sumScores'] }}
                        @endif
                    </th>
                    <th colspan="2"></th>
                </tr>
                @empty
                @endforelse
                <tr>
                    <th class="text-center" colspan="2">T O T A L</th>
                    <td class="text-center" id="totalVariabel">
                        @isset( $content['userTotalVariabel'] )
                        {{ $content['userTotalVariabel'] }}
                        @endif
                    </td>
                    <th colspan="2"></th>
                    <th class="text-center" id="totalScores">{{ $value->totalScore }}%</th>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <th colspan="2" style="border-color:transparent;"></th>
                    <th colspan="@if($value->user->id != Auth::user()->id) 5 @else 4 @endif" style="border-color:transparent;">
                    </th>
                </tr>
            </tbody>
        </table>

        <div class="row">

            <div class="col-md-6">
                <div>
                    REKOMENDASI PERBAIKAN
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="recommendation" data-value="{{ $value->id }}" rows="4">{{ $value->recommendation }}</textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div>
                    MASALAH DAN SARAN
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="issue" data-value="{{ $value->id }}" rows="4">{{ $value->issue }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-3" style="width:100%; border: 1px solid grey; border-radius: 5px; padding: 30px;">
            <div style="width: 600px; margin:auto;">
                <div class="row">
                    Status Blacklist
                </div>
                <div>
                    <input type="hidden" id="user_id" value="{{$value->user->id}}">
                    @foreach($blacklists as $blacklist)
                    <div class="form-check">
                        <input type="checkbox" id="blacklist" name="blacklists[]" data-id={{$blacklist->id}} value="{{ $blacklist->id}}" @if($value->user->blacklists->pluck('id')->contains($blacklist->id)) checked @endif >
                        <label>{{ $blacklist->categories }}</label>
                    </div>
                    @endforeach
                </div>

                <div style="width: 600px; margin:auto;">
                    <div class="row mt-1" style="background-color:#befc9f; padding:10px 0;">
                        <div class="col" style="font-weight: bold; font-size:14px;">
                            Hasil Akhir/Kualifikasi Kinerja
                        </div>
                        <div class="col">
                            <h6 id="finalResult" class="text-center" style="vertical-align: bottom;">
                                {{ $value->finalResult }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @if($value->ready == 0)

        <div id="check" class="text-center mt-5">
            <button id="check-button" data-value="{{ $value->id }}" type="submit" class="btn btn-primary">-- Lanjut --</button>
        </div>
        @elseif($value->ready == 1 && $value->edit == 0)
        <form method="get" action="/personnel-evaluation/assessor/assessment/input/{{ $value->id }}/edit" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary">AJUKAN PERMOHONAN EDIT</button>
            </div>
        </form>
        @elseif($value->edit == 1)
        <h6 class="text-center">Permohonan untuk edit telah diajukan</h6>
        @endif
    </div>
</div>

<script>
    $(document).ready(function() {
        var ready = $("div#ready").data('ready');
        if (ready == 1) {
            $("input[type=text]").attr('disabled', true)
            $("input[type=checkbox]").attr('disabled', true)
            $("input#checkbox").attr('disabled', true)
            $("select").attr('disabled', true)
            $(".eachAspectsButton").empty()
            $("textarea").attr('disabled', true)
        }
    });

    $("input#blacklist").click(function() {
        var blacklists = [];
        var user_id = $('#user_id').val();
        $("input#blacklist").each(function() {
            if ($(this).prop('checked')) {
                var blacklist_item = $(this).data('id');
                blacklists.push(blacklist_item);
            }
        });

        $.ajax({
            type: 'get',
            url: '/evkinja/blacklist',
            data: {
                'blacklist': blacklists,
                'user_id': user_id
            },
            success: function(data) {
                console.log(data);
            },
            error: function() {
                console.log('error');
            }
        });


        // console.log(blacklists);
    });

    $("#check-button").click(function() {
        var value = $(this).data('value');
        var totalVariabel = $("#totalVariabel").text();
        var totalScores = $("#totalScores").text();
        var sumScores1 = $("#sumScores1").text();
        var sumScores2 = $("#sumScores2").text();
        var sumScores3 = $("#sumScores3").text();
        var sumVariabel1 = $("#sumVariabel1").text();
        var sumVariabel2 = $("#sumVariabel2").text();
        var sumVariabel3 = $("#sumVariabel3").text();
        var kinerja = $("#finalResult").text();

        $.ajax({
            type: 'get',
            url: '/personnel-evaluation/assessor/assessment/input/{{ $value->id }}/check',
            data: {
                'value': value,
                'kinerja': kinerja,
                'totalVariabel': totalVariabel,
                'totalScores': totalScores,
                'sumScores1': sumScores1,
                'sumScores2': sumScores2,
                'sumScores3': sumScores3,
                'sumVariabel1': sumVariabel1,
                'sumVariabel2': sumVariabel2,
                'sumVariabel3': sumVariabel3
            },
            success: function(data) {
                console.log(data[0]);
                if (data[0] == 'ok') {
                    $("#check").empty();
                    $("#check").append('<p>Data sudah disimpan, klik lanjut</p>');
                    $("#check").append(
                        '<form method = "get" action = "/personnel-evaluation/assessor/assessment/input/{{ $value->id }}/ok" enctype = "multipart/form-data">@csrf' +
                        '<button type = "submit" class = "btn btn-primary" > Kirim Nilai </button></form>'
                    );
                } else {
                    $("#check").append('<p>Data gagal disimpan, klik Simpan pada setiap aspek penilaian</p>');
                    console.log('error');
                }
            },
            error: function() {
                $("#check").append('<p style="font-weight:bold; color: red;">Data gagal disimpan, Silahkan klik Simpan pada setiap aspek penilaian</p><p>Pastikan koneksi internet anda stabil</p>');
                console.log('failed');
            }
        });
    });

    $("input#team").keyup(function() {
        var team = $(this).val();
        var value = $(this).data('value');

        console.log(team);

        $.ajax({
            type: 'get',
            url: '/personnel-evaluation/assessor/assessment/input/{{ $value->id }}/team',
            data: {
                'value': value,
                'team': team
            },
            success: function() {
                console.log('success');
            },
            error: function() {
                console.log('error');
            }
        });
    });

    $("input#checkbox").click(function() {
        var id = $(this).data('id');
        var aspect = $(this).data('aspect');
        var criteria = $(this).data('criteria');
        var value = $(this).data('value');
        var team = $("input#team").val();

        if ($(this).prop('checked')) {
            var variabel = 1;
            if (criteria == 1) {
                var thisScore = ($("input[id=" + id + "].assessment").val() / 100).toFixed(2);
            } else {
                var thisScore = $("select[id=" + id + "].assessment").val();
            }
            $("input[id=" + id + "].assessment").prop('disabled', false);
            $("select[id=" + id + "].assessment").prop('disabled', false);
            $("input[id=" + id + "].evidences").prop('disabled', false);
            $("input[id=" + id + "].assessment").css('background-color', 'white');
            $("select[id=" + id + "].assessment").css('background-color', 'white');
            $("input[id=" + id + "].evidences").css('background-color', 'white');
            $("input[id=" + id + "]").css('color', 'black');
            $("input[id=" + id + "].score").css('color', 'red');
            $("input[id=" + id + "].score").attr('data-variabel', '1');
            $("td div[id=" + id + "].save").text('Klik Simpan');
            $("td div[id=" + id + "].save").css('background-color', 'white');
            $("td div[id=" + id + "].save").css('color', 'black');
            $("input[id=" + id + "].score").val(thisScore);
        } else {
            var variabel = 0;
            $("input[id=" + id + "].assessment").prop('disabled', true);
            $("select[id=" + id + "].assessment").prop('disabled', true);
            $("input[id=" + id + "].evidences").prop('disabled', true);
            $("input[id=" + id + "].assessment").css('background-color', 'grey');
            $("select[id=" + id + "].assessment").css('background-color', 'grey');
            $("input[id=" + id + "].evidences").css('background-color', 'grey');
            $("input[id=" + id + "]").css('color', 'grey');
            $("input[id=" + id + "].score").attr('data-variabel', '0');
            $("td div[id=" + id + "].save").text('Klik Simpan');
            $("td div[id=" + id + "].save").css('background-color', 'white');
            $("td div[id=" + id + "].save").css('color', 'black');
            $("input[id=" + id + "].score").val('');
        }

        var totalScores = 0;
        for (i = 1; i < 4; i++) {
            var sumScores = 0;
            $("input[data-variabel='1'][data-criteria=" + i + "].score").each(function() {
                var assessmentValue = $(this).val();
                if ($.isNumeric(assessmentValue)) {
                    sumScores += parseFloat(assessmentValue);
                }
            });

            var variabel_length = $("input[data-criteria='" + i + "']#checkbox:checked").length;
            var proportion = $("#sumScores" + i).data('proportion');

            $("#sumVariabel" + i).text(variabel_length);
            $("#sumScores" + i).text(sumScores.toFixed(2));

            if (variabel_length > 0) {
                var allScores = parseFloat(sumScores * proportion / variabel_length);
            } else {
                var allScores = 0;
            }
            totalScores += parseFloat(allScores);
        }

        if (parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75) {
            var kinerja = "Tercapai";
        } else if (parseFloat(totalScores) >= 75) {
            var kinerja = "Sangat Baik";
        } else {
            var kinerja = "Tidak Tercapai";
        }

        $("h6#finalResult").text(kinerja);

        var totalVariabel = $("input#checkbox:checked").length;
        $("#totalVariabel").text(totalVariabel);
        $("#totalScores").text(totalScores.toFixed(2) + '%');

        var score = $("#" + id + ".score").val();
        var assessment = $("#" + id + ".assessment").val();
        var totalVariabel = $("#totalVariabel").text();
        var totalScores = $("#totalScores").text();
        var sumScores1 = $("#sumScores1").text();
        var sumScores2 = $("#sumScores2").text();
        var sumScores3 = $("#sumScores3").text();
        var sumVariabel1 = $("#sumVariabel1").text();
        var sumVariabel2 = $("#sumVariabel2").text();
        var sumVariabel3 = $("#sumVariabel3").text();

        $.ajax({
            type: 'get',
            url: '/personnel-evaluation/assessor/assessment/input/{{ $value->id }}/save',
            data: {
                'criteria': criteria,
                'aspect': aspect,
                'value': value,
                'team': team,
                'variabel': variabel,
                'kinerja': kinerja,
                'totalScores': totalScores,
                'score': score,
                'assessment': assessment,
                'totalVariabel': totalVariabel,
                'sumScores1': sumScores1,
                'sumScores2': sumScores2,
                'sumScores3': sumScores3,
                'sumVariabel1': sumVariabel1,
                'sumVariabel2': sumVariabel2,
                'sumVariabel3': sumVariabel3
            },

            success: function(data) {
                console.log(data);
            }
        });

    });

    $("input[type=text].assessment").keyup(function() {
        var criteria = $(this).data('criteria');
        var aspect = $(this).data('aspect');
        var value = $(this).data('value');
        var team = $("input#team").val();
        var assessment = $(this).val();
        var score = (assessment / 100).toFixed(2);

        var id = "#" + criteria + '-' + aspect;
        $("td div" + id + ".save").text('Klik Simpan');
        $("td div" + id + ".save").css('background-color', 'white');
        $("td div" + id + ".save").css('color', 'black');

        $(id + ".score").val(score);

        var totalScores = 0;
        for (i = 1; i < 4; i++) {
            var sumScores = 0;
            $("input[data-variabel='1'][data-criteria=" + i + "].score").each(function() {
                var assessmentValue = $(this).val();
                if ($.isNumeric(assessmentValue)) {
                    sumScores += parseFloat(assessmentValue);
                }
            });

            var variabel = $("input[data-criteria='" + i + "']#checkbox:checked").length;
            var proportion = $("#sumScores" + i).data('proportion');
            $("#sumScores" + i).text(sumScores.toFixed(2));
            $("#sumVariabel" + i).text(variabel);

            if (variabel > 0) {
                var allScores = parseFloat(sumScores * proportion / variabel);
            } else {
                var allScores = 0;
            }
            totalScores += parseFloat(allScores);
        }

        $("#totalScores").text(totalScores.toFixed(2) + '%');

        if (parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75) {
            var kinerja = "Tercapai";
        } else if (parseFloat(totalScores) >= 75) {
            var kinerja = "Sangat Baik";
        } else {
            var kinerja = "Tidak Tercapai";
        }

        $("h6#finalResult").text(kinerja);
        var totalVariabel = $("#totalVariabel").text();
        var totalScores = $("#totalScores").text();
        var sumScores1 = $("#sumScores1").text();
        var sumScores2 = $("#sumScores2").text();
        var sumScores3 = $("#sumScores3").text();
        var sumVariabel1 = $("#sumVariabel1").text();
        var sumVariabel2 = $("#sumVariabel2").text();
        var sumVariabel3 = $("#sumVariabel3").text();

        $.ajax({
            type: 'get',
            url: '/personnel-evaluation/assessor/assessment/input/{{ $value->id }}/save',
            data: {
                'team': team,
                'totalScores': totalScores,
                'variabel': 1,
                'kinerja': kinerja,
                'criteria': criteria,
                'aspect': aspect,
                'value': value,
                'assessment': assessment,
                'score': score,
                'totalVariabel': totalVariabel,
                'sumScores1': sumScores1,
                'sumScores2': sumScores2,
                'sumScores3': sumScores3,
                'sumVariabel1': sumVariabel1,
                'sumVariabel2': sumVariabel2,
                'sumVariabel3': sumVariabel3,
            },

            success: function(data) {
                console.log(data);
            }
        });

    });

    $("button.eachAspects").click(function() {
        var id = $(this).data('id');
        var value = $(this).data('value');
        var team = $("input#team").val();
        var criteria = $(this).data('criteria');
        var aspect = $(this).data('aspect');
        var score = $("#" + id + ".score").val();
        var assessment = $("#" + id + ".assessment").val();
        var totalVariabel = $("#totalVariabel").text();
        var totalScores = $("#totalScores").text();
        var sumScores1 = $("#sumScores1").text();
        var sumScores2 = $("#sumScores2").text();
        var sumScores3 = $("#sumScores3").text();
        var sumVariabel1 = $("#sumVariabel1").text();
        var sumVariabel2 = $("#sumVariabel2").text();
        var sumVariabel3 = $("#sumVariabel3").text();
        var kinerja = $("#finalResult").text();

        if ($("#checkbox[data-id='" + id + "']").prop('checked')) {
            var variabel = 1;
        } else {
            var variabel = 0;
        }

        $.ajax({
            type: 'get',
            url: '/personnel-evaluation/assessor/assessment/input/{{ $value->id }}/save',
            data: {
                'value': value,
                'team': team,
                'criteria': criteria,
                'aspect': aspect,
                'assessment': assessment,
                'score': score,
                'assessment': assessment,
                'totalVariabel': totalVariabel,
                'totalScores': totalScores,
                'sumScores1': sumScores1,
                'sumScores2': sumScores2,
                'sumScores3': sumScores3,
                'sumVariabel1': sumVariabel1,
                'sumVariabel2': sumVariabel2,
                'sumVariabel3': sumVariabel3,
                'variabel': variabel,
                'kinerja': kinerja
            },

            success: function(data) {
                console.log(data);
                $("td div[id=" + id + "].save").text('OK');
                $("td div[id=" + id + "].save").css('background-color', 'green');
                $("td div[id=" + id + "].save").css('color', 'white');
            },

            error: function() {
                $("td div[id=" + id + "].save").text('Gagal');
                $("td div[id=" + id + "].save").css('background-color', 'red');
                $("td div[id=" + id + "].save").css('color', 'white');
            }
        });

    });

    $("select.assessment").change(function() {
        var criteria = $(this).data('criteria');
        var aspect = $(this).data('aspect');
        var value = $(this).data('value');
        var team = $("input#team").val();
        var assessment = $(this).val();
        var score = assessment;

        var id = "#" + criteria + '-' + aspect;
        $("td div" + id + ".save").text('Klik Simpan');
        $("td div" + id + ".save").css('background-color', 'white');
        $("td div" + id + ".save").css('color', 'black');

        $(id + ".score").val(score);

        var totalScores = 0;
        for (i = 1; i < 4; i++) {
            var sumScores = 0;
            $("input[data-variabel='1'][data-criteria=" + i + "].score").each(function() {
                var assessmentValue = $(this).val();
                if ($.isNumeric(assessmentValue)) {
                    sumScores += parseFloat(assessmentValue);
                }
            });

            var variabel = $("input[data-criteria='" + i + "']#checkbox:checked").length;
            var proportion = $("#sumScores" + i).data('proportion');
            $("#sumScores" + i).text(sumScores.toFixed(2));
            $("#sumVariabel" + i).text(variabel);

            if (variabel > 0) {
                var allScores = parseFloat(sumScores * proportion / variabel);
            } else {
                var allScores = 0;
            }
            totalScores += parseFloat(allScores);
        }

        $("#totalScores").text(totalScores.toFixed(2) + '%');

        if (parseFloat(totalScores) >= 50 && parseFloat(totalScores) < 75) {
            var kinerja = "Tercapai";
        } else if (parseFloat(totalScores) >= 75) {
            var kinerja = "Sangat Baik";
        } else {
            var kinerja = "Tidak Tercapai";
        }

        $("h6#finalResult").text(kinerja);
        var totalVariabel = $("#totalVariabel").text();
        var userTotalScores = $("#totalScores").text();
        var sumScores1 = $("#sumScores1").text();
        var sumScores2 = $("#sumScores2").text();
        var sumScores3 = $("#sumScores3").text();
        var sumVariabel1 = $("#sumVariabel1").text();
        var sumVariabel2 = $("#sumVariabel2").text();
        var sumVariabel3 = $("#sumVariabel3").text();

        $.ajax({
            type: 'get',
            url: '/personnel-evaluation/assessor/assessment/input/{{ $value->id }}/save',
            data: {
                'team': team,
                'totalScores': userTotalScores,
                'kinerja': kinerja,
                'criteria': criteria,
                'variabel': 1,
                'aspect': aspect,
                'value': value,
                'assessment': assessment,
                'score': score,
                'totalVariabel': totalVariabel,
                'sumScores1': sumScores1,
                'sumScores2': sumScores2,
                'sumScores3': sumScores3,
                'sumVariabel1': sumVariabel1,
                'sumVariabel2': sumVariabel2,
                'sumVariabel3': sumVariabel3,
            },

            success: function(data) {
                console.log(data);
            }
        });
    });

    $("textarea").change(function() {
        var recommendation = $("#recommendation").val();
        var issue = $("#issue").val();
        var value = $(this).data('value');

        $.ajax({
            type: 'get',
            url: '/personnel-evaluation/assessor/assessment/input/{{ $value->id }}/textarea',
            data: {
                'recommendation': recommendation,
                'issue': issue,
                'value': value
            },
            success: function() {
                console.log('success');
            },
            error: function() {
                console.log('error');
            }
        });
    });
</script>
@endsection
