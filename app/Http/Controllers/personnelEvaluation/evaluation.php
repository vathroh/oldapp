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
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$isUser		= personnel_evaluation_value::join('users', 'users.id', '=', 'personnel_evaluation_values.userId')->get();			
		$notUser	= User::join('job_descs', 'job_descs.user_id', '=', 'users.id')->select('users.id', 'name', 'job_title_id')->get();						
		$settings 	= personnel_evaluation_setting::join('job_titles', 'personnel_evaluation_settings.jobTitleId', '=', 'job_titles.id')
					->orderBy('year', 'desc')->select('personnel_evaluation_settings.id', 'quarter', 'year', 'job_title', 'jobTitleId')
					->where('status', 1)->get();
		$value		= personnel_evaluation_value::where('userId', Auth::user()->id)->get();
		
		return view('personnelEvaluation.index', compact(['isUser', 'notUser', 'settings', 'evaluators', 'value']));
	}
	
	
	public function home($settingId, $evaluasi)
	{
		
		$setting 	= personnel_evaluation_setting::join('job_titles', 'personnel_evaluation_settings.jobTitleId', '=', 'job_titles.id')
						->where('personnel_evaluation_settings.id', $settingId)->select('personnel_evaluation_settings.id', 'quarter', 'year', 'job_title', 'jobTitleId')->get();
					
		$isUser		= personnel_evaluation_value::join('users', 'users.id', '=', 'personnel_evaluation_values.userId')
					->where('settingId', $settingId)->get();
					
					
		if($evaluasi == "sudah-dievaluasi"){
			$users	= $isUser->where('ready', "1");
		} elseif ($evaluasi == "dalam-proses-evaluasi"){
			$users	= $isUser->where('ready', '0');			
		} else {
			$users 	= User::join('job_descs', 'job_descs.user_id', '=', 'users.id')->whereNotIn('users.id', $isUser->pluck('id'))
					->where('job_title_id', $setting[0]->jobTitleId)->select('users.id', 'name', 'job_title_id')->get();
		}
		
		return view('personnelEvaluation.evaluation.index', compact(['setting', 'users', 'evaluasi']));
	}
	
	public function monitoring()
    {
		$job_titles	= job_title::distinct('job_titles.id')->leftjoin('job_descs', 'job_titles.id', '=', 'job_descs.job_title_id')
					->select('job_titles.id', 'job_titles.job_title', 'level')->get();
		$districts	= allvillage::get()->unique('KD_KAB');
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$isUser		= personnel_evaluation_value::join('users', 'users.id', '=', 'personnel_evaluation_values.userId')->get();			
		$notUser	= User::join('job_descs', 'job_descs.user_id', '=', 'users.id')->select('users.id', 'name', 'job_title_id')->get();						
		$settings 	= personnel_evaluation_setting::join('job_titles', 'personnel_evaluation_settings.jobTitleId', '=', 'job_titles.id')
					->orderBy('year', 'desc')->select('personnel_evaluation_settings.id', 'quarter', 'year', 'job_title', 'jobTitleId')
					->where('status', 1)->get();					
		return view('personnelEvaluation.monitoring', compact(['isUser', 'notUser', 'settings', 'evaluators', 'job_titles', 'districts']));
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
			$data[$request->criteria][$request->aspect]['variabel'] 	= $request->variabel;
		}
		if(isset($request->capaian)){
			$data[$request->criteria][$request->aspect]['capaian'] 		= $request->capaian;
		}
		if(isset($request->evidences)){
			$data[$request->criteria][$request->aspect]['evidences'] 	= $request->evidences;
		}
		if(isset($request->assesment)){
			$data[$request->criteria][$request->aspect]['assesment'] 	= $request->assesment;
		}
		if(isset($request->score)){
			$data[$request->criteria][$request->aspect]['score'] 		= $request->score;
		}
		
		if(isset($request->totalScores)){
			personnel_evaluation_value::where('id', $request->value)->update([
				'totalScore'		=> $request->totalScores
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
		
		return response($data);
		
	}
	
	
	public function inputValue($settingId, $userId)
	{	
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
		
		
		return view('personnelEvaluation.evaluation.input', compact(['settingId', 'userId', 'user']));
	}
	
	
	public function input($settingId, $userId)
	{	
				
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
				
		return view('personnelEvaluation.evaluation.create', compact(['aspects', 'criterias', 'criteriIds', 'setting', 'user', 'value', 'content']));
	}
	
	
	public function download($settingId, $userId)
	{
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

		
		return view('personnelEvaluation.evaluation.download', compact(['aspects', 'criterias', 'criteriIds', 'setting', 'user', 'value', 'content']));
		$pdf = PDF::loadView('personnelEvaluation.evaluation.download', compact(['aspects', 'criterias', 'criteriIds', 'setting', 'user', 'value', 'content']));
		return $pdf->setPaper('a4', 'portrait')->download('Evkinja.pdf');
	}
	
	
	public function rekap()
	{
		$evaluations= personnel_evaluation_value::get();
		$users		= personnel_evaluation_value::join('users', 'users.id', '=', 'personnel_evaluation_values.userId')->where('ready', 1)
					->get();
		$jobDescs	= job_desc::join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
					->join('work_zones', 'work_zones.id','=', 'job_descs.work_zone_id')
					->join('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')
					->get();
		return view('personnelEvaluation.evaluation.rekap', compact(['users', 'jobDescs', 'evaluations']));
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
	
	
	
	public function editPermission()
	{
		$personnels = personnel_evaluation_value::where('edit', 1)->distinct('users.id')
					->join('personnel_evaluation_settings', 'personnel_evaluation_values.settingId', '=', 'personnel_evaluation_settings.id')					
					->join('job_descs', 'job_descs.user_id', '=', 'personnel_evaluation_values.userId')
					->join('users', 'users.id', '=', 'personnel_evaluation_values.userId' )
					->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
					->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
					->join('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')
					->select('personnel_evaluation_values.id', 'userId', 'users.name', 'job_title', 'quarter', 'year', 'NAMA_KAB')->get();
		return view('personnelEvaluation.edit', compact('personnels'));
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
	
	
	public function ajaxHome()
	{
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$isUser		= personnel_evaluation_value::join('users', 'users.id', '=', 'personnel_evaluation_values.userId')->get();			
		$notUser	= User::join('job_descs', 'job_descs.user_id', '=', 'users.id')->select('users.id', 'name', 'job_title_id')->get();						
		$settings 	= personnel_evaluation_setting::join('job_titles', 'personnel_evaluation_settings.jobTitleId', '=', 'job_titles.id')
					->orderBy('year', 'desc')->select('personnel_evaluation_settings.id', 'quarter', 'year', 'job_title', 'jobTitleId')
					->where('status', 1)->get();
		$value		= personnel_evaluation_value::where('userId', Auth::user()->id)->get();
		
		return response()->json([$isUser, $notUser, $settings, $evaluators, $value]);
	}
	
}
