<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\job_desc;
use App\biodata;
use App\Http\Controllers\TimeController;

class UserController extends Controller
{
    public function time()
    {
        return new TimeController;
    }

    public function users_now()
    {
        $time = $this->time()->this_timestamp();
        return $this->users($time);
    }
    
    public function users_at($day, $month, $year)
    {
        $time = $this->time()->timestamp($day, $month, $year);
        return $this->users($time);
    }

    public function users($time)
    {

        $jobDesc = job_desc::withoutGlobalScopes()->selectRaw('id, user_id, job_title_id, work_zone_id, unix_timestamp(starting_date) as starting_date_timestamp, unix_timestamp(finishing_date) as finishing_date_timestamp, starting_date, finishing_date')->get();

        $jobDescAtTime = $jobDesc->where('starting_date_timestamp', '<=', $time)->where('finishing_date_timestamp', '>=', $time);

        foreach($jobDescAtTime as $key => $jobDesc)
        {
            $location =  $jobDesc->areaKerja->zone_location_id;
            $biodata = biodata::where('nik', $jobDesc->user->nik)->first();

            $users[$key] = [
                'user_id' => $jobDesc->user_id,
                'name' => $jobDesc->user->name,
                'job_desc_id' => $jobDesc->id,
                'job_title_id' => $jobDesc->job_title_id,
                'job_title' => $jobDesc->posisi->job_title,
                'zone_level_id' => $jobDesc->posisi->zone_level_id,
                'zone_level' => $jobDesc->posisi->zone_level->name,
                'job_title_type' => $jobDesc->posisi->type,
                'job_title_sort' => $jobDesc->posisi->sort,
                'work_zone_id' => $jobDesc->work_zone_id,
                'tim' => $jobDesc->areaKerja->team,
                'location_id' => $location ?? '' ,
                'location' => $location ? $jobDesc->areaKerja->zone_location->location_type : '',
                'term_start' => $jobDesc->starting_date,
                'term_end' => $jobDesc->finishing_date
            ];

            if($jobDesc->posisi->zone_level_id == 1)
            {
                $users[$key]['kab'] = $jobDesc->areaKerja->team;
                $users[$key]['kode_kab'] = $jobDesc->areaKerja->district;
            }else{
                $users[$key]['kab'] = $jobDesc->areaKerja->kabupaten->NAMA_KAB;
                $users[$key]['kode_kab'] = $jobDesc->areaKerja->kabupaten->KD_KAB;
            }
        }

        return collect($users);
 
    }


    public function user_at($user_id, $day, $month, $year)
    {
        $jobDescs = $this->users_at($day, $month, $year);
        return $jobDescs->where('user_id', $user_id)->first(); 

    }

    public function user_now($user_id)
    {
        $jobDescs = $this->users_now();
        return $jobDescs->where('user_id', $user_id)->first(); 

    }

}
