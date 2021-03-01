@extends('layouts.MaterialDashboard')



@section('content')
<div class="card">

    <div class="card-header card-header-primary">
        <h4 class="card-title ">Evaluasi Kinerja</h4>
        <p class="card-category">Kriteria</p>
    </div>

    <div class="card-body">
        @include('personnelEvaluation.navbar')

        <div id="ready" class="form-group text-center my-3" data-readyByUser="{{ $value->ok_by_user }}" data-ready="{{ $value->ready }}">
            <h4>Evaluasi Kinerja {{ $value->evaluationSetting->jobTitle->job_title }}</h4>
            <h4>Kuartal {{ $value->evaluationSetting->pluck('quarter')->first() }} Tahun {{ $value->evaluationSetting->pluck('year')->first() }}</h4>
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
                    <h6>: <input type="text" id="team" data-value="{{ $value->id }}" value="{{ $value->team }}"></h6>
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
        <a href="/personnel-evaluation-upload/{{ $value->id }}" target="_blank"><button type="submit" class="btn btn-primary" style="float: right;">Upload Bukti PEnilaian</button></a>

        <table class=" table table-bordered" style="width:100%;">
            <thead>
                <tr>
                    <th class="text-center" scope="col">No</th>
                    <th class="text-center" scope="col">Aspek Kinerja</th>
                    <th class="text-center" scope="col">Variabel Target</th>
                    <th class="text-center" scope="col">Tercapai %</th>
                    <th class="text-center" scope="col">Skor</th>
                    <th class="text-center" scope="col">Simpan</th>
                    <th class="text-center" scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>

                @forelse(collect(unserialize($value->evaluationSetting->aspectId)) as $criteria)
                <tr style="background-color:#c2f0fc;">
                    <td colspan="7">{{ $criterias->find($criteria[0])->criteria }}</td>
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
                        <input class="capaian input" type="Text" size="3" id="{{ $criteria[0] }}-{{ $aspect }}" data-aspect="{{ $aspect }}" data-criteria="{{ $criteria[0] }}" data-value="{{ $value->id }}" @isset($content[$criteria[0]][$aspect]['variabel']) @if($content[$criteria[0]][$aspect]['variabel']==0 ) disabled style="background-color:grey;" @endif @else disabled style="background-color:grey;" @endif @isset($content[$criteria[0]][$aspect]['capaian']) value="{{ $content[$criteria[0]][$aspect]['capaian'] }}" @endif>
                        @else
                        <select class="capaian select" type="Text" id="{{ $criteria[0] }}-{{ $aspect }}" data-aspect="{{ $aspect }}" data-criteria="{{ $criteria[0] }}" data-value="{{ $value->id }}" @isset($content[$criteria[0]][$aspect]['variabel']) @if($content[$criteria[0]][$aspect]['variabel']==0 ) disabled style="background-color:grey;" @endif @else disabled style="background-color:grey;" @endif>
                            @isset($content[$criteria[0]][$aspect]['capaian'])
                            <option value="{{ $content[$criteria[0]][$aspect]['capaian'] }}"> {{ $content[$criteria[0]][$aspect]['capaian'] }} </option>
                            @endif
                            <option value=0>0</option>
                            <option value=1>1</option>
                        </select>
                        @endif
                    </td>
                    <td>
                        <input class="score" type="Text" size="3" id="{{ $criteria[0] }}-{{ $aspect }}" data-aspect="{{ $aspect }}" data-criteria="{{ $criteria[0] }}" data-value="{{ $value->id }}" @isset($content[$criteria[0]][$aspect]['variabel']) data-variabel="{{ $content[$criteria[0]][$aspect]['variabel'] }}" @endif @isset($content[$criteria[0]][$aspect]['userScore']) value="{{ $content[$criteria[0]][$aspect]['userScore'] }}" @endif disabled>
                    </td>
                    <td class="eachAspectsButton"><button type=" button" class="eachAspects btn btn-primary" data-id="{{ $criteria[0] }}-{{ $aspect }}" data-value="{{ $value->id }}" data-aspect="{{ $aspect }}" data-criteria="{{ $criteria[0] }}">Simpan</button></td>
                    <td>
                        <div type="text" size="6" class="save text-center" id="{{ $criteria[0] }}-{{ $aspect }}" style="font-size: 20px;"></div>
                    </td>
                </tr>
                @endif
                @endforeach
                <tr>
                    <th class=" text-center" colspan="2">Jumlah</th>
                    <th class="text-center" id="sumVariabel{{ $criteria[0] }}">
                        @isset($content[$criteria[0]]['userSumVariabel'])
                        {{ $content[$criteria[0]]['userSumVariabel'] }}
                        @endif
                    </th>
                    <th></th>
                    <th data-proportion="{{ $criterias->find($criteria[0])->proportion }}" class="text-center" id="sumScores{{ $criteria[0] }}">
                        @isset($content[$criteria[0]]['userSumScores'])
                        {{ $content[$criteria[0]]['userSumScores'] }}
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
                    <th></th>
                    <th class="text-center" id="totalScores">{{ $value->userTotalScore }}%</th>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <th colspan="2" style="border-color:transparent;"></th>
                    <th colspan="@if($value->user->id != Auth::user()->id) 5 @else 4 @endif" style="border-color:transparent;">
                    </th>
                </tr>
            </tbody>
        </table>

        <div class="mt-3" style="width:100%; border: 1px solid grey; border-radius: 5px; padding: 30px;">
            <div style="width: 600px; margin:auto;">
                <div class="row mt-1" style="background-color:#befc9f; padding:10px 0;">
                    <div class="col" style="font-weight: bold; font-size:14px;">
                        Hasil Akhir/Kualifikasi Kinerja
                    </div>
                    <div class="col">
                        <h6 id="finalResult" class="text-center" style="vertical-align: bottom;">
                            {{ $value->userFinalResult }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        @if($value->ok_by_user == 0)
        <!-- <form method="get" action="/personnel-evaluation/being-assessed/achievement/{{ $value->id }}/check" enctype="multipart/form-data"> -->
        <!-- <form method="post" action="/personnel-evaluation-value-ready-user/{{ $value->id }}" enctype="multipart/form-data"> --> @csrf
        <div id="check" class="text-center mt-5">

            <button id="check-button" data-value="{{ $value->id }}" type="submit" class="btn btn-primary">---- O K ----</button>
        </div>
        <!-- </form> -->
        @elseif($value->ok_by_user == 1 && $value->edit_by_user == 0)
        <form method="post" action="/personnel-evaluation-value-not-ready-user/{{ $value->id }}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary">AJUKAN PERMOHONAN EDIT</button>
            </div>
        </form>
        @elseif($value->edit_by_user == 1)
        <h6 class="text-center">Permohonan untuk edit telah diajukan</h6>
        @endif
    </div>
</div>


<script>
    $(document).ready(function() {
        var ready_by_user = $("div#ready").data('readybyuser');
        if (ready_by_user == 1) {
            $("input[type=text]").attr('disabled', true)
            $("input#checkbox").attr('disabled', true)
            $("select").attr('disabled', true)
            $(".eachAspectsButton").empty()
        }
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
            url: '/personnel-evaluation/being-assessed/achievement/{{ $value->id }}/check',
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
                    $("#check").append('<p>Data sudah disimpan, lanjut kirim nilai.</p>');
                    $("#check").append(
                        '<form method = "post" action = "/personnel-evaluation/being-assessed/achievement/{{ $value->id }}/ok" enctype = "multipart/form-data">@csrf' +
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

        $.ajax({
            type: 'get',
            url: '/personnel-evaluation/being-assessed/achievement/' + value + '/team',
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
                var thisScore = ($("input[id=" + id + "].capaian").val() / 100).toFixed(2);
            } else {
                var thisScore = $("select[id=" + id + "].capaian").val();
            }
            $("input[id=" + id + "].capaian").prop('disabled', false);
            $("select[id=" + id + "].capaian").prop('disabled', false);
            $("input[id=" + id + "].evidences").prop('disabled', false);
            $("input[id=" + id + "].capaian").css('background-color', 'white');
            $("select[id=" + id + "].capaian").css('background-color', 'white');
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
            $("input[id=" + id + "].capaian").prop('disabled', true);
            $("select[id=" + id + "].capaian").prop('disabled', true);
            $("input[id=" + id + "].evidences").prop('disabled', true);
            $("input[id=" + id + "].capaian").css('background-color', 'grey');
            $("select[id=" + id + "].capaian").css('background-color', 'grey');
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
                var assesmentValue = $(this).val();
                if ($.isNumeric(assesmentValue)) {
                    sumScores += parseFloat(assesmentValue);
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
        var capaian = $("#" + id + ".capaian").val();
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
            url: '/personnel-evaluation/being-assessed/achievement/{{ $value->id }}/save',
            data: {
                'criteria': criteria,
                'aspect': aspect,
                'value': value,
                'team': team,
                'variabel': variabel,
                'kinerja': kinerja,
                'totalScores': totalScores,
                'score': score,
                'capaian': capaian,
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

    $("input[type=text].capaian").keyup(function() {
        var criteria = $(this).data('criteria');
        var aspect = $(this).data('aspect');
        var value = $(this).data('value');
        var team = $("input#team").val();
        var capaian = $(this).val();
        var score = (capaian / 100).toFixed(2);

        var id = "#" + criteria + '-' + aspect;
        $("td div" + id + ".save").text('Klik Simpan');
        $("td div" + id + ".save").css('background-color', 'white');
        $("td div" + id + ".save").css('color', 'black');

        $(id + ".score").val(score);

        var totalScores = 0;
        for (i = 1; i < 4; i++) {
            var sumScores = 0;
            $("input[data-variabel='1'][data-criteria=" + i + "].score").each(function() {
                var assesmentValue = $(this).val();
                if ($.isNumeric(assesmentValue)) {
                    sumScores += parseFloat(assesmentValue);
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
            url: '/personnel-evaluation/being-assessed/achievement/{{ $value->id }}/save',
            data: {
                'team': team,
                'totalScores': userTotalScores,
                'variabel': 1,
                'kinerja': kinerja,
                'criteria': criteria,
                'aspect': aspect,
                'value': value,
                'capaian': capaian,
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
        var capaian = $("#" + id + ".capaian").val();
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
            url: '/personnel-evaluation/being-assessed/achievement/{{ $value->id }}/save',
            data: {
                'value': value,
                'team': team,
                'criteria': criteria,
                'aspect': aspect,
                'capaian': capaian,
                'score': score,
                'capaian': capaian,
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

    $("select.capaian").change(function() {
        var criteria = $(this).data('criteria');
        var aspect = $(this).data('aspect');
        var value = $(this).data('value');
        var team = $("input#team").val();
        var capaian = $(this).val();
        var score = capaian;

        var id = "#" + criteria + '-' + aspect;
        $("td div" + id + ".save").text('Klik Simpan');
        $("td div" + id + ".save").css('background-color', 'white');
        $("td div" + id + ".save").css('color', 'black');

        $(id + ".score").val(score);

        var totalScores = 0;
        for (i = 1; i < 4; i++) {
            var sumScores = 0;
            $("input[data-variabel='1'][data-criteria=" + i + "].score").each(function() {
                var assesmentValue = $(this).val();
                if ($.isNumeric(assesmentValue)) {
                    sumScores += parseFloat(assesmentValue);
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
            url: '/personnel-evaluation/being-assessed/achievement/{{ $value->id }}/save',
            data: {
                'team': team,
                'totalScores': userTotalScores,
                'kinerja': kinerja,
                'criteria': criteria,
                'variabel': 1,
                'aspect': aspect,
                'value': value,
                'capaian': capaian,
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
</script>

@endsection