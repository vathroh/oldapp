<?php

namespace App\Http\Controllers\personnelEvaluation\assessor;

use App\blacklist;
use App\Http\Controllers\Controller;
use App\job_desc;
use App\kabupaten;
use App\personnel_evaluation_aspect;
use App\personnel_evaluation_criteria;
use App\personnel_evaluation_setting;
use App\work_zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        return view('personnelEvaluation.assessor.print.index', compact('evaluationSettings'));
    }

    public function show($id)
    {

        $timestamp = Carbon::parse(personnel_evaluation_setting::find($id)->year . '-' . personnel_evaluation_setting::find($id)->quarter * 3)->timestamp;
        $jobDesc = job_desc::withoutGlobalScopes()->selectRaw('*, unix_timestamp(finishing_date) as finishing_date_timestamp, unix_timestamp(starting_date) as starting_date_timestamp')->get();
        $myJobDesc = $jobDesc->where('user_id', auth()->user()->id)->where('starting_date_timestamp', '<', $timestamp)->where('finishing_date_timestamp', '>', $timestamp);
        // dd($myJobDesc->first()->evaluator->pluck('jobId'));
        $evaluationSettings = personnel_evaluation_setting::where('quarter', personnel_evaluation_setting::find($id)->quarter)->where('year', personnel_evaluation_setting::find($id)->year)->whereIn('jobTitleId', $myJobDesc->first()->evaluator->pluck('jobId'))->get();
        // dd($evaluationSettings);

        return view('personnelEvaluation.assessor.print.show', compact('evaluationSettings'));
    }

    public function print($id)
    {

        $evaluationSetting = personnel_evaluation_setting::find($id);
        $timestamp = Carbon::parse(personnel_evaluation_setting::find($id)->year . '-' . personnel_evaluation_setting::find($id)->quarter * 3)->timestamp;
        $jobDesc = job_desc::withoutGlobalScopes()->leftjoin('work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id')->select('job_descs.*', 'district', 'zone', DB::raw('unix_timestamp(finishing_date) as finishing_date_timestamp'), DB::raw('unix_timestamp(starting_date) as starting_date_timestamp'))->get();
        $myJobDesc = $jobDesc->where('user_id', auth()->user()->id)->where('finishing_date_timestamp', '>', $timestamp)->where('starting_date_timestamp', '<', $timestamp)->first()->areaKerja->districts->pluck('id');
        $workZones = work_zone::with('districts')->get();
        $workZonesId = $workZones->whereIn('district_id', $myJobDesc)->pluck('id');
        $currentjobDesc =  $jobDesc->where('finishing_date_timestamp', '>', $timestamp)->where('starting_date_timestamp', '<', $timestamp)->whereIn('work_zone_id', $workZonesId);
        $criterias = personnel_evaluation_criteria::all();
        $aspects = personnel_evaluation_aspect::all();
        $blacklists = blacklist::all();
        $districts = kabupaten::all();

        return view('personnelEvaluation.assessor.print.print', compact(['blacklists', 'evaluationSetting', 'currentjobDesc', 'aspects', 'criterias', 'workZones', 'districts']));
    }
}
