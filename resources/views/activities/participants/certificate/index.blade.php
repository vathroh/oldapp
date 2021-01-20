@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">{{ $activities->where('id', $activity_item)->pluck('name')->first() }}</h4>
    </div>
    @include('activities.participants.navbar')
    <div class="card-body">
        <div class="mt-5">

            <form method="post" action="/certificate/{{$subjects[0]->activity_id}}">
                <div style="width:100%;" class="text-center">

                    //Show Download button for Pemandu or Panitia
                    @if($role =="PEMANDU" OR $role =="PANITIA")
                    <button type="submit" class="btn btn-primary">Download Sertifikat</button>
                    @endif

                    //button Download untuk peserta yang memnuhi persyaratan.
                    @if($role =="PEMANDU" OR $role =="PANITIA")
                    <button type="submit" class="btn btn-primary">Download Sertifikat</button>
                    @endif
                </div>
            </form>


            @php
            $jml_hadir = 0 ;
            for($i=0; $i<$period; $i++){ $tanggal=Carbon\Carbon::parse($start); $day=$tanggal->addDays($i);
                $day1 = $day->format('Y-m-d');
                $hadir = $attendances->where('tanggal', $day1)->where('id', Auth::user()->id )->count();
                $jml_hadir += $hadir;
                }
                $isEvaluation = 0;
                $jml_subject = $subjects->where('evaluation_sheet', 1)->count();
                @endphp
                @foreach($subjects->where('evaluation_sheet', 1) as $subject)
                @php
                $evaluation = $evaluations->where('subject_id', $subject->id)->where('id', Auth::user()->id )->unique('subject_id')->count();
                $isEvaluation += $evaluation;
                @endphp
                @endforeach

                <form method="post" action="/certificate/{{$subjects[0]->activity_id}}">
                    <div style="width:100%;" class="text-center">
                        @csrf
                        @if($role =="PESERTA" and $blacklists->where('user_id', Auth::user()->id)->count() == 0 )
                        @if($jml_hadir == $period and $isEvaluation == $jml_subject)
                        <button type="submit" class="btn btn-primary">Download Sertifikat</button>
                        @endif
                        @endif






                        @if($role =="PEMANDU" OR $role =="PANITIA")
                        <button type="submit" class="btn btn-primary">Download Sertifikat</button>
                        @endif
                    </div>
                </form>

                <p class="mt-5 text-center">Bagi Perserta: Silahkan isi Daftar Hadir dan Evaluasi Belajar untuk memunculkan tombol download sertifikat.</p>

                @if($role =="PESERTA")
                <table class="table table-striped table-bordered mt-5">
                    <thead class="thead-dark">
                        <tr>
                            <td class="text-center">Hari, Tanggal</td>
                            <td class="text-center">Daftar Hadir</td>
                        </tr>
                    </thead>

                    <tbody>
                        @for($i=0; $i<$period; $i++) @php $tanggal=Carbon\Carbon::parse($start); $day=$tanggal->addDays($i);
                            $day1 = $day->format('Y-m-d');
                            @endphp

                            <tr>
                                <td>{{ $day->format('l, d F Y') }}</td>
                                <td>@if($attendances->where('tanggal', $day1)->where('id', Auth::user()->id )->count() > 0) Mengisi daftar hadir @else <span style="color:red; font-weght:bold;">Tidak mengisi daftar hadir @endif</span></td>
                            </tr>
                            @endfor
                    </tbody>
                </table>

                <table class="table table-striped table-bordered mt-5">
                    <thead class="thead-dark">
                        <tr>
                            <td class="text-center">No</td>
                            <td class="text-center">Materi</td>
                            <td class="text-center">Evaluasi Belajar</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjects->where('evaluation_sheet', 1) as $subject)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $subject->subject }}</td>
                            <td>@if($evaluations->where('subject_id', $subject->id)->where('id', Auth::user()->id )->count() > 0) Sudah mengisi Lembar Evaluasi Belajar. @else <span style="color:red; font-weght:bold;"> Belum mengisi Lembar Evaluasi Belajar. </span> <a href="/training-evaluation/{{$subject->activity_id}}/{{$subject->id}}">Isi sekarang? </a>@endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    <div>
                        <h5>Catatan Tambahan</h5>
                    </div>
                    @if($blacklists->where('user_id', Auth::user()->id)->count() > 0)
                    <div style="color:red; font-weight:bold;">
                        <ul>
                            <li>

                                {{ $blacklists->where('user_id', Auth::user()->id )->first()->reason }}

                        </ul>
                        </li>
                    </div>
                    @endif
                </div>

                @endif
        </div>
    </div>
    @endsection

    @section('script')
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
    @endsection