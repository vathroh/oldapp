<?php

namespace App\Http\Controllers\personnelEvaluation\assessor;

use App\User;
use App\job_desc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\personnel_evaluation_setting;

class showPersonnelsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $myZones        = explode(", ", Auth::user()->areaKerja->pluck('zone')->first());
        $users          = User::find(job_desc::join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')->whereIn('district', $myZones)->pluck('user_id'));
        return $users;
    }

    public function allpersonnels($jobId)
    {
        return $users          = $this->users();
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