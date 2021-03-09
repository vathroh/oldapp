<?php

namespace App\Http\Controllers\personnelEvaluation\hrm;

use App\blacklist;
use App\job_desc;
use App\Http\Controllers\Controller;
use App\kabupaten;
use App\personnel_evaluation_aspect;
use App\personnel_evaluation_criteria;
use App\personnel_evaluation_setting;
use App\work_zone;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class printController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $evaluationSettings = personnel_evaluation_setting::select('quarter', 'year', 'id')->groupBy('quarter')->groupBy('year')->orderByDesc('year')->limit(4)->get();
        return view('personnelEvaluation.hrm.print.index', compact('evaluationSettings'));
    }

    public function show($id)
    {
        $timestamp = Carbon::parse(personnel_evaluation_setting::find($id)->year . '-' . personnel_evaluation_setting::find($id)->quarter * 3)->timestamp;
        $evaluationSettings = personnel_evaluation_setting::where('quarter', personnel_evaluation_setting::find($id)->quarter)->where('year', personnel_evaluation_setting::find($id)->year)->get();

        return view('personnelEvaluation.hrm.print.show', compact('evaluationSettings'));
    }

    public function print($id)
    {
        $evaluationSetting = personnel_evaluation_setting::find($id);
        $timestamp = Carbon::parse(personnel_evaluation_setting::find($id)->year . '-' . personnel_evaluation_setting::find($id)->quarter * 3)->timestamp;
        $jobDesc = job_desc::withoutGlobalScopes()->leftjoin('work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id')->select('job_descs.*', 'district', 'zone', DB::raw('unix_timestamp(finishing_date) as finishing_date_timestamp'), DB::raw('unix_timestamp(starting_date) as starting_date_timestamp'))->get();
        $currentjobDesc =  $jobDesc->where('finishing_date_timestamp', '>', $timestamp)->where('starting_date_timestamp', '<', $timestamp);

        $criterias = personnel_evaluation_criteria::all();
        $aspects = personnel_evaluation_aspect::all();
        $blacklists = blacklist::all();
        $districts = kabupaten::all();
        $workZones = work_zone::with('districts')->get();

        return view('personnelEvaluation.hrm.print.print', compact(['blacklists', 'evaluationSetting', 'currentjobDesc', 'aspects', 'criterias', 'workZones', 'districts']));
    }
}
