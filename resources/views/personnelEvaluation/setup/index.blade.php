@extends('layouts.MaterialDashboard')
@section('head')
<script src="https://kit.fontawesome.com/e3a45180d4.js" crossorigin="anonymous"></script>
@endsection
@section('content')
<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title ">Evaluasi Kinerja</h4>
		<p class="card-category">Kriteria</p>
	</div>
	<div class="card-body">
	@include('personnelEvaluation.navbar')

	<div class="row">		
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center"><i class="fas fa-plus-circle"></i> Setting</th>
                        <th>Triwulan</th>
                        <th>Tahun</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($settings as $setting)

                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $setting->quarter }}</td>
                        <td>{{ $setting->year }}</td>
                        <td class="td-actions text-right">
                            <a href="/personnel-evaluation-setup-term/{{ $setting->quarter }}/{{ $setting->year }}">
                                <button type="button" rel="tooltip" class="btn btn-info">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                </button>
                            </a>
                       </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
		</div>	
	</div>

</div>

<script src="{{ asset('js/personnelEvaluation/jobTitles.js') }}"></script>
@endsection
