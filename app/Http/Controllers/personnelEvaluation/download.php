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

class download extends Controller
{
    public function rekapAll()
    {
        $myZones	  = explode(", ", job_desc::where('user_id', Auth::user()->id)->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
                                                                          ->pluck('zone')->first());
        $users    = [];

        foreach( $myZones as $myZone )
        {
            $workZone =  work_zone::where('district', $myZone)->first();     
            $users[] = $workZone->user()->get();
        }

        Arr::pluck( Arr::collapse($users), 'id');

        $values     = personnel_evaluation_value::whereIn('userId', Arr::pluck( Arr::collapse($users), 'id') )->where('ready', 1)->get();
        if($values->count() > 0 )
        {
            return Excel::download(new rekapEvkinjaExport($values), 'export.xlsx');
            
        } else {
            return "Personnel belum ada yang dinilai";
        }
    }
}

