<?php

namespace App\Http\Controllers\personnelEvaluation\assessor;

use App\Http\Controllers\Controller;
use App\job_desc;
use App\personnel_evaluation_setting;
use App\personnel_evaluator;
use App\work_zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class rekapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $evaluationSettings = personnel_evaluation_setting::select('quarter', 'year', 'id')->groupBy('quarter')->groupBy('year')->orderByDesc('year')->limit(4)->get();
        return view('personnelEvaluation.assessor.rekap.index', compact('evaluationSettings'));
    }

    public function show($id)
    {
        $timestamp = Carbon::parse(personnel_evaluation_setting::find($id)->year . '-' . personnel_evaluation_setting::find($id)->quarter * 3)->timestamp;
        $jobDesc = job_desc::withoutGlobalScopes()->selectRaw('*, unix_timestamp(finishing_date) as finishing_date_timestamp, unix_timestamp(starting_date) as starting_date_timestamp')->get();
        $myCurrentJobDesc = $jobDesc->where('user_id', Auth::user()->id)->where('finishing_date_timestamp', '>', $timestamp)->where('starting_date_timestamp', '<', $timestamp)->first();
        $evaluationSettings = $myCurrentJobDesc->evaluationSettings->where('quarter', personnel_evaluation_setting::find($id)->quarter)->where('year', personnel_evaluation_setting::find($id)->year);
        $workZone = work_zone::whereIn('district', explode(', ', work_zone::find($myCurrentJobDesc->work_zone_id)->zone))->where('level', 'Tim Faskel')->get();
        $userId = $jobDesc->whereIn('work_zone_id', $workZone->pluck('id'));
        return view('personnelEvaluation.assessor.rekap.show', compact(['evaluationSettings', 'workZone', 'userId', 'jobDesc']));
    }
}
