<?php


namespace App\Http\Controllers\personnelEvaluation;


use App\personnel_evaluation_criteria;
use App\personnel_evaluation_setting;
use Illuminate\Support\Facades\Auth;
use App\personnel_evaluation_aspect;
use App\Http\Controllers\Controller;
use App\personnel_evaluation_value;
use App\personnel_evaluation_edit;
use Illuminate\Http\Request;
use App\personnel_evaluator;
use App\allvillage;
use App\job_title;
use App\work_zone;
use App\job_desc;
use App\User;
use PDF;

class evaluation extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
		{
			/*
 			$user = User::find(58);
			return $user->jobDesc()->first()->kabupaten()->get();
			 


			//return $district = allvillage::where('KD_KAB', '3321')->first();

			$district = allvillage::find(410);

//			return $district->jobDesc()->get();
			return User::find($district->jobDesc()->pluck('user_id'));
			 */

		$value				= personnel_evaluation_value::where('userId', Auth::user()->id )->get();
		$myEvaluations 	= personnel_evaluation_value::where('userId', Auth::user()->id )->get();
		$myZones			= explode(", ", job_desc::where('user_id', Auth::user()->id)->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
								    ->pluck('zone')->first());
						  
	 	$isUser				= personnel_evaluation_value::join('users', 'users.id', '=', 'personnel_evaluation_values.userId')
							  	  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
									  ->select('users.id', 'settingId', 'userId', 'totalScore', 'userTotalScore', 'ok_by_user', 'edit_by_user', 'ready', 'edit', 'name', 'district')
									  ->whereIn('district', $myZones)->get();			

		$notUser			= User::join('job_descs', 'job_descs.user_id', '=', 'users.id')->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
	 						  		->select('users.id', 'name', 'job_title_id', 'district')->whereNotIn('district', ["OSP-1"])->whereIn('district', $myZones)->get();
						  
		$evaluators 	= personnel_evaluator::where('evaluator', User::find(Auth::user()->id)->posisi()->latest()->first()->id)->get();	
		
		$settings 		= personnel_evaluation_setting::join('job_titles', 'personnel_evaluation_settings.jobTitleId', '=', 'job_titles.id')
						  		  ->select('personnel_evaluation_settings.id', 'quarter', 'year', 'job_title', 'jobTitleId')
									  ->orderBy('year', 'desc')->where('status', 1)->get();

		return view('personnelEvaluation.index', compact(['isUser', 'notUser', 'settings', 'evaluators', 'value', 'myEvaluations', 'myZones']));
	}
	
	
	public function home($settingId, $evaluasi)
	{
		$myZones	= explode(", ", job_desc::where('user_id', Auth::user()->id)->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
					  ->pluck('zone')->first());
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$setting 	= personnel_evaluation_setting::join('job_titles', 'personnel_evaluation_settings.jobTitleId', '=', 'job_titles.id')
						->where('personnel_evaluation_settings.id', $settingId)->select('personnel_evaluation_settings.id', 'quarter', 'year', 'job_title', 'jobTitleId')->get();
					
		$isUser		= personnel_evaluation_value::distinct('users.id')->join('users', 'users.id', '=', 'personnel_evaluation_values.userId')
					  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
					  ->join('job_titles', 'job_descs.job_title_id', '=', 'job_titles.id')->whereIn('district', $myZones)->where('settingId', $settingId)	  
					  ->join('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')->select('users.id', 'users.name', 'ok_by_user', 'job_title', 'district', 'NAMA_KAB', 'ready', 'totalScore')->get();
					  
					  
		if($evaluasi == "sudah-mengisi-evkinja"){
			$users	= $isUser->where('ok_by_user', "1");
		} elseif ($evaluasi == "sedang-mengisi-evkinja"){
			$users	= $isUser->where('ok_by_user', '0');			
		} elseif($evaluasi == "belum-mengisi-evkinja") {
			$users 	= User::distinct('users.id')->join('job_descs', 'job_descs.user_id', '=', 'users.id')->whereNotIn('users.id', $isUser->pluck('id'))
					  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')->where('job_title_id', $setting[0]->jobTitleId)
					  ->join('job_titles', 'job_descs.job_title_id', '=', 'job_titles.id')->join('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
					  ->whereIn('district', $myZones)->select('users.id', 'name', 'job_title_id', 'job_title', 'district', 'NAMA_KAB')->get();
		} elseif($evaluasi == "selesai-dievaluasi"){
			$users	= $isUser->where('ready', "1");
		} elseif ($evaluasi == "sedang-dievaluasi"){
			$users	= $isUser->where('ready', '0')->where('totalScore', '>', 0);			
		} elseif($evaluasi == "siap-dievaluasi") {
			$users	= $isUser->where('ok_by_user', "1")->where('ready', '0')->where('totalScore', 0);
		}
		
		return view('personnelEvaluation.evaluation.index', compact(['setting', 'users', 'evaluasi', 'evaluators']));
	}
	
	public function monitoring()
    {
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();        
		$job_titles	= job_title::distinct('job_titles.id')->leftjoin('job_descs', 'job_titles.id', '=', 'job_descs.job_title_id')
					->select('job_titles.id', 'job_titles.job_title', 'level')->get();
		$districts	= allvillage::get()->unique('KD_KAB');
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$isUser		= personnel_evaluation_value::join('users', 'users.id', '=', 'personnel_evaluation_values.userId')->get();			
		$notUser	= User::join('job_descs', 'job_descs.user_id', '=', 'users.id')->select('users.id', 'name', 'job_title_id')->get();						
		$settings 	= personnel_evaluation_setting::join('job_titles', 'personnel_evaluation_settings.jobTitleId', '=', 'job_titles.id')
					->orderBy('year', 'desc')->select('personnel_evaluation_settings.id', 'quarter', 'year', 'job_title', 'jobTitleId')
					->where('status', 1)->get();					
		return view('personnelEvaluation.monitoring', compact(['isUser', 'notUser', 'settings', 'evaluators', 'job_titles', 'districts', 'evaluators']));
	}
	
	
	public function edit($id)
	{
		personnel_evaluation_edit::create([
			'evaluation_value_id' => $id
		]);
		
		return redirect('personnel-evaluation');
	}
	
	
	
	public function create(Request $request)
	{	
		$data = unserialize(personnel_evaluation_value::where('id', $request->value)->pluck('content')->first());
		
		if(isset($request->variabel)){
			$data[$request->criteria][$request->aspect]['variabel'] 			= $request->variabel;
		}
		if(isset($request->capaian)){
			$data[$request->criteria][$request->aspect]['capaian'] 				= $request->capaian;
		}
		if(isset($request->evidences)){
			$data[$request->criteria][$request->aspect]['evidences'] 			= $request->evidences;
		}
		if(isset($request->assesment)){
			$data[$request->criteria][$request->aspect]['assesment'] 			= $request->assesment;
		}
		if(isset($request->score_by_evaluator)){
			$data[$request->criteria][$request->aspect]['score_by_evaluator']	= $request->score_by_evaluator;
		}
		
		if(isset($request->totalScore)){
			personnel_evaluation_value::where('id', $request->value)->update([
				'totalScore'		=> $request->totalScore
			]);
		}
		
		if(isset($request->kinerja)){
			personnel_evaluation_value::where('id', $request->value)->update([
				'finalResult'		=> $request->kinerja
			]);
		}
		
		personnel_evaluation_value::where('id', $request->value)->update([			
			'recommendation'	=> $request->recommendation,
			'content' 			=> serialize($data),
			'issue'				=> $request->issue,
			'team'				=> $request->team
		]);
		
		return response($request);
		
	}
	
	
	public function userCreate(Request $request)
	{	
		$data = unserialize(personnel_evaluation_value::where('id', $request->value)->pluck('content')->first());
		
		if(isset($request->variabel)){
			$data[$request->criteria][$request->aspect]['variabel'] 	= $request->variabel;
		}
		if(isset($request->capaian)){
			$data[$request->criteria][$request->aspect]['capaian'] 		= $request->capaian;
		}
		if(isset($request->evidences)){
			$data[$request->criteria][$request->aspect]['evidences'] 	= $request->evidences;
		}
		if(isset($request->score)){
			$data[$request->criteria][$request->aspect]['score'] 		= $request->score;
		}
		
		if(isset($request->totalScores)){
			personnel_evaluation_value::where('id', $request->value)->update([
				'userTotalScore'		=> $request->totalScores
			]);
		}
		
		if(isset($request->kinerja)){
			personnel_evaluation_value::where('id', $request->value)->update([
				'userFinalResult'		=> $request->kinerja
			]);
		}
		
		personnel_evaluation_value::where('id', $request->value)->update([			
			'content' 			=> serialize($data),
			'team'				=> $request->team
		]);
		
		return response($data);
	}
	
	
	public function inputValue($settingId, $userId)
	{	
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		
		$user		= job_title::distinct('users.id')->join('job_descs', 'job_descs.job_title_id', '=', 'job_titles.id')
						->join('users', 'users.id', '=', 'job_descs.user_id')->where('users.id', $userId)
						->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						->join('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')						
						->select('users.id', 'name', 'job_title_id', 'job_title', 'NAMA_KAB')
						->get();
						
		if(personnel_evaluation_value::where('settingId', $settingId)->where('userId', $userId)->doesntExist())
		{
			personnel_evaluation_value::create([
				'settingId'	=> $settingId,
				'userId'	=> $userId
			]);
		}
		
		
		return view('personnelEvaluation.evaluation.input', compact(['settingId', 'userId', 'user', 'evaluators']));
	}
	
	
	public function input($settingId, $userId)
	{	
				
		$aspects 	= personnel_evaluation_aspect::get();
		$criterias 	= personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
		$criteriIds	= unserialize(personnel_evaluation_setting::where('id', $settingId)->pluck('aspectId')->first());	
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
			
		$setting 	= personnel_evaluation_setting::where('personnel_evaluation_settings.id', $settingId)
						->join('job_titles', 'job_titles.id', '=', 'personnel_evaluation_settings.JobTitleId')
						->get();
						
		$user		= job_title::distinct('users.id')->join('job_descs', 'job_descs.job_title_id', '=', 'job_titles.id')
						->join('users', 'users.id', '=', 'job_descs.user_id')->where('users.id', $userId)
						->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						->join('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')						
						->select('users.id', 'name', 'job_title_id', 'job_title', 'NAMA_KAB')
						->get();
						
						
		
		$value = personnel_evaluation_value::where('settingId', $settingId)->where('userId', $userId)->get();		
		
		if(!empty($value[0]->content)){
			$content	= unserialize($value[0]->content);
		} else {
			$content ="";
		}
				
		return view('personnelEvaluation.evaluation.create', compact(['aspects', 'criterias', 'criteriIds', 'setting', 'user', 'value', 'content', 'evaluators']));
	}
	
	
	public function download($settingId, $userId)
	{
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$aspects 	= personnel_evaluation_aspect::get();
		$criterias 	= personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
		$criteriIds	= unserialize(personnel_evaluation_setting::where('id', $settingId)->pluck('aspectId')->first());		
		$setting 	= personnel_evaluation_setting::where('personnel_evaluation_settings.id', $settingId)
						->join('job_titles', 'job_titles.id', '=', 'personnel_evaluation_settings.JobTitleId')
						->get();
						
		$user		= job_title::distinct('users.id')->join('job_descs', 'job_descs.job_title_id', '=', 'job_titles.id')
						->join('users', 'users.id', '=', 'job_descs.user_id')->where('users.id', $userId)
						->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						->join('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')						
						->select('users.id', 'name', 'job_title_id', 'job_title', 'NAMA_KAB')
						->get();						
		
		$value = personnel_evaluation_value::where('settingId', $settingId)->where('userId', $userId)->get();		
		
		if(!empty($value[0]->content)){
				$content	= unserialize($value[0]->content);
		} else {
			$content ="";
		}

		
		return view('personnelEvaluation.evaluation.download', compact(['aspects', 'criterias', 'criteriIds', 'setting', 'user', 'value', 'content', 'evaluators']));
		$pdf = PDF::loadView('personnelEvaluation.evaluation.download', compact(['aspects', 'criterias', 'criteriIds', 'setting', 'user', 'value', 'content']));
		return $pdf->setPaper('a4', 'portrait')->download('Evkinja.pdf');
	}
	
	
	public function rekap()
	{
		$myZones	= explode(", ", job_desc::where('user_id', Auth::user()->id)->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
					  ->pluck('zone')->first());
					  
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$evaluations= personnel_evaluation_value::get();
		
		$users		= personnel_evaluation_value::join('users', 'users.id', '=', 'personnel_evaluation_values.userId')
						  ->join('personnel_evaluation_settings', 'personnel_evaluation_settings.id', '=', 'personnel_evaluation_values.settingId')
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->select('users.id', 'settingId', 'userId', 'totalScore', 'userTotalScore', 'ok_by_user', 'edit_by_user', 'ready', 'edit', 'name', 'district', 'jobTitleId')->whereIn('district', $myZones)
						  ->get();
					
		$jobDescs	= job_desc::join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
					->join('work_zones', 'work_zones.id','=', 'job_descs.work_zone_id')
					->leftjoin('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')
					->get();
					
		return view('personnelEvaluation.evaluation.rekap', compact(['users', 'jobDescs', 'evaluations', 'evaluators']));
	}
	
	
	public function ready($valueId)
	{

		personnel_evaluation_value::where('id', $valueId)->update([
			'ready' => '1',
		]);
		
		return redirect('personnel-evaluation');
	}
	
	
	public function notReady($valueId)
	{

		personnel_evaluation_value::where('id', $valueId)->update([
			'edit' => '1',
		]);
		
		return redirect('personnel-evaluation');
	}
	
	
	public function userReady($valueId)
	{

		personnel_evaluation_value::where('id', $valueId)->update([
			'ok_by_user' => '1',
		]);
		
		return redirect('personnel-evaluation');
	}
	
	
	public function userNotReady($valueId)
	{

		personnel_evaluation_value::where('id', $valueId)->update([
			'edit_by_user' => '1',
		]);
		
		return redirect('personnel-evaluation');
	}
	
	
	
	public function editPermission()
	{
		
		$myZone	= explode(", ", User::join('job_descs', 'job_descs.user_id', '=',  'users.id')
					  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
					  ->where('users.id', Auth::user()->id)->pluck('zone')->first());
					  
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->pluck('jobId');
		
		$myJobId	= job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first();
		
		$personnels = personnel_evaluation_value::where('edit_by_user', 1)->distinct('personnel_evaluators.jobId')
					->join('personnel_evaluation_settings', 'personnel_evaluation_values.settingId', '=', 'personnel_evaluation_settings.id')					
					->join('job_descs', 'job_descs.user_id', '=', 'personnel_evaluation_values.userId')
					->join('users', 'users.id', '=', 'personnel_evaluation_values.userId' )
					->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
					->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
					->join('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')
					->join('personnel_evaluators', 'personnel_evaluators.jobId', '=', 'job_descs.job_title_id')
					->select('users.id', 'name', 'personnel_evaluators.evaluator', 'job_title', 'district', 'NAMA_KAB')
					->get();
					
		return view('personnelEvaluation.edit', compact(['personnels', 'evaluators', 'myJobId', 'myZone']));
	}
	
	
	public function editGrant($valueId)
	{
		personnel_evaluation_value::where('id', $valueId)->update([
			'edit' 	=> 0,
			'ready' => 0
		]);
		
		return redirect('personnel-evaluation-edit');
	}
	
	public function editDenied($valueId)
	{
		personnel_evaluation_value::where('id', $valueId)->update([
			'edit' 	=> 2
		]);
		
		return redirect('personnel-evaluation-edit');
	}
	
	
	public function userEditGrant($valueId)
	{
		personnel_evaluation_value::where('id', $valueId)->update([
			'edit_by_user' 	=> 0,
			'ok_by_user' => 0
		]);
		
		return redirect('personnel-evaluation-edit');
	}
	
	public function userEditDenied($valueId)
	{
		personnel_evaluation_value::where('id', $valueId)->update([
			'edit_by_user' 	=> 2
		]);
		
		return redirect('personnel-evaluation-edit');
	}
	
	
	public function ajaxHome(Request $request)
	{
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$isUser		= personnel_evaluation_value::join('users', 'users.id', '=', 'personnel_evaluation_values.userId')->get();			
		$notUser	= User::join('job_descs', 'job_descs.user_id', '=', 'users.id')->select('users.id', 'name', 'job_title_id')->get();
						
		$settings 	= personnel_evaluation_setting::join('job_titles', 'personnel_evaluation_settings.jobTitleId', '=', 'job_titles.id')
					->join('job_descs', 'job_descs.job_title_id', '=', 'job_titles.id')->selectRaw('quarter, year, job_title')
					->where('status', 1)->where('year', $request->year)->where('quarter', $request->quarter)->get();				
					
		$users		= User::join('job_descs', 'job_descs.user_id', '=', 'users.id')->get();						
					
		$value		= personnel_evaluation_value::where('userId', Auth::user()->id)->get();
		
		return response()->json([$settings, $users]);
	}
	
	public function myEvaluation()
	{	
		$myTitleId		= job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first();
		$myEvaluations 	= personnel_evaluation_value::where('userId', Auth::user()->id )->get();			
		$settings		= personnel_evaluation_setting::where('jobTitleId', $myTitleId)->get();
		$evaluators		= personnel_evaluator::where('evaluator', $myTitleId)->get();
				
		return view('personnelEvaluation.evaluation.myEvaluation', compact(['settings', 'evaluators', 'myEvaluations']));
	}
	
}
