<?php

namespace App\Http\Controllers\personnelEvaluation\hrm;

use App\Http\Controllers\Controller;
use App\job_desc;
use App\personnel_evaluation_setting;
use App\work_zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class rekapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $evaluationSettings = personnel_evaluation_setting::select('quarter', 'year', 'id')->groupBy('quarter')->groupBy('year')->orderByDesc('year')->limit(4)->get();
        return view('personnelEvaluation.hrm.rekap.index', compact('evaluationSettings'));
    }

    public function show($id)
    {
        $timestamp = Carbon::parse(personnel_evaluation_setting::find($id)->year . '-' . personnel_evaluation_setting::find($id)->quarter * 3)->timestamp;
        $jobDesc = job_desc::withoutGlobalScopes()->selectRaw('*, unix_timestamp(finishing_date) as finishing_date_timestamp, unix_timestamp(starting_date) as starting_date_timestamp')->get();
        $evaluationSettings = personnel_evaluation_setting::where('quarter', personnel_evaluation_setting::find($id)->quarter)->where('year', personnel_evaluation_setting::find($id)->year)->join('job_titles', 'personnel_evaluation_settings.jobTitleId', '=', 'job_titles.id')->select('personnel_evaluation_settings.*', 'sort')->orderBy('sort')->get();

        return view('personnelEvaluation.hrm.rekap.show', compact(['evaluationSettings', 'jobDesc']));
    }
}
