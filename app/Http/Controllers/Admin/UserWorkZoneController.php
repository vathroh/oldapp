<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;

class UserWorkZoneController extends Controller
{
    public function show($id)
    {
		$data = [];
		$user = User::find($id);			
		
		foreach($user->jobDesc as $key=>$job_desc)
		{
			$wilayah_tugas = [];
			$data[$key]['posisi'] = $job_desc->posisi->job_title;
			$data[$key]['kabupaten']= $job_desc->kabupaten->first()->NAMA_KAB;
			$data[$key]['awal_kontrak']= Carbon::parse($job_desc->starting_date)->format('M d M Y');
			$data[$key]['akhir_kontrak']= $job_desc-> finishing_date;
			$data[$key]['tim']= $job_desc->areaKerja->team;	
			
			foreach($job_desc->areaKerja->districts as $key1=>$district)
			{
				$wilayah_tugas[$key1] = $district->nama_kab ;
			}
			
			$data[$key]['wilayah_tugas'] = $wilayah_tugas;
		}
		
		return view('admin.users.work_zones.show', compact(['user', 'data']));
	}
}
