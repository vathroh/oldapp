<?php

namespace App\Http\Controllers\personnelEvaluation;

use App\Http\Controllers\EvkinjaController;
use App\personnel_evaluation_criteria;
use App\personnel_evaluation_setting;
use Illuminate\Support\Facades\Auth;
use App\personnel_evaluation_aspect;
use App\Http\Controllers\Controller;
use App\personnel_evaluation_value;
use App\personnel_evaluation_edit;
use App\personnel_evaluation_upload;
use Illuminate\Http\Request;
use App\personnel_evaluator;
use Illuminate\Support\Arr;
use App\allvillage;
use App\job_title;
use App\work_zone;
use App\job_desc;
use App\User;
use Carbon\Carbon;
use PDF;

class evaluation extends Controller
{
    public function evkinja(){
        return new EvkinjaController;
    }


    public function __construct()
	{
		$this->middleware('auth');
    }

    public function data(){
        $location = Auth::user()->jobDesc->first()->areaKerja->zone_location_id;

        if( $location == 0 ){
            $location_id = 0;
        }else{
            $location_id = zone_location::find($location)->id;
        }

        $user = $this->evkinja()->user_now(Auth::user()->id);
        $being_assessed_by_me = $this->evkinja()->being_assessed_by_me($user['user_id']);
        $value_assessed_by_me = $this->evkinja()->all_values_now()->whereIn('userId', $being_assessed_by_me->pluck('user_id')); 

        $data = [
            'user' => $user,
            'mySetting' => $this->evkinja()->my_setting_now($user['job_title_id'],$location_id ),
            'myValue' => $this->evkinja()->my_value_now($user['user_id']),
            'thisQuarter' => $this->evkinja()->this_quarter(),
            'thisYear' => $this->evkinja()->this_year(),
            'being_assessed_by_me' => $being_assessed_by_me,
            'value_assessed_by_me' => $value_assessed_by_me
        ];

        return $data;

    }


	public function job_desc()
	{
		$lastYear 					= personnel_evaluation_setting::max('year');
		$lastQuarter 				= personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
		
		return job_desc::withoutGlobalScopes()->selectRaw('*, UNIX_TIMESTAMP(starting_date) as starting_timestamp, UNIX_TIMESTAMP(finishing_date) as finishing_timestamp')->get();
		
    }

    public function status(){
        $user = $this->evkinja()->user_now(Auth::user()->id);
        $data = $this->data();
        $status = [];
            
        if($this->evkinja()->my_value_now($user['user_id']) != ''){
            
            $status['isValue'] = true;
        }else{
            $status['isValue'] = false;
        }

        if($this->evkinja()->my_setting_now($user['job_title_id'], $user['location_id']) != ''){
           
            $status['isSetting'] = true;
        }else{
            $status['isSetting'] = false;
        }
        
        $status['isAssessor'] = $this->evkinja()->is_assessor(Auth::user()->id);

        return $status;
    }


    public function index()
    {
        $data = $this->data();
        $status = $this->status();
            
        if (Auth::user()->posisi->level == "OSP") {
            return view('personnelEvaluation.indexosp', compact(['data', 'status']));
        } else {
            return view('personnelEvaluation.indexkorkot', compact(['data', 'status']));
        }
    }


	public function evaluationValue()
	{
		$lastYear 					= personnel_evaluation_setting::max('year');
		$lastQuarter 				= personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
		$lastSetting 				= personnel_evaluation_setting::where('year', $lastYear)->where('quarter', $lastQuarter)->get();
		$evaluators 				= personnel_evaluator::where('evaluator', Auth::user()->posisi()->latest()->first()->id)
			->join('job_titles', 'job_titles.id', '=', 'personnel_evaluators.jobId')->orderBy('sort')->get();
		$myZones					= explode(", ", Auth::user()->areaKerja()->pluck('zone')->first());
		$evaluationValue = [];

		for ($i = 0; $i < count($myZones); $i++) {
			for ($y = 0; $y < $evaluators->count(); $y++) {
				$job_id = $evaluators->pluck('jobId')[$y];
				$work_zone_ids = work_zone::where('district', $myZones[$i])->pluck('id');
				$jobDescUser = job_desc::where('job_title_id', $job_id)->whereIn('work_zone_id', $work_zone_ids)->get();

				$evaluationValue[$myZones[$i]][$job_id]['Personil'] = $jobDescUser;
				$evaluationValue[$myZones[$i]][$job_id]['BelumMengisi'] = $jobDescUser
					->whereNotIn('user_id', personnel_evaluation_value::whereIn('settingId', $lastSetting->pluck('id'))->pluck('userId'));

				$blm = [];
				$sdh = [];
				$belumDievaluasi = [];
				$siapDievaluasi = [];
				$prosesDievaluasi = [];
				$selesaiDievaluasi = [];

				if ($jobDescUser->whereIn('user_id', personnel_evaluation_value::whereIn('settingId', $lastSetting->pluck('id'))->pluck('userId'))->count() > 0) {

					foreach ($jobDescUser->whereIn('user_id', personnel_evaluation_value::whereIn('settingId', $lastSetting->pluck('id'))->pluck('userId')) as $userSdh)

					//foreach($jobDescUser as $userSdh)

					{
						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 0)->count() > 0) {
							$blm[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 0)->first();
						}

						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 1)->count() > 0) {
							$sdh[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 1)->first();
						}

						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->count() > 0) {
							$belumDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->first();
						}

						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->where('ok_by_user', 1)->count() > 0) {
							$siapDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->where('ok_by_user', 1)->first();
						}

						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 0)->count() > 0) {
							$prosesDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 0)->first();
						}

						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 1)->count() > 0) {
							$selesaiDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 1)->first();
						}
					}

					$evaluationValue[$myZones[$i]][$job_id]['ProsesMengisi'] = $blm;
					$evaluationValue[$myZones[$i]][$job_id]['SelesaiMengisi'] = $sdh;
					$evaluationValue[$myZones[$i]][$job_id]['BelumDievaluasi'] = $jobDescUser->whereNotIn(
						'user_id',
						$userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '!=', '0.00')->pluck('userId')
					);
					$evaluationValue[$myZones[$i]][$job_id]['SiapDievaluasi'] = $siapDievaluasi;
					$evaluationValue[$myZones[$i]][$job_id]['ProsesDievaluasi'] = $prosesDievaluasi;
					$evaluationValue[$myZones[$i]][$job_id]['SelesaiDievaluasi'] = $selesaiDievaluasi;
				} else {
					$evaluationValue[$myZones[$i]][$job_id]['ProsesMengisi'] = [];
					$evaluationValue[$myZones[$i]][$job_id]['SelesaiMengisi'] = [];
					$evaluationValue[$myZones[$i]][$job_id]['BelumDievaluasi'] = $jobDescUser;
					$evaluationValue[$myZones[$i]][$job_id]['SiapDievaluasi'] = [];
					$evaluationValue[$myZones[$i]][$job_id]['ProsesDievaluasi'] = [];
					$evaluationValue[$myZones[$i]][$job_id]['SelesaiDievaluasi'] = [];
				}
			}

			$evaluationValues = collect($evaluationValue);
		}

		return $evaluationValues;
	}

	//====================================================== index ==============================================================================================	

	public function homeOSP($jobId, $evaluasi)
	{
		$evaluators = personnel_evaluator::where('evaluator', Auth::user()->posisi()->latest()->first()->id)->get();

		if ($evaluasi == "semua-personil") {
			$users = personnel_evaluator::where('evaluator', Auth::user()->posisi()->latest()->first()->id)->where('jobId', $jobId)->latest()->first()->user;
		} elseif ($evaluasi == "belum-mengisi-evkinja") {
			$users = personnel_evaluator::where('evaluator', Auth::user()->posisi()->latest()->first()->id)->where('jobId', $jobId)->latest()->first()->user
				->whereNotIn('id', personnel_evaluator::where('evaluator', Auth::user()->posisi()->latest()->first()->id)->where('jobId', $jobId)->latest()->first()
					->value->pluck('userId'));
		} elseif ($evaluasi == "proses") {
			$users = User::find(personnel_evaluator::where('evaluator', Auth::user()->posisi()->latest()->first()->id)->where('jobId', $jobId)->latest()->first()
				->value->where('ok_by_user', 0)->pluck('userId'));
		} elseif ($evaluasi == "selesai") {
			$users = User::find(personnel_evaluator::where('evaluator', Auth::user()->posisi()->latest()->first()->id)->where('jobId', $jobId)->latest()->first()
				->value->where('ok_by_user', 1)->pluck('userId'));
		} elseif ($evaluasi == "siap-dievaluasi") {
			$users = User::find(personnel_evaluator::where('evaluator', Auth::user()->posisi()->latest()->first()->id)->where('jobId', $jobId)->latest()->first()
				->value->where('ok_by_user', 1)->where('totalScore', '=', '0.00')->pluck('userId'));
		} elseif ($evaluasi == "sedang-dievaluasi") {
			$users = User::find(personnel_evaluator::where('evaluator', Auth::user()->posisi()->latest()->first()->id)->where('jobId', $jobId)->latest()->first()
				->value->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 0)->pluck('userId'));
		} elseif ($evaluasi == "selesai-dievaluasi") {
			$users = User::find(personnel_evaluator::where('evaluator', Auth::user()->posisi()->latest()->first()->id)->where('jobId', $jobId)->latest()->first()
				->value->where('ok_by_user', 1)->where('ready', 1)->pluck('userId'));
		}

		return view('personnelEvaluation.evaluation.indexOSP', compact(['users', 'evaluators', 'evaluasi']));
	}

	// ==========================================================================================================================================================


	public function home($district, $jobId, $evaluasi)
	{
		$id 										= Auth::user()->id;
		$lastYear 							= personnel_evaluation_setting::max('year');
		$lastQuarter 						= personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
		$myEvaluationSetting 		= User::find($id)->evaluationSetting->where('year', $lastYear)->where('quarter', $lastQuarter);
		$myEvaluationValues			= User::find($id)->evaluationValue()->where('settingId', $myEvaluationSetting->pluck('id')->first());
		$evaluators 						= personnel_evaluator::where('evaluator', User::find($id)->posisi()->latest()->first()->id)->get();
		$lastSetting 						= personnel_evaluation_setting::where('year', $lastYear)->where('quarter', $lastQuarter)->where('jobTitleId', $jobId)->get();
		$myZones								= explode(", ", User::find($id)->areaKerja()->pluck('zone')->first());
		$allvillages 						= allvillage::all();


		$evaluationValue = [];

		for ($i = 0; $i < count($myZones); $i++) {
			for ($y = 0; $y < $evaluators->count(); $y++) {
				$job_id = $evaluators->pluck('jobId')[$y];
				$work_zone_ids = work_zone::where('district', $myZones[$i])->pluck('id');
				$jobDescUser = job_desc::where('job_title_id', $jobId)
					->join('work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id')
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



				if ($jobDescUser->whereIn('user_id', personnel_evaluation_value::whereIn('settingId', $lastSetting->pluck('id'))->pluck('userId'))->count() > 0) {

					foreach ($jobDescUser->whereIn('user_id', personnel_evaluation_value::whereIn('settingId', $lastSetting->pluck('id'))->pluck('userId')) as $userSdh)

					//foreach($jobDescUser as $userSdh)

					{
						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 0)->count() > 0) {
							$blm[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 0)->first();
						}

						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 1)->count() > 0) {
							$sdh[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('ok_by_user', 1)->first();
						}

						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->count() > 0) {
							$belumDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->first();
						}

						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->where('ok_by_user', 1)->count() > 0) {
							$siapDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '=', 0)->where('ok_by_user', 1)->first();
						}

						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 0)->count() > 0) {
							$prosesDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 0)->first();
						}

						if ($userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 1)->count() > 0) {
							$selesaiDievaluasi[] = $userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '>', 0)->where('ready', 1)->first();
						}
					}

					$evaluationValue[$myZones[$i]][$job_id]['ProsesMengisi'] = $blm;
					$evaluationValue[$myZones[$i]][$job_id]['SelesaiMengisi'] = $sdh;
					$evaluationValue[$myZones[$i]][$job_id]['BelumDievaluasi'] = $jobDescUser->whereNotIn(
						'user_id',
						$userSdh->yangDievaluasi()->whereIn('settingId', $lastSetting->pluck('id'))->where('totalScore', '!=', '0.00')->pluck('userId')
					);
					$evaluationValue[$myZones[$i]][$job_id]['SiapDievaluasi'] = $siapDievaluasi;
					$evaluationValue[$myZones[$i]][$job_id]['ProsesDievaluasi'] = $prosesDievaluasi;
					$evaluationValue[$myZones[$i]][$job_id]['SelesaiDievaluasi'] = $selesaiDievaluasi;
				} else {
					$evaluationValue[$myZones[$i]][$job_id]['ProsesMengisi'] = [];
					$evaluationValue[$myZones[$i]][$job_id]['SelesaiMengisi'] = [];
					$evaluationValue[$myZones[$i]][$job_id]['BelumDievaluasi'] = $jobDescUser;
					$evaluationValue[$myZones[$i]][$job_id]['SiapDievaluasi'] = [];
					$evaluationValue[$myZones[$i]][$job_id]['ProsesDievaluasi'] = [];
					$evaluationValue[$myZones[$i]][$job_id]['SelesaiDievaluasi'] = [];
				}
			}


			$evaluationValues = collect($evaluationValue);
		}

		if ($evaluasi == "sudah-mengisi-evkinja") {
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['SelesaiMengisi'], 'userId');
		} elseif ($evaluasi == "sedang-mengisi-evkinja") {
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['ProsesMengisi'], 'userId');
		} elseif ($evaluasi == "belum-mengisi-evkinja") {
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['BelumMengisi'], 'user_id');
		} elseif ($evaluasi == "selesai-dievaluasi") {
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['SelesaiDievaluasi'], 'userId');
		} elseif ($evaluasi == "sedang-dievaluasi") {
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['ProsesDievaluasi'], 'userId');
		} elseif ($evaluasi == "siap-dievaluasi") {
			$evkinUsers	= Arr::pluck($evaluationValue[$district][$jobId]['SiapDievaluasi'], 'userId');
		}
		$users = User::find($evkinUsers);

		return view('personnelEvaluation.evaluation.index', compact(['users', 'evaluasi', 'evaluators', 'lastSetting']));
	}

	public function monitoring()
	{
		$id 			= Auth::user()->id;
		$lastYear 		= personnel_evaluation_setting::max('year');
		$lastQuarter 	= personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
		$evaluators 	= personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$settings 		= personnel_evaluation_setting::where('year', $lastYear)->where('quarter', $lastQuarter)
			->join('job_titles', 'job_titles.id', '=', 'personnel_evaluation_settings.jobTitleId')->orderBy('job_titles.sort')
			->select('personnel_evaluation_settings.*', 'job_titles.sort')->get();
		return view('personnelEvaluation.monitoring', compact(['id', 'lastYear', 'lastQuarter', 'evaluators', 'settings']));
	}

	//======================================================= monitoring ==========================================================================================	

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

		if (isset($request->variabel)) {
			$data[$request->criteria][$request->aspect]['variabel'] 			= $request->variabel;
		}
		if (isset($request->capaian)) {
			$data[$request->criteria][$request->aspect]['capaian'] 				= $request->capaian;
		}
		if (isset($request->evidences)) {
			$data[$request->criteria][$request->aspect]['evidences'] 			= $request->evidences;
		}
		if (isset($request->assesment)) {
			$data[$request->criteria][$request->aspect]['assesment'] 			= $request->assesment;
		}
		if (isset($request->score_by_evaluator)) {
			$data[$request->criteria][$request->aspect]['score_by_evaluator']	= $request->score_by_evaluator;
		}

		if (isset($request->totalScore)) {
			personnel_evaluation_value::where('id', $request->value)->update([
				'totalScore'		=> $request->totalScore
			]);
		}

		if (isset($request->kinerja)) {
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

	//=============================================================================================================================================================	

	public function userCreate(Request $request)
	{
		$data = unserialize(personnel_evaluation_value::where('id', $request->value)->pluck('content')->first());

		if (isset($request->variabel)) {
			$data[$request->criteria][$request->aspect]['variabel'] 	= $request->variabel;
		}
		if (isset($request->capaian)) {
			$data[$request->criteria][$request->aspect]['capaian'] 		= $request->capaian;
		}
		if (isset($request->evidences)) {
			$data[$request->criteria][$request->aspect]['evidences'] 	= $request->evidences;
		}
		if (isset($request->score)) {
			$data[$request->criteria][$request->aspect]['score'] 		= $request->score;
		}

		if (isset($request->totalScores)) {
			personnel_evaluation_value::where('id', $request->value)->update([
				'userTotalScore'		=> $request->totalScores
			]);
		}

		if (isset($request->kinerja)) {
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
		$value 		= personnel_evaluation_value::where('settingId', $settingId)->where('userId', $userId)->get();
		$setting	= personnel_evaluation_setting::find($settingId);
		$time		= Carbon::parse($setting->year . '-' . $setting->quarter * 3);

		if ($value->count() == 0) {
			personnel_evaluation_value::create([
				'settingId'	=> $settingId,
				'userId'	=> $userId
			]);
		};

		$value 		= personnel_evaluation_value::where('settingId', $settingId)->where('userId', $userId)->get();
		$job_desc 	= job_desc::withoutGlobalScopes()->where('user_id', $value[0]->user->id)->where('starting_date', '<', $time)->where('finishing_date', '>', $time)->get();

		return view('personnelEvaluation.evaluation.input', compact(['value', 'job_desc']));
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


		$files = personnel_evaluation_upload::where('personnel_evaluation_value_id', $value->first()->id)->get();

		if (!empty($value[0]->content)) {
			$content	= unserialize($value[0]->content);
		} else {
			$content = "";
		}

		return view('personnelEvaluation.evaluation.create', compact(['files', 'aspects', 'criterias', 'criteriIds', 'setting', 'user', 'value', 'content', 'evaluators']));
	}


	public function download($settingId, $userId)
	{
		$myZones		= array(explode(", ", Auth::user()->areaKerja()->pluck('zone')->first()));
		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$value = personnel_evaluation_value::where('settingId', $settingId)->where('userId', $userId)->get();
		$thisPersonnelEvaluatorsKorkot = $value->first()->evaluator;


		$thisPersonnelEvaluators = job_desc::whereIn(
			'job_title_id',
			personnel_evaluator::where('jobId', job_desc::where('user_id', $userId)->pluck('job_title_id')->first())->pluck('evaluator')
		)->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')->whereIn('district', $myZones)
			->get();


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


		if (!empty($value[0]->content)) {
			$content	= unserialize($value[0]->content);
		} else {
			$content = "";
		}


		return view('personnelEvaluation.evaluation.download', compact(['aspects', 'criterias', 'criteriIds', 'setting', 'user', 'value', 'content', 'evaluators', 'thisPersonnelEvaluators', 'thisPersonnelEvaluatorsKorkot']));
		$pdf = PDF::loadView('personnelEvaluation.evaluation.download', compact(['aspects', 'criterias', 'criteriIds', 'setting', 'user', 'value', 'content']));
		return $pdf->setPaper('a4', 'portrait')->download('Evkinja.pdf');
	}


	public function rekap()
	{
		$myZones	= explode(", ", job_desc::where('user_id', Auth::user()->id)->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
			->pluck('zone')->first());

		$evaluators = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$evaluations = personnel_evaluation_value::get();

		$users		= personnel_evaluation_value::join('users', 'users.id', '=', 'personnel_evaluation_values.userId')
			->join('personnel_evaluation_settings', 'personnel_evaluation_settings.id', '=', 'personnel_evaluation_values.settingId')
			->join('job_descs', 'job_descs.user_id', '=', 'users.id')->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
			->select('users.id', 'settingId', 'userId', 'totalScore', 'userTotalScore', 'ok_by_user', 'edit_by_user', 'ready', 'edit', 'name', 'district', 'jobTitleId')->whereIn('district', $myZones)
			->paginate(20);

		$jobDescs	= job_desc::join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
			->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
			->leftjoin('allvillages', 'allvillages.KD_KAB', '=', 'work_zones.district')
			->get();

		return view('personnelEvaluation.evaluation.rekap', compact(['users', 'jobDescs', 'evaluations', 'evaluators', 'myZones']));
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
			'ok_by_user' => 1
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


		if (Auth::user()->hasAnyRoles(['hrm'])) {
			$personnels = personnel_evaluation_value::where('edit_by_user', 1)->get();
		} else {
			foreach ($evaluators as $evaluator) {
				$myEvaluationUsers[$evaluator] = job_title::find($evaluator)->user;
			}
			$myEvaluationUserIds = Arr::pluck(Arr::collapse($myEvaluationUsers), 'id');
			$myWorkZones = work_zone::whereIn('district', $myZone)->get();

			foreach ($myWorkZones as $myWorkZone) {
				$myWorkZonesUsers[$myWorkZone->id] = $myWorkZone->user;
			}
			$myWorkZonesUsersIds = Arr::pluck(Arr::collapse($myWorkZonesUsers), 'id');
			$usersId = array_intersect($myWorkZonesUsersIds, $myEvaluationUserIds);

			$personnels = personnel_evaluation_value::whereIn('userId', $usersId)->where('edit_by_user', 1)->get();
		}

		return view('personnelEvaluation.edit', compact(['personnels', 'evaluators', 'myJobId', 'myZone']));
	}


	public function editGrant($valueId)
	{
		personnel_evaluation_value::where('id', $valueId)->update([
			'edit' 	=> 0,
			'ready' => 0
		]);

		return redirect('personnel-evaluation-monitoring');
	}

	public function editDenied($valueId)
	{
		personnel_evaluation_value::where('id', $valueId)->update([
			'edit' 	=> 2
		]);

		return redirect('personnel-evaluation-monitoring');
	}

	// ============================================================= editDenied =============================================================================	

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

	// =================================================================== userEditGrant ===========================================================================

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
		$lastYear 					= personnel_evaluation_setting::max('year');
		$lastQuarter 				= personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
		$lastSetting 				= personnel_evaluation_setting::where('year', $lastYear)->where('quarter', $lastQuarter)->get();
		
		
		
		
		$current_job_descs = $this->job_desc();
		$myTitleId		= job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first();
		$myEvaluations 	= personnel_evaluation_value::where('userId', Auth::user()->id)->get();
		$settings		= personnel_evaluation_setting::where('jobTitleId', $myTitleId)->get();
		$evaluators		= personnel_evaluator::where('evaluator', $myTitleId)->get();
		
		$my_job_desc = $current_job_descs->where('user_id', auth()->user()->id );

		return view('personnelEvaluation.evaluation.myEvaluation', 
		compact(['settings', 'evaluators', 'myEvaluations', 
		'current_job_descs', 'my_job_desc', 'lastSetting']));
	}

	// =============================================================

	public function extendedMonitoring($evaluasi, $jobId)
	{
		$id 					= Auth::user()->id;
		$lastYear 		= personnel_evaluation_setting::max('year');
		$lastQuarter 	= personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
		$evaluators 	= personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();
		$lastSetting 	= personnel_evaluation_setting::where('year', $lastYear)->where('quarter', $lastQuarter)->where('jobTitleId', $jobId)->get();

		if ($evaluasi == 'jumlah-personil') {
			$users = User::find($lastSetting->first()->jobDesc()->pluck('user_id'));
		} elseif ($evaluasi == 'belum-input') {
			$users = User::find($lastSetting->first()->jobDesc()->whereNotIn('user_id', $lastSetting->first()->evaluationValue()->pluck('userId'))->pluck('user_id'));
		} elseif ($evaluasi == 'proses-input') {
			$users = User::find($lastSetting->first()->evaluationValue()->where('ok_by_user', 0)->pluck('userId'));
		} elseif ($evaluasi == 'selesai-input') {
			$users = User::find($lastSetting->first()->evaluationValue()->where('ok_by_user', 1)->pluck('userId'));
		} elseif ($evaluasi == 'siap-dievaluasi') {
			$users = User::find($lastSetting->first()->evaluationValue()->where('ok_by_user', 1)->where('totalScore', '==', '0.00')->pluck('userId'));
		} elseif ($evaluasi == 'proses-evaluasi') {
			$users = User::find($lastSetting->first()->evaluationValue()->where('ok_by_user', 1)->where('totalScore', '!=', '0.00')->where('ready', 0)->pluck('userId'));
		} elseif ($evaluasi == 'selesai-evaluasi') {
			$users = User::find($lastSetting->first()->evaluationValue()->where('ready', 1)->pluck('userId'));
		} elseif ($evaluasi == 'edit') {
			$users = User::find($lastSetting->first()->evaluationValue()->where('edit', 1)->get()->pluck('userId'));
		} elseif ($evaluasi == 'tolak') {
			$users = User::find($lastSetting->first()->evaluationValue()->where('edit', 2)->get()->pluck('userId'));
		}

		return view('personnelEvaluation.evaluation.index', compact(['evaluators', 'evaluasi', 'lastSetting', 'users']));
	}
	//========================================================================== extendedMonitoring ===============================================================



}
