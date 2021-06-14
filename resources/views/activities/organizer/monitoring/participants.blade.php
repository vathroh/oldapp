@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">{{ $activity->name }}</h4>

    </div>
    @include('activities.organizer.navbar')
    <div style="margin: 0 20px;">Daftar Hadir : Peserta | Pemandu | Panitia | Evaluasi: Evaluasi Topik Belajar</div>
    <div class="card-body">
        <div class="monitoring-container">
            <div class="my-3" style="border:1px solid black; padding: 20px;">
                <h4 class="text-center">Peserta Sudah Mengisi Daftar Hadir</h4>
                @for($i=0; $i<Carbon\Carbon::parse($activity->start_date)->diffInDays(Carbon\Carbon::parse($activity->finish_date)) + 1; $i++) @php $tanggal=Carbon\Carbon::parse($activity->start_date);
                    $day = $tanggal->addDays($i);
                    $day1 = $day->format('Y-m-d');
                    @endphp

                    @if($day == Carbon\Carbon::parse($activity->break))
                    @else
                    <h6 class="mt-5">{{ $day->format('l, d F Y') }}</h6>
                    <div>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Tanggal</td>
                                    <td>Nama</td>
                                    <td>Jenis Kelamin</td>
                                    <td>Jabatan</td>
                                    <td>Kabupaten/Kota</td>
                                    <td>Telp/WA</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($participants->where('date', $day->format('Y-m-d'))->unique('user_id') as $participant)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $day->format('d F Y') }}</td>
                                    <td>{{ $participant->user->name }}</td>
                                    <td>{{ $participant->user->biodata->gender ?? "" }}</td>
                                    <td>{{ $participant->job_desc ? $participant->job_desc->posisi->job_title : '' }}</td>
                                    <td>{{ $participant->user->jobDesc->first()->kabupaten[0]->NAMA_KAB ?? '-' }}</td>
                                    <td>{{ $participant->user->biodata->HP ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    @endif
                    @endfor
            </div>


            <div class="my-3" style="border:1px solid black; padding: 20px;">
                <h4 class="text-center">Rekap Peserta</h4>
                <h4 class="text-center">Yang Sudah Mengisi Daftar Hadir</h4>
                @for($i=0; $i<Carbon\Carbon::parse($activity->start_date)->diffInDays(Carbon\Carbon::parse($activity->finish_date)) + 1; $i++) @php $tanggal=Carbon\Carbon::parse($activity->start_date);
                    $day = $tanggal->addDays($i);
                    $day1 = $day->format('Y-m-d');
                    @endphp
                    
                    @if($day == Carbon\Carbon::parse($activity->break))
                    @else
                    <h6 class="mt-5">{{ $day->format('l, d F Y') }}</h6>
                    <div>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Tanggal</td>
                                    <td>Jumlah</td>
                                    <td>Laki-Laki</td>
                                    <td>Perempuan</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $day->format('l, d F Y') }}</td>
                                    <td>{{ $participants->where('date', $day->format('Y-m-d'))->unique('user_id')->count() }}</td>
                                    <td>{{ $participants->where('date', $day->format('Y-m-d'))->unique('user_id')->where('gender', 'Laki-Laki')->count() }}</td>
                                    <td>{{ $participants->where('date', $day->format('Y-m-d'))->unique('user_id')->where('gender', 'Perempuan')->count() }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <hr>
                    @endif
                    @endfor
            </div>


            <div class="my-3" style="border:1px solid black; padding: 20px;">
                <h4 class="text-center">Belum Mengisi Daftar Hadir</h4>
                @for($i=0; $i<Carbon\Carbon::parse($activity->start_date)->diffInDays(Carbon\Carbon::parse($activity->finish_date)) + 1; $i++) @php $tanggal=Carbon\Carbon::parse($activity->start_date);
                    $day = $tanggal->addDays($i);
                    $day1 = $day->format('Y-m-d');
                    @endphp
                    <h6 class="mt-5">{{ $day->format('l, d F Y') }}</h6>

                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Tanggal</td>
                                <td>Nama</td>
                                <td>Jenis Kelamin</td>
                                <td>Jabatan</td>
                                <td>Kabupaten/Kota</td>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach( $activity->participants->where('role', 'PESERTA')->whereNotIn('user_id', $participants->where('date', $day->format('Y-m-d'))->unique('user_id')->pluck('user_id')) as $participant)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $day->format('d F Y') }}</td>
                                <td>{{ $participant->user->name ??  $participant->user_id }} </td>
                                <td>{{ $participant->user->biodata->gender ?? "" }}</td>
                                <td>{{ $participant->job_desc ? $participant->job_desc->posisi->job_title : '' }}</td>
                                <td>{{ $participant->user->jobDesc->first()->kabupaten[0]->NAMA_KAB ?? '-' }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <hr>
                    @endfor
            </div>



        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection
