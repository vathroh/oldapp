<?php

namespace App\Http\Controllers\personnelEvaluation\hrm;

use App\User;
use App\job_desc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\job_title;
use Illuminate\Support\Facades\Auth;
use App\personnel_evaluation_setting;
use App\work_zone;
use Carbon\Carbon;

class showPersonnelController extends Controller
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

    public function users()
    {
		$lastYear 					= personnel_evaluation_setting::max('year');
		$lastQuarter 				= personnel_evaluation_setting::where('year', $lastYear)->max('quarter');		
		$dt = $lastYear . '-' . $lastQuarter*3 .'-' . 1;
		$time = Carbon::parse($dt)->timestamp;
		$current_job_descs = 
		$this->job_desc()->where('starting_timestamp', '<=', $time)->where('finishing_timestamp', '>', $time);
		
        $myZones        = explode(", ", Auth::user()->areaKerja->pluck('zone')->first());
        $zones 			= work_zone::whereIn('district', $myZones)->where('year', 2020)->get();
        //$users          = User::find(job_desc::join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')->whereIn('district', $myZones)->pluck('user_id'));
        
        $users = $current_job_descs->whereIn('work_zone_id', $zones->pluck('id'));
        return $users;
    }

    public function index()
    {
		$id 						= Auth::user()->id;
		$lastYear 					= personnel_evaluation_setting::max('year');
		$lastQuarter 				= personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
		
		
		
		$dt = $lastYear . '-' . $lastQuarter*3 .'-' . 1;
		$time = Carbon::parse($dt)->timestamp;
		$current_job_descs = 
		$this->job_desc()->where('starting_timestamp', '<=', $time)->where('finishing_timestamp', '>', $time);
		
        $lastSetting    = personnel_evaluation_setting::where('year', $lastYear)->where('quarter', $lastQuarter)->get();
        $jobTitles = job_title::whereIn('level', ['Korkot', 'Askot Mandiri', 'Tim Faskel'])->whereNotIn('job_title', ['Operator', 'Sekretaris'])->orderBy('sort')->get();
        
        $users = $this->users();
        
        return view('personnelEvaluation.hrm.monitoring.index', compact(['jobTitles', 'lastSetting', 'users']));
    }

    public function allpersonnels($jobId)
    {
        $users   = $this->users();
        $lastSetting    = $this->setting($jobId);
        return view('personnelEvaluation.assessor.personnels.allpersonnels', compact(['users', 'lastSetting']));
    }

    public function belumMengisi($jobId)
    {
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
//return $lastSetting->evaluationValue->pluck('userId');
        $personnels     = $users->where('job_title_id', $jobId )->whereNotIn('user_id', $lastSetting->evaluationValue->pluck('userId'));
        return view('personnelEvaluation.assessor.personnels.belumMengisi', compact(['users', 'personnels', 'lastSetting']));
    }

    public function selesaiMengisi($jobId)
    {
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
        $values         = $lastSetting->evaluationValue->where('ok_by_user', 1);
        return view('personnelEvaluation.assessor.personnels.selesaiMengisi', compact(['users', 'values', 'lastSetting']));
    }

    public function prosesMengisi($jobId)
    {
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
        $values         = $lastSetting->evaluationValue->where('ok_by_user', 0);
        return view('personnelEvaluation.assessor.personnels.prosesMengisi', compact(['users', 'values', 'lastSetting']));
    }

    public function siapEvaluasi($jobId)
    {
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
        $values         = $lastSetting->evaluationValue->where('ok_by_user', 1)->where('totalScore', '0.00');
        return view('personnelEvaluation.assessor.personnels.siapEvaluasi', compact(['users', 'values', 'lastSetting']));
    }

    public function prosesEvaluasi($jobId)
    {#320000#320000#320000
        $users          = $this->users();
        $lastSetting    = $this->setting($jobId);
        $values         = $lastSetting->evaluationValue->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 0);
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
