<?php

namespace App\Http\Controllers\personnelEvaluation;

use App\personnel_evaluation_criteria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\personnel_evaluator;
use Illuminate\Http\Request;
use App\job_desc;

class criteria extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$criterias = personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
		return view('personnelEvaluation.criteria.index', compact(['criterias', 'evaluators']));
	}
	
	
	public function create()
	{
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		return view('personnelEvaluation.criteria.create', compact('evaluators'));
	}
	
	
	public function store(Request $request)
	{
		personnel_evaluation_criteria::create([
			'criteria' 		=> $request->personnelEvaluationCriteriaName,
			'proportion' 	=> $request->personnelEvaluationCriteriaProportion
		]);
		
		return redirect('/personnel-evaluation-criteria');
	}
}
