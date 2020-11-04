<?php

namespace App\Http\Controllers\personnelEvaluation;

use App\personnel_evaluation_criteria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class criteria extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
		$criterias = personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
		return view('personnelEvaluation.criteria.index', compact('criterias'));
	}
	
	
	public function create()
	{
		return view('personnelEvaluation.criteria.create');
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
