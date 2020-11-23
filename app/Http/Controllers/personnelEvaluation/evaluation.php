<?php
	/*
 			$user = User::find(58);
			return $user->jobDesc()->first()->kabupaten()->get();
			 


			//return $district = allvillage::where('KD_KAB', '3321')->first();

			$district = allvillage::find(410);

			return $district->jobDesc()->get();
			return User::find($district->jobDesc()->pluck('user_id'));
			 */




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
use Illuminate\Support\Arr;
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
		$id 										= Auth::user()->id;
		$lastYear 							= personnel_evaluation_setting::max('year');
		$lastQuarter 						= personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
		$myEvaluationSetting 		= User::find($id)->evaluationSetting->where('year', $lastYear)->where('quarter', $lastQuarter);
	 	$myEvaluationValues			= User::find( $id )->evaluationValue()->where('settingId', $myEvaluationSetting->pluck('id')->first());
		$evaluators 						= personnel_evaluator::where('evaluator', User::find($id)->posisi()->latest()->first()->id  )->get();	
	 	$lastSetting 						= personnel_evaluation_setting::where('year', $lastYear)->where('quarter', $lastQuarter)->get();
		$myZones								= explode(", ", User::find( $id )->areaKerja()->pluck('zone')->first());
		$allvillages 						= allvillage::all();


		$evaluationValue = [];

		for( $i = 0; $i < count($myZones); $i++  )
		{
			for( $y=0; $y < $evaluators->count(); $y++ )
			{	
				$job_id = $evaluators->pluck('jobId')[$y];
				$work_zone_ids = work_zone::where('district',$myZones[$i] )->pluck('id');		
				$jobDescUser = job_desc::where('job_title_id', $job_id)->whereIn('work_zone_id', $work_zone_ids )->get();

				$evaluationValue[$myZones[$i]][$job_id]['Personil'] = $jobDescUser;
				$evaluationValue[$myZones[$i]][$job_id]['BelumMengisi'] = $jobDescUser
					->whereNotIn('user_id', personnel_evaluation_value::whereIn('settingId', $lastSetting->pluck('id'))->pluck('userId'));
				
				$blm = [];
				$sdh = [];
				$belumDievaluasi = [];
				$siapDievaluasi = [];
				$prosesDievaluasi = [];
				$selesaiDievaluasi = [];

		//		return $jobDescUser;

				//				foreach($jobDescUser->whereIn('user_id', personnel_evaluation_value::whereIn('settingId', $lastSetting->pluck('id'))->pluck('userId')) as $userSdh)
				foreach($jobDescUser as $userSdh)

				{
					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 0)->count() > 0)
					{
						$blm[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 0)->first();	
					}

					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 1)->count() > 0)
					{
						$sdh[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 1)->first();	
					}

					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->count() > 0)
					{
						$belumDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->first();	
					}

					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->where('ok_by_user', 1)->count() > 0)
					{
						$siapDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->where('ok_by_user', 1)->first();	
					}

					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 0)->count() > 0)
					{
						$prosesDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 0)->first();	
					}

					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 1)->count() > 0)
					{
						$selesaiDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 1)->first();	
					}

				}
				
				$evaluationValue[$myZones[$i]][$job_id]['ProsesMengisi'] = $blm; 
				$evaluationValue[$myZones[$i]][$job_id]['SelesaiMengisi'] = $sdh;
				$evaluationValue[$myZones[$i]][$job_id]['BelumDievaluasi'] = $jobDescUser->whereNotIn('user_id', 
					$userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '!=', '0.00' )->pluck('userId'));
				$evaluationValue[$myZones[$i]][$job_id]['SiapDievaluasi'] = $siapDievaluasi; 
				$evaluationValue[$myZones[$i]][$job_id]['ProsesDievaluasi'] = $prosesDievaluasi; 
				$evaluationValue[$myZones[$i]][$job_id]['SelesaiDievaluasi'] = $selesaiDievaluasi; 

			}
		}

	 	   $evaluationValues = collect($evaluationValue);

		return view('personnelEvaluation.index', compact(['myEvaluationSetting', 'myEvaluationValues', 'evaluators', 'evaluationValues', 'myZones', 'allvillages',
		'lastYear', 'lastQuarter', 'lastSetting']));
	}

	//====================================================== index ==============================================================================================	
	
	public function home($district, $jobId, $evaluasi)
	{
		$id 										= Auth::user()->id;
		$lastYear 							= personnel_evaluation_setting::max('year');
		$lastQuarter 						= personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
		$myEvaluationSetting 		= User::find($id)->evaluationSetting->where('year', $lastYear)->where('quarter', $lastQuarter);
	 	$myEvaluationValues			= User::find( $id )->evaluationValue()->where('settingId', $myEvaluationSetting->pluck('id')->first());
		$evaluators 						= personnel_evaluator::where('evaluator', User::find($id)->posisi()->latest()->first()->id  )->get();	
	 	$lastSetting 						= personnel_evaluation_setting::where('year', $lastYear)->where('quarter', $lastQuarter)->where('jobTitleId', $jobId)->get();
		$myZones								= explode(", ", User::find( $id )->areaKerja()->pluck('zone')->first());
		$allvillages 						= allvillage::all();


		$evaluationValue = [];

		for( $i = 0; $i < count($myZones); $i++  )
		{
			for( $y=0; $y < $evaluators->count(); $y++ )
			{	
				$job_id = $evaluators->pluck('jobId')[$y];
				$work_zone_ids = work_zone::where('district',$myZones[$i] )->pluck('id');		
				$jobDescUser = job_desc::where('job_title_id', $jobId)
					->join( 'work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id' )
					->where('district', $district)->get();

				$evaluationValue[$myZones[$i]][$job_id]['Personil'] = $jobDescUser;
				$evaluationValue[$myZones[$i]][$job_id]['BelumMengisi'] = $jobDescUser
					->whereNotIn('user_id', personnel_evaluation_value::whereIn('settingId', $lastSetting->pluck('id'))->pluck('userId'));
				
				$blm = [];
				$sdh = [];
				$belumDievaluasi = [];
				$siapDievaluasi = [];
				$prosesDievaluasi = [];
				$selesaiDievaluasi = [];
				foreach($jobDescUser->whereIn('user_id', personnel_evaluation_value::whereIn('settingId', $lastSetting->pluck('id'))->pluck('userId')) as $userSdh)
				{
					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 0)->count() > 0)
					{
						$blm[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 0)->first();	
					}

					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 1)->count() > 0)
					{
						$sdh[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 1)->first();	
					}

					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->count() > 0)
					{
						$belumDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->first();	
					}

					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->where('ok_by_user', 1)->count() > 0)
					{
						$siapDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->where('ok_by_user', 1)->first();	
					}

					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 0)->count() > 0)
					{
						$prosesDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 0)->first();	
					}

					if($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 1)->count() > 0)
					{
						$selesaiDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 1)->first();	
					}
				}
				
				$evaluationValue[$myZones[$i]][$job_id]['ProsesMengisi'] = $blm; 
				$evaluationValue[$myZones[$i]][$job_id]['SelesaiMengisi'] = $sdh;
				$evaluationValue[$myZones[$i]][$job_id]['SiapDievaluasi'] = $siapDievaluasi; 
				$evaluationValue[$myZones[$i]][$job_id]['ProsesDievaluasi'] = $prosesDievaluasi; 
				$evaluationValue[$myZones[$i]][$job_id]['SelesaiDievaluasi'] = $selesaiDievaluasi;
				$evaluationValue[$myZones[$i]][$job_id]['BelumDievaluasi'] = $jobDescUser->whereNotIn('user_id', 
					$userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '!=', '0.00' )->pluck('userId'));
			}
		}
	 	 $evaluationValues = collect($evaluationValue); 
					  
		if($evaluasi == "sudah-mengisi-evkinja"){
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['SelesaiMengisi'], 'userId');
		} elseif ($evaluasi == "sedang-mengisi-evkinja"){
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['ProsesMengisi'], 'userId');	
		} elseif($evaluasi == "belum-mengisi-evkinja") {
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['BelumMengisi'], 'user_id');
		} elseif($evaluasi == "selesai-dievaluasi"){
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['SelesaiDievaluasi'], 'userId');
		} elseif ($evaluasi == "sedang-dievaluasi"){
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['ProsesDievaluasi'], 'userId');
		} elseif($evaluasi == "siap-dievaluasi") {
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['SiapDievaluasi'], 'userId');
		}
		 $users = User::find($evkinUsers);

		return view('personnelEvaluation.evaluation.index', compact(['users', 'evaluasi', 'evaluators', 'lastSetting']));
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
	
	//==================================================  edit =====================================================================================================
	
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
