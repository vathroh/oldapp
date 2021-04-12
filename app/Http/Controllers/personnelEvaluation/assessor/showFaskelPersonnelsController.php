<?php

namespace App\Http\Controllers\personnelEvaluation\assessor;

use App\User;
use App\job_desc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\personnel_evaluation_setting;
use App\personnel_evaluation_value;

class showFaskelPersonnelsController extends Controller
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

    public function users($district)
    {        
		$lastYear = personnel_evaluation_setting::max('year');
		$myZones = explode(", ", Auth::user()->areaKerja->pluck('zone')->first());
		$lastQuarter = personnel_evaluation_setting::where('year', $lastYear)->max('quarter');		
		$dt = $lastYear . '-' . $lastQuarter*3 .'-' . 1;
		$time = Carbon::parse($dt)->timestamp;	
	
		$job_desc          = job_desc::withoutGlobalScopes()->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')->where('district', $district)->selectRaw('*, UNIX_TIMESTAMP(starting_date) as starting_timestamp, UNIX_TIMESTAMP(finishing_date) as finishing_timestamp')->get();
        
        return $job_desc->where('starting_timestamp', '<=', $time)->where('finishing_timestamp', '>', $time);
        
    }

    public function allpersonnels($jobId, $district)
    {
        $job_descs   = $this->users($district);
        $lastSetting    = $this->setting($jobId);
        return view('personnelEvaluation.assessor.personnels.allpersonnels', compact(['job_descs', 'lastSetting']));
    }

    public function belumMengisi($jobId, $district)
    {
        $users          = $this->users($district);
        $lastSetting    = $this->setting($jobId);
        $personnels     = $this->setting($jobId)->jobDesc->whereIn('user_id', $users->pluck('user_id'))->whereNotIn('user_id', $this->setting($jobId)->evaluationValue->pluck('userId'));
        return view('personnelEvaluation.assessor.personnels.belumMengisi', compact(['users', 'personnels', 'lastSetting']));
    }

    public function selesaiMengisi($jobId, $district)
    {
        $users          = $this->users($district);
        $lastSetting    = $this->setting($jobId);
        $values         = personnel_evaluation_value::where('settingId', $lastSetting->id)->whereIn('userId', $users->pluck('user_id'))->where('ok_by_user', 1)->get();
        return view('personnelEvaluation.assessor.personnels.selesaiMengisi', compact(['users', 'values', 'lastSetting']));
    }

    public function prosesMengisi($jobId, $district)
    {
		return $users          = $this->users($district);
        $lastSetting    = $this->setting($jobId);
        $values         = personnel_evaluation_value::where('settingId', $lastSetting->id)->whereIn('userId', $users->pluck('user_id'))->where('ok_by_user', 0)->get();
        return view('personnelEvaluation.assessor.personnels.prosesMengisi', compact(['users', 'values', 'lastSetting']));
    }

    public function siapEvaluasi($jobId, $district)
    {
		
        $users          = $this->users($district);
        $lastSetting    = $this->setting($jobId);
        $values         = personnel_evaluation_value::where('settingId', $lastSetting->id)->whereIn('userId', $users->pluck('user_id'))->where('ok_by_user', 1)->where('totalScore', '0.00')->get();
        return view('personnelEvaluation.assessor.personnels.siapEvaluasi', compact(['users', 'values', 'lastSetting']));
    }

    public function prosesEvaluasi($jobId, $district)
    {
        $users          = $this->users($district);
        $lastSetting    = $this->setting($jobId);
        $values         = personnel_evaluation_value::where('settingId', $lastSetting->id)->whereIn('userId', $users->pluck('user_id'))->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 0)->get();
        return view('personnelEvaluation.assessor.personnels.prosesEvaluasi', compact(['users', 'values', 'lastSetting']));
    }

    public function selesaiEvaluasi($jobId, $district)
    {
        $users          = $this->users($district);
        $lastSetting    = $this->setting($jobId);
        $values         = personnel_evaluation_value::where('settingId', $lastSetting->id)->whereIn('userId', $users->pluck('user_id'))->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 1)->get();

        return view('personnelEvaluation.assessor.personnels.selesaiEvaluasi', compact(['users', 'values', 'lastSetting']));
    }
}
