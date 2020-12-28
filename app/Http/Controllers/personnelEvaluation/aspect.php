<?php

namespace App\Http\Controllers\personnelEvaluation;

use App\personnel_evaluation_criteria;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\personnel_evaluation_aspect;
use App\personnel_evaluator;
use Illuminate\Http\Request;
use App\job_title;
use App\job_desc;

class aspect extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }


    public function index() 
    {
		$jobTitles	= job_title::all();
		$criterias 	= personnel_evaluation_criteria::all();
		$aspects 	= personnel_evaluation_aspect::orderBy('created_at', 'desc')->get();
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		return view('personnelEvaluation.aspect.index', compact(['aspects', 'criterias', 'jobTitles', 'evaluators']));
	}
	
	
	public function create()
	{
		$jobTitles	= job_title::distinct('job_title')
						->leftjoin('job_descs', 'job_descs.job_title_id', '=', 'job_titles.id')	
						->whereNotIn('level', ['OSP'])
						->whereNotIn('job_title', ['Operator', 'Sekretaris'])
						->select('job_titles.id', 'job_title')
						->orderBy('job_titles.id')
						->get();
						
		$criterias = personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		
		return view('personnelEvaluation.aspect.create', compact(['criterias', 'jobTitles', 'evaluators']));
	}
	
	
	public function store(Request $request)
	{
		
		personnel_evaluation_aspect::create([
			'criteria_id' 	=> $request->personnelEvaluationCriteriaId,
			'aspect' 		=> $request->personnelEvaluationAspect,
			'evaluate_to'	=> $request->evaluateTo
		]);		
		
		return redirect('/personnel-evaluation-aspect');
	}
	
	
	
	
}
