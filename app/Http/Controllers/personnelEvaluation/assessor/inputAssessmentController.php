<?php

namespace App\Http\Controllers\personnelEvaluation\assessor;

use App\Http\Controllers\Controller;
use App\job_desc;
use App\personnel_evaluation_aspect;
use App\personnel_evaluation_criteria;
use App\personnel_evaluation_value;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\blacklist;
use App\personnel_evaluation_upload;

class inputAssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($valueId)
    {
        $aspects        = personnel_evaluation_aspect::get();
        $criterias      = personnel_evaluation_criteria::get();
        $value          = personnel_evaluation_value::find($valueId);
        $time           = Carbon::parse($value->evaluationSetting->year . '-' . $value->evaluationSetting->quarter * 3);
        $files          = personnel_evaluation_upload::where('personnel_evaluation_value_id', $valueId)->get();
        $content        = unserialize($value->content);
        $blacklists     = blacklist::all();

        $job_desc     = job_desc::withoutGlobalScopes()
            ->where('user_id', $value->user->id)->where('starting_date', '<', $time)
            ->where('finishing_date', '>', $time)->get();

        return view('personnelEvaluation.assessor.assessment.index', compact(['blacklists', 'value', 'aspects', 'criterias', 'job_desc', 'content', 'files']));
    }

    public function ok($valueId)
    {
        personnel_evaluation_value::where('id', $valueId)->update(['ready' => '1']);
        return redirect('personnel-evaluation');
    }

    public function edit($valueId)
    {
        personnel_evaluation_value::where('id', $valueId)->update(['edit' => '1', 'ready' => '1']);
        return redirect('personnel-evaluation');
    }
}
