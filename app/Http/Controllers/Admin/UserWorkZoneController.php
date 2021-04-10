<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\zone_level;
use App\User;
use App\job_desc;

class UserWorkZoneController extends Controller
{
    public function show($id)
    {
		$data = [];
		$user = User::find($id);			
		$zone_levels = zone_level::all();
		
		$job_descs = job_desc::withoutGlobalScopes()->where('user_id', $id)->get();
		
		foreach($job_descs as $key=>$job_desc)
		{
			//return job_Desc::withoutGlobalScopes()->where('user_id', $id)->get();
			$wilayah_tugas = [];
			$data[$key]['job_desc_id'] = $job_desc->id;
			$data[$key]['posisi'] = $job_desc->posisi->job_title;
			$data[$key]['kabupaten']= $job_desc->kabupaten->first()->NAMA_KAB;
			$data[$key]['awal_kontrak']= Carbon::parse($job_desc->starting_date)->format('d M Y');
			$data[$key]['akhir_kontrak']= Carbon::parse($job_desc-> finishing_date)->format('d M Y');
			$data[$key]['tim']= $job_desc->areaKerja->team;	
			
			foreach($job_desc->areaKerja->districts as $key1=>$district)
			{
				$wilayah_tugas[$key1] = $district->nama_kab ;
			}
			
			$data[$key]['wilayah_tugas'] = $wilayah_tugas;
		}
		
		return view('admin.users.work_zones.show', compact(['user', 'data', 'zone_levels']));
	}
	
	public function store(Request $request)
	{
		//return $request;
		
		job_desc::create([
			'user_id' => $request->user_id,
			'work_zone_id' => $request->work_zone,
			'starting_date' => $request->starting_date,
			'finishing_date' => $request->finishing_date,
			'job_title_id' => $request->job_title
		]);

		return redirect('admin/user-work-zones/' . $request->user_id);
	}
	
	public function edit($id)
	{
		$zone_levels = zone_level::all();
		$job_desc = job_desc::withoutGlobalScopes()->find($id);		
		
		return view('admin.users.work_zones.edit', compact(['job_desc', 'zone_levels']));
	}
	
	public function update(Request $request, $id)
	{
		$job_desc = job_desc::withoutGlobalScopes()->find($id);
		$job_desc->update([
			'work_zone_id' => $request->work_zone,
			'starting_date' => $request->starting_date,
			'finishing_date' => $request->finishing_date,
			'job_title_id' => $request->job_title
		]);

		return redirect('/admin/user-work-zones/' . $job_desc->user_id);
	}
}
