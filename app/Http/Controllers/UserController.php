<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\job_desc;

class UserController extends Controller
{
    public function user()
    {
        \Carbon\Carbon::parse('2021-05-01')->timestamp;

        return job_desc::withoutGlobalScopes()->get();
    }

    public function fasilitator()
    {
        $jobDescs = job_desc::all();

        foreach($jobDescs as $key => $jobDesc)
        {
            $location =  $jobDesc->areaKerja->zone_location_id;

            $fasilitator[$key] = [
                'user_id' => $jobDesc->user_id,
                'name' => $jobDesc->user->name,
                'email' => $jobDesc->user->email,
                'job_title_id' => $jobDesc->job_title_id,
                'job_title' => $jobDesc->posisi->job_title,
                'district_id' => $jobDesc->areaKerja->district,
                'work_zone_id' => $jobDesc->work_zone_id,
                'team' => $jobDesc->areaKerja->team,
                'level' => $jobDesc->areaKerja->level,
                'location_id' => $location->id ?? '' ,
                'loication' => $location->location_type ?? '',
                'work_zone' => $jobDesc->areaKerja
            ];

            if($jobDesc->areaKerja->district == "OSP-1")
            {
                $fasilitator[$key]['wilayah'] = "OSP-1";
            }else{
                $fasilitator[$key]['wilayah'] = $jobDesc->areaKerja->kabupaten->NAMA_KAB;
            }
        }

        return response()->json($fasilitator);
    }

}
