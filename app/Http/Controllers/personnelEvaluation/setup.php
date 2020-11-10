<?php

namespace App\Http\Controllers\personnelEvaluation;

use App\personnel_evaluation_criteria;
use App\personnel_evaluation_setting;
use App\Http\Controllers\Controller;
use App\personnel_evaluation_aspect;
use Illuminate\Support\Facades\Auth;
use App\personnel_evaluator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\job_desc;
use App\job_title;

class setup extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }


    public function setupIndex()
    {	
		return view('personnelEvaluation.setup.index');
	}
    
    
    public function index()
    {	
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$settings 		= personnel_evaluation_setting::orderBy('created_at', 'desc')->get();
		$lastSettings	= personnel_evaluation_setting::where('year', $settings->pluck('year')->last())
						->where('quarter', $settings->pluck('quarter')->last())->get();
		
		$jobTitles 		= job_title::whereNotIn('level', ['OSP'])->whereNotIn('job_title', ['Operator', 'Sekretaris'])->whereNotIn('id', $settings->pluck('jobTitleId') )->get();
		$jobTitleAll	= job_title::all();
		return view('personnelEvaluation.setup.index', compact(['jobTitles', 'jobTitleAll', 'settings', 'lastSettings', 'evaluators']));
	}
	
	
	public function create()
	{
		$jobTitles	= job_title::get();
		$aspects 	= personnel_evaluation_aspect::get();
		$criteriIds	= unserialize(personnel_evaluation_setting::where('id', $id)->pluck('aspectId')->first());
		$setting 	= personnel_evaluation_setting::where('id', $id)->get();
		$criterias 	= personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		return view('personnelEvaluation.setup.create', compact(['setting', 'criterias', 'criteriIds', 'aspects', 'jobTitles', 'evaluators']));
	}
	
	
	public function store($quarter, $year, $jobTitleId)
	{
		personnel_evaluation_setting::create([
			'quarter'		=> $quarter,
			'year'			=> $year,
			'jobTitleId'	=> $jobTitleId
		]);
		$id = personnel_evaluation_setting::max('id');
		return redirect('/personnel-evaluation-setup/' . $id . '/edit');
	}
	
	
	public function show($id)
	{
		$setting = personnel_evaluation_setting::where('id', $id)->get();
		$criterias = personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		return view('personnelEvaluation.setup.create', compact(['setting', 'criterias', 'evaluators']));
	}
	
	
	public function edit($id)
	{
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$criteriIds	= unserialize(personnel_evaluation_setting::where('id', $id)->pluck('aspectId')->first());
		$setting 	= personnel_evaluation_setting::where('personnel_evaluation_settings.id', $id)->get();
		$aspects 	= personnel_evaluation_aspect::get();
		$criterias 	= personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
		$jobTitles	= job_title::get();
		
		return view('personnelEvaluation.setup.create', compact(['setting', 'criterias', 'criteriIds', 'aspects', 'jobTitles', 'evaluators']));
	}
	
	
	public function update(Request $request, $id)
	{
		$aspects = personnel_evaluation_setting::where('id', $id)->pluck('aspectId')->first();		
		
		if($aspects != "")
		{
			 $criteria = unserialize($aspects);
		} else {
			$criteria = [];
		}
			
		$count = count($criteria);
		$criteria[$count] = [intVal($request->criteria)];
		personnel_evaluation_setting::where('id', $id)->update([
			'aspectId' => serialize($criteria)
		]);
		
		return redirect('/personnel-evaluation-setup/' . $id . '/edit');		
	}
	
	
	public function ready($id)
	{
		personnel_evaluation_setting::where('id', $id)->update([
			'status' => 1
		]);
		return redirect('/personnel-evaluation-setup');	
	}
	
	public function destroy($id)
	{
		personnel_evaluation_setting::where('id', $id)->delete();
		return redirect('personnel-evaluation-setup');
	}
	
	public function notReady($id)
	{
		
		personnel_evaluation_setting::where('id', $id)->update([
			'status' => 0
		]);
		$aspects 	= personnel_evaluation_aspect::get();
		$criteriIds	= unserialize(personnel_evaluation_setting::where('id', $id)->pluck('aspectId')->first());
		$setting 	= personnel_evaluation_setting::where('personnel_evaluation_settings.id', $id)->get();
		$jobTitles	= job_title::get();
		$criterias 	= personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		return view('personnelEvaluation.setup.create', compact(['setting', 'criterias', 'criteriIds', 'aspects', 'jobTitles', 'evaluators']));
	}
	
	
	public function saveAspect(Request $request, $id)
	{	
		
		$aspects = personnel_evaluation_setting::where('id', $request->SettingId)->pluck('aspectId')->first();		
		
		if($aspects != "")
		{
			 $criteria = unserialize($aspects);
		} else {
			$criteria = [];
		}		
		
		$x = $request->criteriaNumber;
		$count = count($criteria[$x]);		
		$criteria[$x][$count] = intVal($request->aspect);	
				
		personnel_evaluation_setting::where('id', $request->SettingId)->update([
			'aspectId' => serialize($criteria)
		]);
			
		//return response()->json($criteria);
		return redirect('personnel-evaluation-setup/' . $id . '/edit');
	}
	
	
	public function ajaxJobTitles(Request $request)
	{
		$quarterYear	= [$request->kuartal, $request->tahun];
		$settings		= personnel_evaluation_setting::where('quarter', $request->kuartal)->where('year', $request->tahun)->get();
		$belumSiap 		= personnel_evaluation_setting::join('job_titles', 'job_titles.id', '=', 'personnel_evaluation_settings.jobTitleId')
						->where('quarter', $request->kuartal)->where('year', $request->tahun)->where('status', 0)->select('personnel_evaluation_settings.id', 'job_title')->get();
		$siap 			= personnel_evaluation_setting::join('job_titles', 'job_titles.id', '=', 'personnel_evaluation_settings.jobTitleId')
						->where('quarter', $request->kuartal)->where('year', $request->tahun)->where('status', 1)->select('personnel_evaluation_settings.id', 'job_title')->get();
		$jobTitles 		= job_title::distinct('job_title')->whereNotIn('level', ['OSP'])->whereNotIn('job_title', ['Sekretaris', 'Operator'])->whereNotIn('id',$settings->pluck('jobTitleId') )->get();		
		return response()->json([$jobTitles, $quarterYear, $belumSiap, $siap, $settings]);
	}
	
	
	
	public function deleteAspect(Request $request)
	{
		$aspects 	= unserialize(personnel_evaluation_setting::where('id', $request->settingId)->pluck('aspectId')->first());
		$id 		= personnel_evaluation_setting::where('id', $request->settingId)->pluck('id')->first();
		$aspect 	= $aspects[$request->criteriaNumber];
				
		$newAspects = array_splice($aspects, $request->criteriaNumber, 1);
		
		personnel_evaluation_setting::where('id', $id )->update([
			'aspectId' => serialize($aspects)
		]);
		
		return response()->json($aspects);
	}
	
	
	
	public function moveUpAspect(Request $request)
	{
		$aspects 	= unserialize(personnel_evaluation_setting::where('id', $request->settingId)->pluck('aspectId')->first());
		$id 		= personnel_evaluation_setting::where('id', $request->settingId)->pluck('id')->first();
		$aspectNew 	= $aspects[$request->criteriaNumber];
		$aspectOld 	= $aspects[$request->criteriaNumber-1];
		$aspects[$request->criteriaNumber-1] = $aspectNew;
		$aspects[$request->criteriaNumber] = $aspectOld;
		
		personnel_evaluation_setting::where('id', $request->settingId )->update([
			'aspectId' => serialize($aspects)
		]);
		
		return response()->json($aspects);
	}
		
	
	public function moveDownAspect(Request $request)
	{
		$aspects 	= unserialize(personnel_evaluation_setting::where('id', $request->settingId)->pluck('aspectId')->first());
		$id 		= personnel_evaluation_setting::where('id', $request->settingId)->pluck('id')->first();
		$aspectNew 	= $aspects[$request->criteriaNumber];
		$aspectOld 	= $aspects[$request->criteriaNumber+1];
		$aspects[$request->criteriaNumber+1] = $aspectNew;
		$aspects[$request->criteriaNumber] = $aspectOld;
		
		personnel_evaluation_setting::where('id', $id )->update([
			'aspectId' => serialize($aspects)
		]);
		
		return response()->json($aspects);
	}
	
	
	
	public function moveUpAspectItem(Request $request)
	{
		$aspects 	= unserialize(personnel_evaluation_setting::where('id', $request->settingId)->pluck('aspectId')->first());
		$id 		= personnel_evaluation_setting::where('id', $request->settingId)->pluck('id')->first();
		if($request->aspectNumber !=0)
		{
			$aspectNew 	= $aspects[$request->criteriaNumber][$request->aspectNumber+1];
			$aspectOld 	= $aspects[$request->criteriaNumber][$request->aspectNumber];
			$aspects[$request->criteriaNumber][$request->aspectNumber] = $aspectNew;
			$aspects[$request->criteriaNumber][$request->aspectNumber+1] = $aspectOld;
			
			personnel_evaluation_setting::where('id', $id )->update([
				'aspectId' => serialize($aspects)
			]);
		}
		
		return response()->json($aspects);
	}
	
	public function moveDownAspectItem(Request $request)
	{
		$aspects 	= unserialize(personnel_evaluation_setting::where('id', $request->settingId)->pluck('aspectId')->first());
		$id 		= personnel_evaluation_setting::where('id', $request->settingId)->pluck('id')->first();
		$aspectNew 	= $aspects[$request->criteriaNumber][$request->aspectNumber];
		$aspectOld 	= $aspects[$request->criteriaNumber][$request->aspectNumber+1];
		
		$aspects[$request->criteriaNumber][$request->aspectNumber+1] = $aspectNew;
		$aspects[$request->criteriaNumber][$request->aspectNumber] = $aspectOld;
		
		personnel_evaluation_setting::where('id', $id )->update([
			'aspectId' => serialize($aspects)
		]);
		
		return response()->json($aspects);
	}
	
	
	public function deleteAspectItem(Request $request)
	{
		$aspects 		= unserialize(personnel_evaluation_setting::where('id', $request->settingId)->pluck('aspectId')->first());
		$id 			= personnel_evaluation_setting::where('id', $request->settingId)->pluck('id')->first();
		$criterias 		= $aspects[$request->criteriaNumber];
		$aspect			= $criterias[$request->aspectNumber];
		$newAspects		= $aspects;
		
		array_splice($criterias, $request->aspectNumber, 1);		
		array_splice($aspects, $request->criteriaNumber, 1, [$criterias]);		
		
		personnel_evaluation_setting::where('id', $id )->update([
			'aspectId' => serialize($aspects)
		]);
		
		return response()->json($aspects);
	}
	
	public function ajaxAspect(Request $request)
	{
		$aspects 		= personnel_evaluation_aspect::where('evaluate_to', personnel_evaluation_setting::where('id', $request->setting)->pluck('jobTitleId')->first())->where('criteria_id', $request->id )->get();		
		return response()->json($aspects);
	}
	
	
	
}
