<?php

namespace App\Http\Controllers\personnelEvaluation;

use App\personnel_evaluation_criteria;
use App\Http\Controllers\Controller;
use App\personnel_evaluation_aspect;
use Illuminate\Http\Request;
use App\job_title;

class aspect extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }


    public function index() 
    {
		$criterias 	= personnel_evaluation_criteria::all();
		$aspects 	= personnel_evaluation_aspect::orderBy('created_at', 'desc')->get();
		return view('personnelEvaluation.aspect.index', compact(['aspects', 'criterias']));
	}
	
	
	public function create()
	{
		$jobTitles	= job_title::distinct('job_title')
						->join('job_descs', 'job_descs.job_title_id', '=', 'job_titles.id')	
						->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						->whereNotIn('work_zones.level', ['OSP'])
						->select('job_title_id', 'job_title')
						->orderBy('job_titles.id')
						->get();
						
		$criterias = personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
		
		return view('personnelEvaluation.aspect.create', compact(['criterias', 'jobTitles']));
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
