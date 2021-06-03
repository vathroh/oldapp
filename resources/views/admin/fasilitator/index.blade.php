@extends('layouts.MaterialDashboard')

@section('head')
@endsection

@section('content')

<div class="card">
    <div class="card-header-primary">Users  =======</div>
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Job Position</th>
                    <th>Tim</th>
                    <th>Kabupaten</th>
                    <th class="text-right">Masa Kerja</th>
                </tr>
            </thead>
            <tbody>

                @foreach($districts as $district)
                <tr>
                    <td colspan="7" style="background-color: yellow;">{{ $district->nama_kab  }}</td>
                </tr>
                   
                @foreach($fasilitators->where('kode_kab', $district->kode_kab)->unique('tim') as $index => $tim)

                @foreach($fasilitators->where('kode_kab', $district->kode_kab)->where('tim', $tim['tim'])->sortBy('job_title_sort') as $fasilitator)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                        <a href="/admin/user-work-zones/{{ $fasilitator['user_id']  }}">{{ $fasilitator['name'] }}</a>
                    </td>
                    <td>{{ $fasilitator['job_title'] }}</td>
                    <td>{{ $fasilitator['tim'] }}</td>
                    <td>{{ $fasilitator['kab'] }}</td>
                    <td>{{ $fasilitator['term_start'] }} - {{ $fasilitator['term_end'] }}</td>
                </tr>
                @endforeach
                @endforeach
                @endforeach
            </tbody>
        </table>

    <div id="users" class="card-body">
    </div>
</div>


@endsection
