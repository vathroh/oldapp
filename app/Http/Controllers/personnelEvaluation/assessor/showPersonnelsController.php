<?php

namespace App\Http\Controllers\personnelEvaluation\assessor;

use App\User;
use App\job_desc;
use App\job_title;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\personnel_evaluation_setting;
use App\Http\Controllers\personnelEvaluation\evaluation;

class showPersonnelsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function evaluation(){
        return new evaluation;
    }

    public function data($jobId)
    {
        $dt = $this->evaluation()->data();
        $fasilitators =  $dt['being_assessed_by_me']->where('job_title_id', $jobId); 
        $values = $dt['value_assessed_by_me']->whereIn('userId', $fasilitators->pluck('user_id')) ;
  
        $data = [];
        $data['job_title'] = job_title::find($jobId);
        $data['fasilitators'] = $fasilitators;
        $data['values'] = $values;
        $data['thisQuarter'] = $dt['thisQuarter'];
        $data['thisYear'] = $dt['thisYear'];

        return $data;     
    }

    public function allpersonnels($jobId)
    {
        $data = $this->data($jobId);
        return view('personnelEvaluation.assessor.personnels.allpersonnels', compact(['data']));
    }

    public function belumMengisi($jobId)
    {
        $data = $this->data($jobId);
        $data['fasilitators'] = $data['fasilitators']->whereNotIn('user_id', $data['values']->pluck('userId'));
        return view('personnelEvaluation.assessor.personnels.belumMengisi', compact(['data']));
    }

    public function selesaiMengisi($jobId)
    {
        $data = $this->data($jobId);
        $data['values'] = $data['values']->where('ok_by_user', 1);
        return view('personnelEvaluation.assessor.personnels.selesaiMengisi', compact(['data']));
    }

    public function prosesMengisi($jobId)
    {
        $data = $this->data($jobId);
        $data['values'] = $data['values']->where('ok_by_user', 0);
        $data['fasilitators'] = $data['fasilitators']->whereIn('user_id', $data['values']->pluck('userId'));
        return view('personnelEvaluation.assessor.personnels.prosesMengisi', compact(['data']));
    }

    public function siapEvaluasi($jobId)
    {
        $data = $this->data($jobId);
        $data['values'] = $data['values']->where('ok_by_user', 1)->where('totalScore', '0.00');
        $data['fasilitators'] = $data['fasilitators']->whereIn('user_id', $data['values']->pluck('userId'));
        return view('personnelEvaluation.assessor.personnels.siapEvaluasi', compact(['data']));
    }

    public function prosesEvaluasi($jobId)
    {
        $data = $this->data($jobId);
        $data['values'] = $data['values']->where('ready', 0)->where('totalScore', '!=', '0.00');
        $data['fasilitators'] = $data['fasilitators']->whereIn('user_id', $data['values']->pluck('userId'));
        return view('personnelEvaluation.assessor.personnels.prosesEvaluasi', compact(['data']));
    }

    public function selesaiEvaluasi($jobId)
    {
        $data = $this->data($jobId);
        return view('personnelEvaluation.assessor.personnels.selesaiEvaluasi', compact(['data']));
    }

}
