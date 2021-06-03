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
                        <th class="text-center">
                            <button class="btn btn-primary btn-link" data-target=".add-modal" data-toggle="modal">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </th>
                        <th>Posisi</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($settings as $setting)

                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $setting->jobTitle->job_title }}</td>
                        <td>{{ $setting->location ? $setting->location->location_type : '' }}</td>
                        <td>
                            @if($setting->isActive)
                                <form action="/personnel-evaluation-setup-deactivate/{{ $setting->id }}" method="post" enctype="multipart/form-data">
                                @csrf
                                    <button class="btn btn-primary btn-link"><i class="fas fa-toggle-on"></i></button> Aktif
                                </form>
                                 
                            @else 
                                <form action="/personnel-evaluation-setup-activate/{{ $setting->id }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <button class="btn btn-primary btn-link"><i class="fas fa-toggle-off"></i></button> Tidak Aktif 
                                </form>
                            @endif
                        </td>
                        <td class="td-actions text-right">
                            <a href="/personnel-evaluation-setup/{{ $setting->id }}/edit">
                                <button type="button" rel="tooltip" class="btn btn-info">
                                    <i class="far fa-eye"></i>
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

<!-- Large modal -->
<div class="modal fade add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="m-5">
            <form action="/personnel-evaluation-setup" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div>
                            <label class="bmd-label-floating">Triwulan</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div>
                            <select class="form-control"  id="quarter" name="quarter">
                                <option>Triwulan</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div>
                            <label class="bmd-label-floating">Tahun</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div>
                            <select class="form-control"  id="year" name="year">
                                <option>Pilih</option>
                                <option value="{{\Carbon\carbon::now()->get('year')-1}}">{{ \Carbon\carbon::now()->get('year') - 1 }}</option>
                                <option value="{{\Carbon\carbon::now()->get('year') }}">{{ \Carbon\carbon::now()->get('year') }}</option>
                                <option value="{{\Carbon\carbon::now()->get('year')+1}}">{{ \Carbon\carbon::now()->get('year') + 1 }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div>
                            <label class="bmd-label-floating">Level</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div>
                            <select class="form-control"  id="level" name="level">
                                <option>Tingkat</option>
                                @foreach($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div>
                            <label class="bmd-label-floating">Posisi</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div>
                            <select class="form-control"  id="job_title" name="job_title">
                                <option>Jabatan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div>
                            <label class="bmd-label-floating">Lokasi</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div>
                            <select class="form-control"  id="location" name="location">
                                <option>lokasi</option>
                                <option>1</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary pull-right">Buat Setting</button>
                <button type="button" data-dismiss="modal" class="btn btn-default pull-right">Batal</button>
            <div class="clearfix"></div>
            </form>
        </div>
    </div>
  </div>
</div>

<script>
$('#level').change(function(){
    const level_id = $(this).val();
    $.ajax({			
    	type: 'get',
		url: '/personnel-evaluation-setup-get-job-title',
		data: {
			'level_id' : level_id
		},
		
        success: function(data) {
            console.log(data);
            $('#job_title').empty();
            $('#job_title').append('<option>Jabatan</option>');
            $.each(data[0], function (index, jobTitleObj) {
                $("#job_title").append('<option value="' + jobTitleObj.id + '">' + jobTitleObj.job_title + '</option>');
            });
            $('#location').empty();
            $('#location').append('<option value="0">Lokasi</option>');
            $.each(data[1], function (index, locationObj) { 
                $("#location").append('<option value="' + locationObj.id + '">' + locationObj.location_type + '</option>');
            })
        }
    })
})

</script>
@endsection
