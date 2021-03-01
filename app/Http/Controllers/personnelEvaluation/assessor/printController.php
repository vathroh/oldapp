<?php

namespace App\Http\Controllers\personnelEvaluation\assessor;

use App\blacklist;
use App\Http\Controllers\Controller;
use App\job_desc;
use App\personnel_evaluation_aspect;
use App\personnel_evaluation_criteria;
use App\personnel_evaluation_setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class printController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $evaluationSettings = personnel_evaluation_setting::select('quarter', 'year', 'id')->groupBy('quarter')->groupBy('year')->orderByDesc('year')->limit(4)->get();
        return view('personnelEvaluation.assessor.print.index', compact('evaluationSettings'));
    }

    public function show($id)
    {
        $timestamp = Carbon::parse(personnel_evaluation_setting::find($id)->year . '-' . personnel_evaluation_setting::find($id)->quarter * 3)->timestamp;
        $evaluationSettings = personnel_evaluation_setting::where('quarter', personnel_evaluation_setting::find($id)->quarter)->where('year', personnel_evaluation_setting::find($id)->year)->get();

        return view('personnelEvaluation.assessor.print.show', compact('evaluationSettings'));
    }

    public function print($id)
    {
        $evaluationSetting = personnel_evaluation_setting::find($id);
        $jobDesc = job_desc::withoutGlobalScopes()->selectRaw('*, unix_timestamp(finishing_date) as finishing_date_timestamp, unix_timestamp(starting_date) as starting_date_timestamp')->get();
        $aspects = personnel_evaluation_aspect::all();
        $criterias = personnel_evaluation_criteria::all();
        $blacklists = blacklist::all();
        return view('personnelEvaluation.assessor.print.print', compact(['blacklists', 'evaluationSetting', 'jobDesc', 'aspects', 'criterias']));
    }
}
