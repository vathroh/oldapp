@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Evaluasi Kinerja</h4>
        <p class="card-category"></p>
    </div>
    <div class="card-body">
        @include('personnelEvaluation.navbar')

        @if($myEvaluationValues->count() == 0 && $lastSetting->where('jobTitleId', Auth::user()->jobDesc()->get()->first()->job_title_id)->count() > 0 )
        <div class="my-3 text-center" style="border: 2px solid red; border-radius: 5px; padding: 20px;">
            <h5 style="color:red;">Anda Belum Mengisi Evaluasi Kinerja. </h5>
            <a href="/personnel-evaluation-input/{{ $myEvaluationSetting->pluck('id')->first() }}/{{ Auth::user()->id }}"><button class="btn btn-danger">Isi sekarang</button></a>
        </div>

        @elseif($myEvaluationValues->count() > 0 )

        <div class="my-3 text-center" style="border: 2px solid grey; border-radius: 5px; padding: 20px;">
            <h5 style="color:grey;">
                Evaluasi Kinerja Kuartal {{ $lastQuarter }} Tahun {{ $lastYear }}
                @if($myEvaluationValues->get()->first()->ok_by_user == 1 )
                Sudah Selesai
                @else
                <span style="color:red">Belum Selesai</span>
                @endif
                Diinput.
            </h5>
            <a href="/personnel-evaluation-input/{{ $myEvaluationSetting->pluck('id')->first() }}/{{ Auth::user()->id }}">
                @if($myEvaluationValues->get()->first()->ok_by_user == 1 )
                <button class="btn btn-primary">Lihat</button>
                @else
                <button class="btn btn-success">Selesaikan</button>
                @endif
            </a>
        </div>
        @endif

        @if($evaluators->count() > 0)

        <div class="table-responsive tableFixHead">
            <table class="table table-bordered">
                <thead class=" text-primary text-center">
                    <tr class="text-center" style="background-color: purple; color:white;">
                        <!-- <th rowspan="2">Kuartal | Tahun</th> -->
                        <th rowspan="2">Posisi Yang Dievaluasi</th>
                        <th rowspan="2">Jumlah Personil</th>
                        <th colspan="3">Personil</th>

                        <th colspan="3">Tim Penilai</th>
                    </tr>
                    <tr class="text-center" style="background-color: purple; color:white;">
                        <th>Belum Mengisi</th>
                        <th>Proses</th>
                        <th>Selesai Mengisi</th>
                        <!--						<th>Belum Dievaluasi</th> -->
                        <th>Siap Dievaluasi</th>
                        <th>Sedang Dievaluasi</th>
                        <th>Selesai Dievaluasi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(Auth::user()->posisi->level === "OSP" )

                    @foreach($evaluators as $evaluator)
                    <tr>
                        <td>{{ $evaluator->jabatanYangDinilai->job_title }}</td>
                        <td>
                            <a href="/personnel-evaluation-home-osp/{{ $evaluator->jobId }}/semua-personil">
                                {{ $evaluator->user->count() }}
                            </a>
                        </td>
                        <td>
                            <a href="/personnel-evaluation-home-osp/{{ $evaluator->jobId }}/belum-mengisi-evkinja">
                                {{ $evaluator->user->count() - $evaluator->value->count() }}
                            </a>
                        </td>
                        <td>
                            <a href="/personnel-evaluation-home-osp/{{ $evaluator->jobId }}/proses">
                                {{ $evaluator->value->where('ok_by_user', 0)->count() }}
                            </a>
                        </td>
                        <td>
                            <a href="/personnel-evaluation-home-osp/{{ $evaluator->jobId }}/selesai">
                                {{ $evaluator->value->where('ok_by_user', 1)->count() }}
                            </a>
                        </td>
                        <td>
                            <a href="/personnel-evaluation-home-osp/{{ $evaluator->jobId }}/siap-dievaluasi">
                                {{ $evaluator->value->where('ok_by_user', 1)->where('totalScore', '=', '0.00')->count() }}
                            </a>
                        </td>
                        <td>
                            <a href="/personnel-evaluation-home-osp/{{ $evaluator->jobId }}/sedang-dievaluasi">
                                {{ $evaluator->value->where('ready', 0)->where('totalScore', '!=', '0.00')->where('ok_by_user', 1)->count() }}
                            </a>
                        </td>
                        <td>
                            <a href="/personnel-evaluation-home-osp/{{ $evaluator->jobId }}/selesai-dievaluasi">
                                {{ $evaluator->value->where('ready', 1)->count() }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    @for( $i = 0; $i < count($myZones); $i++) <tr>
                        <td colspan="10"> {{ $allvillages->where('KD_KAB', $myZones[$i])->first()->NAMA_KAB }}</td>
                        </tr>

                        @foreach($evaluators as $evaluator)
                        <tr>
                            <!--
						<td>
							Kuartal  Tahun 
						</td>
					-->
                            <td>
                                {{ $evaluator->jabatanYangDinilai()->pluck('job_title')->first() }}
                            </td>

                            <td class="text-center">
                                {{ count($evaluationValues[$myZones[$i]][$evaluator->jobId]['Personil']) }}
                            </td>

                            <td class="text-center">
                                <a href="/personnel-evaluation-home/{{ $myZones[$i] }}/{{ $evaluator->jobId }}/belum-mengisi-evkinja">
                                    {{ count($evaluationValues[$myZones[$i]][$evaluator->jobId]['BelumMengisi']) }}
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="/personnel-evaluation-home/{{ $myZones[$i] }}/{{ $evaluator->jobId }}/sedang-mengisi-evkinja">
                                    {{ count($evaluationValues[$myZones[$i]][$evaluator->jobId]['ProsesMengisi']) }}
                                </a>
                            </td>


                            <td class="text-center">
                                <a href="/personnel-evaluation-home/{{ $myZones[$i] }}/{{ $evaluator->jobId }}/sudah-mengisi-evkinja">
                                    {{ count($evaluationValues[$myZones[$i]][$evaluator->jobId]['SelesaiMengisi']) }}
                                </a>
                            </td>
                            <!-- /*
						<td class="text-center">
								{{ count($evaluationValues[$myZones[$i]][$evaluator->jobId]['BelumDievaluasi']) }}
						</td>
*/						-->
                            <td class="text-center" style="color:red; font-weight:bold;">
                                <a href="/personnel-evaluation-home/{{ $myZones[$i] }}/{{ $evaluator->jobId }}/siap-dievaluasi">
                                    {{ count($evaluationValues[$myZones[$i]][$evaluator->jobId]['SiapDievaluasi']) }}
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="/personnel-evaluation-home/{{ $myZones[$i] }}/{{ $evaluator->jobId }}/sedang-dievaluasi">
                                    {{ count($evaluationValues[$myZones[$i]][$evaluator->jobId]['ProsesDievaluasi']) }}
                                </a </td>

                            <td class="text-center">
                                <a href="/personnel-evaluation-home/{{ $myZones[$i] }}/{{ $evaluator->jobId }}/selesai-dievaluasi">
                                    {{ count($evaluationValues[$myZones[$i]][$evaluator->jobId]['SelesaiDievaluasi']) }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @endfor
                        @endif
                </tbody>
            </table>
            @endif
        </div>

    </div>
</div>

@endsection