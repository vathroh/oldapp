<?php

namespace App\Http\Controllers\personnelEvaluation\beingAssessed;

use App\personnel_evaluation_criteria;
use App\Http\Controllers\Controller;
use App\personnel_evaluation_aspect;
use App\personnel_evaluation_value;
use Illuminate\Http\Request;
use App\job_desc;
use Carbon\Carbon;

class inputAchievementController extends Controller
{
    public function __construct()
    {
        // $this->middlewarevaluationBeingAssessedMiddleware']);
        $this->middleware('auth');
    }

    public function index($valueId)
    {
        $aspects        = personnel_evaluation_aspect::get();
        $criterias      = personnel_evaluation_criteria::get();
        $value          = personnel_evaluation_value::find($valueId);
        $time           = Carbon::parse($value->evaluationSetting->year . '-' . $value->evaluationSetting->quarter * 3);
        $content        = unserialize($value->content);

        $job_desc     = job_desc::withoutGlobalScopes()
            ->where('user_id', $value->user->id)->where('starting_date', '<', $time)
            ->where('finishing_date', '>', $time)->get();

        return view('personnelEvaluation.beingAssessed.achievement.index', compact(['aspects', 'criterias',  'value', 'content', 'job_desc']));
    }

    public function ok($valueId)
    {

        personnel_evaluation_value::where('id', $valueId)->update([
            'ok_by_user' => '1',
        ]);

        return redirect('personnel-evaluation');
    }
}
