<?php

namespace App\Http\Controllers\personnelEvaluation;

use App\Http\Controllers\EvkinjaController;
use App\Http\Controllers\ZoneController;
use App\personnel_evaluation_criteria;
use App\personnel_evaluation_setting;
use App\Http\Controllers\Controller;
use App\personnel_evaluation_aspect;
use Illuminate\Support\Facades\Auth;
use App\personnel_evaluator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\zone_location;
use App\zone_level;
use App\job_desc;
use App\job_title;
use App\work_zone;

class setup extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }


    public function evkinja()
    {
        return new EvkinjaController;
    }


    public function zone()
    {
        return new ZoneController;
    }


    public function index()
    {
        $settings = personnel_evaluation_setting::groupBy('quarter')->groupBy('year')->orderByDesc('year')->orderByDesc('quarter')->get();
        return view('personnelEvaluation.setup.index', compact('settings'));
    }


    public function setting_per_quarter($quarter, $year){
        $settings = personnel_evaluation_setting::where('quarter', $quarter)->where('year', $year)->join('job_titles', 'job_titles.id', '=', 'jobTitleId')->select('personnel_evaluation_settings.*','sort')->orderBy('sort')->get();
        
        $levels = zone_level::whereNotIn('id', [1])->get();
        
        return view('personnelEvaluation.setup.settings_per_quarter', compact(['settings', 'levels']));
    }


    public function get_job_title(Request $request){
        $jobTitles = job_title::where('zone_level_id', $request->level_id)->whereIn('level', ['Korkot','Tim Faskel','Askot Mandiri'])->whereNotIn('job_title', ['Sekretaris','Operator'])->orderBy('sort')->get();
        
        $wz = work_zone::where('zone_level_id', $request->level_id)->where('year', $this->zone()->this_year())->groupBy('zone_location_id')->pluck('zone_location_id');
        
        $workZones = zone_location::find($wz);
        return response()->json([$jobTitles, $workZones]);
    }

    public function activate($id){
        personnel_evaluation_setting::find($id)->update(['isActive' => true ]);
        return redirect ('/personnel-evaluation-setup-term/2/2021');
    }


    public function deactivate($id){
        personnel_evaluation_setting::find($id)->update(['isActive' => false]);
        return redirect ('/personnel-evaluation-setup-term/2/2021');
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
	
	
	public function store(Request $request)
    {
//        return $request;
		$setting = personnel_evaluation_setting::create([
			'quarter'		=> $request->quarter,
			'year'			=> $request->year,
            'jobTitleId'	=> $request->job_title,
            'zone_location_id' => $request->location
		]);

        return redirect('/personnel-evaluation-setup/' . $setting->id . '/edit');
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
	
	
	public function copy($SettingId)
	{
		$currentSetting = personnel_evaluation_Setting::where('id', $SettingId)->first();
		$lastSetting	= personnel_evaluation_Setting::where('jobTitleId', [$currentSetting->jobTitleId])->whereNotIn('id', [$SettingId])
						  ->where('status', 1)->latest()->first();
		
		if($lastSetting != "")
		{		
			personnel_evaluation_Setting::where('id', $SettingId)->update([
				'aspectId'	=> $lastSetting->aspectId
			]);
		}
		return redirect("/personnel-evaluation-setup/" . $SettingId . "/edit");
	}
	
}
