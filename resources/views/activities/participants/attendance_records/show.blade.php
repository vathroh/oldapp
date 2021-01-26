@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">{{ $activity->name }}</h4>
    </div>
    @include('activities.participants.navbar')
    <div class="card-body">
        <div class="mt-3 d-flex">
            <div class="Table-area" style="width:50%;">
                Catatan Kehadiran anda:
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Tanggal</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activity_id as $attendance_record)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Carbon\Carbon::parse($attendance_record->created_at)->format('l, d F Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="button-area text-center" style="width:50%;">
                @if( Carbon\carbon::parse($activity->finish_date)->addDays(1)->timestamp - Carbon\carbon::now()->timestamp > 0 AND Carbon\carbon::parse($activity->start_date)->timestamp - Carbon\carbon::now()->timestamp < 0) @if($activity_id->where('tanggal', Carbon\carbon::now()->format('Y-m-d'))->count() == 0 )
                    <form method="post" action="/kegiatan/peserta/absensi/{{$id}}">
                        @csrf
                        <input type="hidden" name="activity_id" value="{{ $id }}">
                        <button type="submit" class="btn btn-large btn-primary">HADIR</button>
                    </form>
                    @endif
                    @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer>
</script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection