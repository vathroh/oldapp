<?php

namespace App\Http\Controllers\personnelEvaluation\assessor;

use App\User;
use App\job_desc;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\personnel_evaluation_setting;

class showPersonnelsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }    
    
    public function job_desc()
	{
		$lastYear 					= personnel_evaluation_setting::max('year');
		$lastQuarter 				= personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
		
		return job_desc::withoutGlobalScopes()->selectRaw('*, UNIX_TIMESTAMP(starting_date) as starting_timestamp, UNIX_TIMESTAMP(finishing_date) as finishing_timestamp')->get();
		
	}

    public function setting($jobId)
    {
        $lastYear       = personnel_evaluation_setting::max('year');
        $lastQuarter    = personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
        $lastSetting    = personnel_evaluation_setting::where('year', $lastYear)->where('quarter', $lastQuarter)->where('jobTitleId', $jobId)->first();
        return $lastSetting;
    }
    
    /*

    public function users()
    {
        $myZones        = explode(", ", Auth::user()->areaKerja->pluck('zone')->first());
        $users          = User::find(job_desc::join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')->whereIn('district', $myZones)->pluck('user_id'));
        return $users;
    }
    */
    
    public function users()
    {        
		$lastYear = personnel_evaluation_setting::max('year');
		$myZones = explode(", ", Auth::user()->areaKerja->pluck('zone')->first());
		$lastQuarter = personnel_evaluation_setting::where('year', $lastYear)->max('quarter');		
		$dt = $lastYear . '-' . $lastQuarter*3 .'-' . 1;
		$time = Carbon::parse($dt)->timestamp;	
	
		$job_desc          = job_desc::withoutGlobalScopes()->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')->selectRaw('*, UNIX_TIMESTAMP(starting_date) as starting_timestamp, UNIX_TIMESTAMP(finishing_date) as finishing_timestamp')->get();
        
        return $job_desc->where('starting_timestamp', '<=', $time)->where('finishing_timestamp', '>', $time);
        
    }

    
    public function allpersonnels($jobId)
    {
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
        return view('personnelEvaluation.assessor.personnels.allpersonnels', compact(['users', 'lastSetting']));
    }

    public function belumMengisi($jobId)
    {
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
        $personnels     = $this->setting($jobId)->jobDesc->whereIn('user_id', $users->pluck('id'))->whereNotIn('user_id', $this->setting($jobId)->evaluationValue->pluck('userId'));
        return view('personnelEvaluation.assessor.personnels.belumMengisi', compact(['users', 'personnels', 'lastSetting']));
    }

    public function selesaiMengisi($jobId)
    {
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
        $values         = $this->setting($jobId)->evaluationValue->where('ok_by_user', 1);
        return view('personnelEvaluation.assessor.personnels.selesaiMengisi', compact(['users', 'values', 'lastSetting']));
    }

    public function prosesMengisi($jobId)
    {
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
        $values         = $this->setting($jobId)->evaluationValue->where('ok_by_user', 0);
        return view('personnelEvaluation.assessor.personnels.prosesMengisi', compact(['users', 'values', 'lastSetting']));
    }

    public function siapEvaluasi($jobId)
    {
		
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
        $values         = $this->setting($jobId)->evaluationValue->where('ok_by_user', 1)->where('totalScore', '0.00');
        return view('personnelEvaluation.assessor.personnels.siapEvaluasi', compact(['users', 'values', 'lastSetting']));
    }

    public function prosesEvaluasi($jobId)
    {
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
        $values         = $this->setting($jobId)->evaluationValue->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 0);
        return view('personnelEvaluation.assessor.personnels.prosesEvaluasi', compact(['users', 'values', 'lastSetting']));
    }

    public function selesaiEvaluasi($jobId)
    {
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
        $values         = $this->setting($jobId)->evaluationValue->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 1);
        return view('personnelEvaluation.assessor.personnels.selesaiEvaluasi', compact(['users', 'values', 'lastSetting']));
    }
}
