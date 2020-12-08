@extends('layouts.MaterialDashboard')

@section('head')
<link href="{{ asset('css/kpp/style.css')  }}" rel="stylesheet">
@endsection


@section('content')

<div class="card">
    <div class="card-header-primary">Personil OSP 1 Jawa Tengah1</div>
        <div id="users" class="card-body">
            @include('admin.users.navbar')
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td scope="col">No</td>
                        <td scope="col">Kabupaten/Kota</td>
                        <td>Korkot</td>
                        <td>Askot Mandiri</td>
                        <td>Askot Infra</td>
                        <td>Askot KK</td>
                        <td>Askot Livelihood</td>
                        <td>Askot UP</td>
                        <td>Askot Safeguard</td>
                        <td>Asmandat</td>
                        <td>Faskel Teknik K1</td>
                        <td>Faskel Teknik K2</td>
                        <td>Faskel Sosial</td>
                        <td>Faskel Ekonomi</td>
                        <td>SF</td>
                        <td>Askot Infra DAK</td>
                        <td>Askot UP DAK</td>
                        <td>Faskel Sosial DAK</td>
                        <td>Faskel Ekonomi DAK</td>
                        <td>Faskel Teknik DAK</td>
                        
                        <td scope="col">Jumlah</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kabupaten as $kab)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td> {{ $kab->NAMA_KAB }}</td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/1"> {{ $users[$kab->KD_KAB]->where('job_title_id', 1)->count() }} </a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/2">  {{ $users[$kab->KD_KAB]->where('job_title_id', 2)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/3"> {{ $users[$kab->KD_KAB]->where('job_title_id', 3)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/4">  {{ $users[$kab->KD_KAB]->where('job_title_id', 4)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/5">  {{ $users[$kab->KD_KAB]->where('job_title_id', 5)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/6">  {{ $users[$kab->KD_KAB]->where('job_title_id', 6)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/7">  {{ $users[$kab->KD_KAB]->where('job_title_id', 7)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/8">  {{ $users[$kab->KD_KAB]->where('job_title_id', 8)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/10">  {{ $users[$kab->KD_KAB]->where('job_title_id', 10)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/40">  {{ $users[$kab->KD_KAB]->where('job_title_id', 40)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/11">  {{ $users[$kab->KD_KAB]->where('job_title_id', 11)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/12">  {{ $users[$kab->KD_KAB]->where('job_title_id', 12)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/13">  {{ $users[$kab->KD_KAB]->where('job_title_id', 13)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/35">  {{ $users[$kab->KD_KAB]->where('job_title_id', 35)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/36">  {{ $users[$kab->KD_KAB]->where('job_title_id', 36)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/37">  {{ $users[$kab->KD_KAB]->where('job_title_id', 37)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/38">  {{ $users[$kab->KD_KAB]->where('job_title_id', 38)->count() }}</a></td>
                        <td><a href="/hrm-users/{{$kab->KD_KAB}}/39">  {{ $users[$kab->KD_KAB]->where('job_title_id', 39)->count() }}</a></td>
                        
                        <td> {{ $users[$kab->KD_KAB]->count() }}</td>
                    </tr>
                    @endforeach
                    <tr>
                    </tr>
                </tbody>
            </table>            
         </div>
    </div>
</div>


@endsection
