<?php

namespace App\Http\Controllers\personnelEvaluation;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\personnel_evaluator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\job_title;
use App\job_desc;
use App\User;

class evaluator extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
	
    public function index()
    {
			$jobTitles	= job_title::get();
			$evaluatorTeams = personnel_evaluator::get();
			$evaluators = personnel_evaluator::where('evaluator', User::find(Auth::user()->id )->posisi()->latest()->first()->id  )->get();	

			return view('personnelEvaluation.evaluator.index', compact(['evaluatorTeams', 'evaluators', 'jobTitles']));
	}
	
	
	public function create()
	{
		$jobTitles = job_title::all();
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		return view('personnelEvaluation.evaluator.create', compact(['jobTitles', 'evaluators']));
	}
	
	
	public function store(Request $request)
	{	
		$i=0;
		$requestArray = [];
		foreach($request->all() as $req){
			$requestArray[$i] = $req;
			$i++;
		}
		
		for($x= 2; $x < count($request->all()); $x++){
			$evaluator = $requestArray[$x];
			
			personnel_evaluator::create([
				'jobId'			=> $request->jobId,
				'evaluator'		=> $evaluator
			]);
		}

		return redirect('personnel-evaluator');
	}
	
	
	public function edit($id)
	{
		$jobTitles			= job_title::get();
		$evaluatorTeams	= personnel_evaluator::where('jobId', $id)->get();
		$evaluators 		= personnel_evaluator::where('evaluator', User::find(Auth::user()->id )->posisi()->latest()->first()->id  )->get();	

		return view('personnelEvaluation.evaluator.edit', compact(['evaluatorTeams', 'evaluators', 'jobTitles']));
	}
	
	
	public function update(Request $request, $id)
	{
		/*
		$i=0;
		$requestArray = [];
		foreach($request->all() as $req){
			$requestArray[$i] = $req;
			$i++;
		}
		
		for($x= 3; $x < count($request->all()); $x++){
			$evaluator[] = $requestArray[$x];
		}
		
		personnel_evaluator::where('id', $id)->update([
			'jobId'			=> $request->jobId,
			'evaluator'		=> serialize($evaluator)
		]);
		*/
		
		
		$i=0;
		$requestArray = [];
		$evaluatorCount = count($request->all())-3;		
		foreach($request->all() as $req){
			$requestArray[$i] = $req;
			$i++;
		}
		
		//return $requestArray;
		//return $id;
		
		$oldEvaluatorCount 	= personnel_evaluator::where('jobId', $id)->count();		
		$oldEvaluatorId[] = personnel_evaluator::where('jobId', $id)->pluck('id');	
		
		for($x= 3; $x < min($evaluatorCount, $oldEvaluatorCount) + 3; $x++){			
			personnel_evaluator::where('id', $oldEvaluatorId[0][$x-3])->update([
				'jobId'			=> $request->jobId,
				'evaluator'		=> $requestArray[$x]
			]);
			$keepEvaluatorId[$x-3] = $oldEvaluatorId[0][$x-3];
		}
		
		if($evaluatorCount > $oldEvaluatorCount){
			$diff = $evaluatorCount - $oldEvaluatorCount;
			
			for($x=0; $x < $diff; $x++){
				personnel_evaluator::create([
					'jobId'			=> $request->jobId,
					'evaluator'		=> $requestArray[$x + $oldEvaluatorCount + 3]
				]);
			}
		}
		

		if($evaluatorCount < $oldEvaluatorCount){			
			$diff = $oldEvaluatorCount - $evaluatorCount;		
			
			for($i = $evaluatorCount; $i < $oldEvaluatorCount; $i++){
				personnel_evaluator::where('id', $oldEvaluatorId[0][$i])->delete();
			}

		}
		
		
		return redirect('personnel-evaluator');
	}
	
	
	public function destroy($id)
	{
		personnel_evaluator::where('id', $id)->delete();
		return redirect('personnel-evaluator');
	}
	
	
	
	public function getEvaluator(Request $request)
	{
		$jobTitles = job_title::all();
		return response()->json($jobTitles);
	}
}
