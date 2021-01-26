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
                        <th scope="col">Materi</th>
                        <th scope="col">Lihat/Download</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activity->subjects->whereNotNull('library_id') as $subject)
                    <tr>
                        <td>{{ $subject->subject }}</td>
                        <td>@if($subject->library->file)
                            <a href="/lesson-download/{{ $subject->library->id }}" target="_blank">
                                . download .
                            </a>
                            @endif
                            @if($subject->library->link)<a href="{{ $subject->library->link }}" target="_blank">
                                . download .
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
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