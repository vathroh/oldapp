@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">{{ $activity->name }}</h4>

    </div>
    @include('activities.organizer.navbar')
    <div class="card-body">

        <div class="monitoring-container">
            @for($i=0; $i<2; $i++) @php $tanggal=Carbon\Carbon::parse($activity->start_date);
                $day = $tanggal->addDays($i);
                $day1 = $day->format('Y-m-d');
                @endphp
                <div class="my-3" style="border:1px solid black; padding: 20px;">
                    <h4>{{ $day->format('l, d F Y') }}</h4>
                    <h5>Sudah Mengisi Daftar Hadir</h5>
                    <div>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama</td>
                                    <td>Jabatan</td>
                                    <td>Kabupaten/Kota</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($participants->where('date', $day->format('Y-m-d'))->unique('user_id') as $participant)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $participant->user->name }}</td>
                                    <td>{{ $participant->user->posisi->job_title ?? '-' }}</td>
                                    <td>{{ $participant->user->jobDesc->first()->kabupaten[0]->NAMA_KAB ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h5>Belum Mengisi Daftar Hadir</h5>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>Jabatan</td>
                                <td>Kabupaten/Kota</td>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach( $activity->participants->where('role', 'PESERTA')->whereNotIn('user_id', $participants->where('date', $day->format('Y-m-d'))->unique('user_id')->pluck('user_id')) as $participant)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> {{ $participant->user->name ??  $participant->user_id }} </td>
                                <td>{{ $participant->user->posisi->job_title ?? '-' }}</td>
                                <td>{{ $participant->user->jobDesc->first()->kabupaten[0]->NAMA_KAB ?? '-' }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
                @endfor

        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection