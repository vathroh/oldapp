<?php

namespace App\Http\Controllers\personnelEvaluation;

use App\Http\Controllers\Controller;
use App\personnel_evaluation_value;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\job_desc;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\rekapEvkinjaExport;
use App\work_zone;
use Illuminate\Support\Arr;
use App\personnel_evaluator;
use App\User;
use App\job_title;

class download extends Controller
{
    public function rekapAll()
    {
        if(Auth::user()->hasRole('hrm'))
        {
            $values = personnel_evaluation_value::where('ready', 1)->orderBy('settingId')->get();
        }else{
            $myZones	  = explode(", ", job_desc::where('user_id', Auth::user()->id)->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
                                                                          ->pluck('zone')->first());
            $users    = [];
            foreach( $myZones as $myZone )
            {
                $workZones =  work_zone::where('district', $myZone)->get();
                foreach( $workZones as $workZone )
                {
                    $users[] = $workZone->user()->get();
                }
            }
            $userIdsFromWorkZones = Arr::pluck( Arr::collapse($users), 'id');

            $jobIds = personnel_evaluator::where('evaluator', User::find(Auth::user()->id)->posisi->id)->pluck('jobId');
            foreach($jobIds as $jobId)
            {
                $evaluators[] = job_title::find($jobId)->user;
            }
        
            $userIdsFromEvaluators = Arr::pluck( Arr::collapse($evaluators), 'id');
    
            $userIds = array_intersect($userIdsFromWorkZones, $userIdsFromEvaluators );  
            $values     = personnel_evaluation_value::wherein('userId',  $userIds )->where('ready', 1)->orderBy('settingId')->get();
        }

        if($values->count() > 0 )
        {
            return Excel::download(new rekapEvkinjaExport($values), 'Rekap-Evkinja.xlsx');    
        } else {
            return "Personnel belum ada yang dinilai";
        }
    }
}

