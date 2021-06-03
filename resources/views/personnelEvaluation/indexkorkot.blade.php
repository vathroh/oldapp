@extends('layouts.MaterialDashboard')

@section('head')
<style>
.evkinja-user-status{
    border: 2px solid red; 
    border-radius: 5px; 
    padding: 20px;
}
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title ">Evaluasi Kinerja</h4>
        <p class="card-category"></p>
    </div>
    <div class="card-body">
        @include('personnelEvaluation.navbar')


        @if($status['isSetting'] == true && $status['isValue'] == true )

            <div class="evkinja-user-status my-3 text-center">
                <h5 style="color:grey;">
                    Evaluasi Kinerja Kuartal {{ $data['thisQuarter'] }} Tahun {{ $data['thisYear'] }}

                    @if($data['myValue']['ok_by_user'] == 1)
    			    	Sudah Selesai
                    @elseif($data['myValue']['ok_by_user'] == 0 )
                        <span style="color:red">Belum Selesai</span>
                    @endif 

                    Diinput.
                </h5>

                <a href="/personnel-evaluation-input/{{ $data['mySetting']['id'] }}/{{$data['user']['user_id'] }}">

                    @if($data['myValue']['ok_by_user'] == 1)
                        <button class="btn btn-primary">Lihat</button>
                    @elseif($data['myValue']['ok_by_user'] == 0 )
                        <button class="btn btn-success">Selesaikan</button>
                    @endif
                </a>

            </div>
       
        @elseif($status['isSetting'] == true && $status['isValue'] == false )
        <div class="evkinja-user-status my-3 text-center">
            <h5 style="color:red;">Anda Belum Mengisi Evaluasi Kinerja. </h5>
            <a href="/personnel-evaluation-input/{{ $data['mySetting']['id'] }}/{{ $data['user']['user_id'] }}">
                <button class="btn btn-danger">Isi sekarang</button>
            </a>
        </div>
        @endif
 
    </div>

        @if($status['isAssessor'])
        <div class="table-responsive tableFixHead">
            <table class="table table-bordered">
				<thead class=" text-primary text-center">
					<tr class="text-center" style="background-color: purple; color:white;">
						<th rowspan="2">Posisi Yang Dievaluasi</th>
						<th rowspan="2">Jumlah Personil</th>
						<th colspan="3">Personil</th>
						<th colspan="3">Tim Penilai</th>
					</tr>
					<tr class="text-center" style="background-color: purple; color:white;">
						<th>Belum Mengisi</th>
						<th>Proses</th>
						<th>Selesai Mengisi</th>
						<th>Siap Dievaluasi</th>
						<th>Sedang Dievaluasi</th>
						<th>Selesai Dievaluasi</th>
					</tr>
                </thead>
                <tbody>
                    @foreach($data['being_assessed_by_me']->unique('kode_kab') as $district)
                    <tr>
                        <td colspan="8">{{ $district['kab'] }}</td>
                    </tr> 
                    @foreach($data['being_assessed_by_me']->unique('job_title_id') as $jobTitle)

                    @php
                        $fasilitators =  $data['being_assessed_by_me']->where( 'kode_kab', $district['kode_kab'])->where('job_title_id', $jobTitle['job_title_id']); 
                        $values = $data['value_assessed_by_me']->whereIn('userId', $fasilitators->pluck('user_id')) ;
                    @endphp

                    <tr>
                        <td>{{ $jobTitle['job_title'] }}</td>

                        <td class="text-center">
                            <a href="/personnel-evaluation/assessor/timfaskel/allpersonnels/{{ $jobTitle['job_title_id'] }}/{{ $district['kode_kab'] }}">
                                {{ $fasilitators->count() }}
                            </a>
                        </td>
                        
                        <td class="text-center">
							<a href="/personnel-evaluation/assessor/timfaskel/belummengisi/{{ $jobTitle['job_title_id'] }}/{{$district['kode_kab']}}">
                                {{ $fasilitators->count()-$values->count() }}
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="/personnel-evaluation/assessor/timfaskel/prosesmengisi/{{ $jobTitle['job_title_id'] }}/{{ $district['kode_kab'] }}">
                                {{ $values->where('ok_by_user', 0 )->count() }}
                            </a>
                        </td>

                        <td class="text-center">
							<a href="/personnel-evaluation/assessor/timfaskel/selesaimengisi/{{ $jobTitle['job_title_id'] }}/{{$district['kode_kab'] }}">
                                {{ $values->where('ok_by_user', 1 )->count() }}
                            </a>
                        </td>

                        <td class="text-center"> 
							<a href="/personnel-evaluation/assessor/timfaskel/siapevaluasi/{{ $jobTitle['job_title_id'] }}/{{$district['kode_kab'] }}">
                                {{ $values->where('ok_by_user', 1 )->where('totalScore', '0.00')->count() }}
                            </a>
                        </td>

                        <td class="text-center">
							<a href="/personnel-evaluation/assessor/timfaskel/prosesevaluasi/{{ $jobTitle['job_title_id'] }}/{{$district['kode_kab'] }}">
                                {{ $values->where('ok_by_user', 1 )->where('totalScore','!=', '0.00')->where('ready', 0)->count() }}
                            </a>
                        </td>

                        <td class="text-center">
							<a href="/personnel-evaluation/assessor/timfaskel/selesaievaluasi/{{ $jobTitle['job_title_id'] }}/{{$district['kode_kab'] }}">
                                {{ $values->where('ok_by_user', 1 )->where('totalScore','!=', '0.00')->where('ready', 1)->count() }}
                            </a>
                        </td>

                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
	
@endsection
