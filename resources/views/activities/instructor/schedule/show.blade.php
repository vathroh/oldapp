@extends('layouts.MaterialDashboard')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">{{ $activity->name }}</h4>

    </div>
    @include('activities.instructor.navbar')
    <div class="card-body">

        <div class="mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr class="table-info">
                        <th scope="col">Waktu</th>
                        <th scope="col">Materi</th>
                        <th scope="col">Pemandu/Moderator</th>
                    </tr>
                </thead>
                <tbody>
                    @if( $activity->subjects->count() )

                    @for($i=0; $i<=Carbon\carbon::parse($activity->start_date)->diffInDays(Carbon\carbon::parse($activity->finish_date)); $i++) <tr class="table-warning">
                            <td colspan="3">
                                {{ Carbon\Carbon::parse($activity->start_date)->addDays($i)->format('l, d F Y') }}
                            </td>
                        </tr>
                        @foreach( $activity->subjects->where('date', Carbon\Carbon::parse($activity->start_date)->addDays($i)->format('Y-m-d') ) as $subject )

                        <tr>
                            <td>{{ $subject->start_time }} - {{ $subject->finish_time }}</td>
                            <td>{{ $subject->subject }}</td>
                            <td style="text-transform: uppercase;">
                                @if(!empty($subject->instructor1_id)) {{ $subject->pemandu1->name }} @endif

                                @if(!empty($subject->instructor2_id))/ {{ $subject->pemandu2->name }} @endif
                            </td>
                        </tr>
                        @endforeach

                        @endfor
                        @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
@endsection