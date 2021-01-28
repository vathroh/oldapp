@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">{{ $activity->name }}</h4>
    </div>
    @include('activities.participants.navbar')
    <div class="card-body">
        <div class="mt-5">
            @if($certificate == "berhak" AND Auth::User()->ActivityBlackList->where('activity_id', $id)->count() == 0)
            <form method="post" action="/kegiatan/peserta/download-sertifikat/{{ $activity->id }}">
                @csrf
                <div style="width:100%;" class="text-center">
                    <button type="submit" class="btn btn-primary">Download Sertifikat</button>
                </div>
            </form>
            @endif

            <p class="mt-5 text-center">Silahkan isi Daftar Hadir dan Evaluasi Belajar untuk memunculkan tombol download sertifikat.</p>

            <table class="table table-striped table-bordered mt-5">
                <thead class="thead-dark">
                    <tr>
                        <td class="text-center">Hari, Tanggal</td>
                        <td class="text-center">Daftar Hadir</td>
                    </tr>
                </thead>

                <tbody>
                    @for( $i = 0; $i <= Carbon\carbon::parse($activity->start_date)->diffInDays($activity->finish_date); $i++ )
                        <tr>
                            <td>
                                {{ Carbon\carbon::parse($activity->start_date)->addDays($i)->format('l, d F Y') }}
                            </td>
                            <td>
                                @if($attendances->where('tanggal', Carbon\carbon::parse($activity->start_date)->addDays($i)->format('Y-m-d'))->count() > 0)
                                Hadir
                                @else
                                Tidak/Belum Mengisi Daftar Hadir
                                @endif
                            </td>
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
                    @foreach($activity->subjects->where('evaluation_sheet', 1) as $subject)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subject->subject }}</td>
                        <td>
                            @if( Auth::User()->ActivityEvaluations->where('activity_id', $activity->id )->where('subject_id', $subject->id )->count() >0 )
                            Sudah Mengisi
                            @else
                            Belum Mengisi. <a href="/training-evaluation/{{ $activity->id }}/{{ $subject->id }}">Isi sekarang?<a>
                                    @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <div>
                    <h5>Catatan Tambahan</h5>
                </div>

                <div style="color:red; font-weight:bold;">
                    <ul>
                        @foreach( Auth::User()->ActivityBlackList->where('activity_id', $id) as $blackList)
                        <li>
                            {{ $blackList->reason }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
    @endsection