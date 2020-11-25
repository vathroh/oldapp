<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use App\activity_participant;
use App\evaluation_question;
use Illuminate\Http\Request;
use App\activities_category;
use App\activity_blacklist;
use App\attendance_record;
use App\evaluation_answer;
use App\evaluation;
use Carbon\Carbon;
use App\allvillage;
use App\activity;
use App\subject;
Use App\library;
use App\User;
use PDF;

class activityController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
	public function index()
    {
        $activities = activity::join('activities_categories', 'activities.category_id', '=', 'activities_categories.id')
			->select("*", "activities.id", "activities.name as activity_name")->get();
        return view('activities.index', compact('activities'));  
    }
    
    
    public function create() 
    {
		$categories = activities_category::all();
        return view('activities.create', compact('categories'));
    }
    
    
    public function store(Request $request)
    {
        activity::create([
			'category_id' => $request->category,
			'name' => $request->name,
			'start_date' => $request->start_date,
			'finish_date' => $request->finish_date
			]);
        return redirect ('/activity');
	}


	public function edit($id)
    {
        if (Auth::user()->hasAnyRoles(['admin', 'osp']))
        {
			$categories = activities_category::all();
			$activity = activity::where('activities.id', $id)->join('activities_categories', 'activities.category_id', '=', 'activities_categories.id')
			->select("*", "activities.id", "activities.name as activity_name")->first();
            return view('activities.edit', compact(['activity', 'categories']));                            
        }
        
        return redirect('/activity');
    }
    
    public function update(Request $request, $id)
    {
        activity::where('id', $id)->update([
			'category_id' 	=> $request->category,
			'name' 			=> $request->name,
			'start_date' 	=> $request->start_date,
			'finish_date' 	=> $request->finish_date
		]);
        
        return redirect ('/activity');                
    }


    public function destroy($id)
    {
        if (Auth::user()->hasAnyRoles(['admin', 'osp']))
        {
            activity::where('id', $id)->delete();                                         
        }
        
        return redirect('/activity');                        
    }
    
    
    public function activities()
    {
		$activity_categories = activities_category::all();
		
		if (Auth::user()->hasAnyRoles(['admin']))
        {
            $activities = activity::select('activities.id', 'name', 'category_id', 'start_date', 'finish_date')->get();
        } else {
			$activities = activity::distinct('activities.id')->join('activity_participants', 'activities.id', '=', 'activity_participants.activity_id')
						  ->select('activities.id', 'name', 'category_id', 'start_date', 'finish_date')->get();
		}
		return view('activities.activity', compact(['activity_categories', 'activities']));
	}
	
	public function activity($activity)
    {
		$activities = activity::where('category_id', $activity)->get();		
		return view('activities.activity-item', compact('activities'));
	}
	
	public function activity_item($activity, $activity_item)
    {
		$role =activity_participant::where('user_id', Auth::user()->id)->pluck('role')->first();
		$activity_categories = activities_category::all();
		$activities = activity::all();
		$subject_id = evaluation::where('activity_id', $activity_item)->where('user_id', Auth::user()->id)->distinct()->pluck('subject_id');		
		
		$isSubjects = subject::where('activity_id', $activity_item)->where('evaluation_sheet', 1)
			->whereIn('id', $subject_id)->get();
		$noSubjects = subject::where('activity_id', $activity_item)->where('evaluation_sheet', 1)
			->whereNotIn('id', $subject_id)->get();
			
		$activityQuestion = evaluation::where('activity_id', $activity_item)->where('user_id', Auth::user()->id)->distinct()->where('subject_id', 0)->count();
		
		$isActivityQuestions = evaluation_question::where('activity_id', $activity_item)->where('for_all_subjects', 0)->get();
		
		return view('activities.activity-item-sheet', compact(['activityQuestion', 'role', 'isActivityQuestions', 'isSubjects', 'noSubjects', 'activity_item', 'activity', 'activities', 'activity_categories']));
	}
	
	
	public function schedule($activity, $activity_item)
    {
		$role =activity_participant::where('user_id', Auth::user()->id)->pluck('role')->first();
		$users = User::all();
		$activities = activity::get();
		 
		if($subjects = subject::where('activity_id', $activity_item)->join('activities', 'subjects.activity_id', '=', 'activities.id')->exists()){
			$subjects = subject::where('activity_id', $activity_item)->join('activities', 'subjects.activity_id', '=', 'activities.id')->get();
		} else {
			$subjects ="";
		}
		$start = activity::where('id', $activity_item)->pluck('start_date')->first();
		$finish = activity::where('id', $activity_item)->pluck('finish_date')->first();
		$period =  Carbon::parse($start)->diffInDays($finish)+1;
		
		return view('activities.schedule', compact(['role', 'subjects', 'users', 'activity', 'activity_item', 'period', 'activities']));
	}
	
	
	public function lesson($activity, $activity_item)
    {
		$role =activity_participant::where('user_id', Auth::user()->id)->pluck('role')->first();
		$activities = activity::get();
		
		$subjects = subject::where('activity_id', $activity_item)->whereNotNull('library_id')
			->join('activities', 'subjects.activity_id', '=', 'activities.id')->join('libraries', 'libraries.id', '=', 'subjects.library_id')->orderBy('start_time')->get();

		return view('activities.lesson', compact(['role', 'subjects', 'activity', 'activity_item', 'activities']));
	}
	
	
	public function attendance($activity, $activity_item)
    {
		$start = activity::where('id', $activity_item)->pluck('start_date')->first();
		$finish = activity::where('id', $activity_item)->pluck('finish_date')->first();
		$period =  Carbon::parse($start)->diffInDays($finish)+1;		
		
		if(Carbon::now()->lessThan(Carbon::parse($start)) == false and Carbon::now()->lessThan(Carbon::parse($finish)->addDays(1)))
		{
			$activity_day = true;
		} else {
			$activity_day = false;
		}
		
		$role =activity_participant::where('user_id', Auth::user()->id)->pluck('role')->first();
		$activities = activity::get();
		
		$hadir = attendance_record::whereDate('created_at', '=', Carbon::today()->toDateString())
			->where('user_id', Auth::user()->id )->where('activity_id', $activity_item)->count();
		
		$attendance_records = attendance_record::where('user_id', Auth::user()->id )->where('activity_id', $activity_item)->get();

		return view('activities.attendance', compact(['role', 'attendance_records', 'activity', 'activity_item', 'hadir', 'activities', 'activity_day']));
	}
	
	
	public function records_attendance($activity, $activity_item)
    {			
		$hadir = attendance_record::whereDate('created_at', '=', Carbon::today()->toDateString())
			->where('user_id', Auth::user()->id )->count();
		$attendance_records = attendance_record::where('user_id', Auth::user()->id )->get();
		
		attendance_record::create([
			'user_id'		=> Auth::user()->id,
			'activity_id' 	=> $activity_item
		]);

		return redirect ('/attendance/' . $activity .'/' . $activity_item);
	}
	
	
	public function certificate_page($activity, $activity_item)
    {
		
		$start = activity::where('id', $activity)->pluck('start_date')->first();
		$finish = activity::where('id', $activity)->pluck('finish_date')->first();
		$period =  Carbon::parse($start)->diffInDays($finish)+1;
		$blacklists = activity_blacklist::all();
		
		$role =activity_participant::where('user_id', Auth::user()->id)->where('activity_id', $activity_item)->pluck('role')->first();
		$activities = activity::get();
		
		$attendances = activity_participant::join('users', 'activity_participants.user_id', '=', 'users.id')->join('attendance_records', 'attendance_records.user_id', '=', 'users.id')->where('attendance_records.activity_id', $activity_item)->where('role', 'PESERTA')->selectRaw('Date(attendance_records.created_at) as tanggal, users.name, users.id')->get();
		
		$jml_hadir =attendance_record::where('user_id', Auth::user()->id)->where('activity_id', $activity_item)->count();
		
		$subjects = subject::all();
		$evaluations = evaluation::join('users', 'users.id', '=', 'evaluations.user_id')->where('activity_id', $activity_item)->get();
		
		return view('activities.certificate-page', compact(['role', 'period', 'start', 'activity', 'activity_item', 'activities', 'jml_hadir', 'attendances', 'subjects', 'evaluations', 'blacklists']));
	}
	
	
	public function certificate($activity_item)
    {	
		$role =activity_participant::where('user_id', Auth::user()->id)->where('activity_id', $activity_item)->pluck('role')->first();
		$username =User::where('id', Auth::user()->id)->pluck('sertificate')->first();
		$name = [$username];
		
		//return view('activities.certificate', compact(['username']));

		
		$pdf = PDF::loadView('activities.certificate', compact(['username', 'role']));
		return $pdf->setPaper('a4', 'landscape')->download('certificate.pdf');
	}
	
	
	public function monitoring($activity, $activity_item)
	{
		$activities = activity::get();
		$start = activity::where('id', $activity_item)->pluck('start_date')->first();
		$finish = activity::where('id', $activity_item)->pluck('finish_date')->first();
		$role =activity_participant::where('user_id', Auth::user()->id)->get();		
		$period =  Carbon::parse($start)->diffInDays($finish)+1;
/*			
		$attendances = attendance_record::join('users', 'attendance_records.user_id', '=', 'users.id')->join('activity_participants', function($join){
			$join->on('activity_participants.user_id', '=', 'attendance_records.user_id')
					->on('activity_participants.activity_id', '=', 'attendance_records.activity_id');
				})->where('attendance_records.activity_id', $activity_item)->where('role', 'PESERTA')->selectRaw('Date(attendance_records.created_at) as tanggal, users.name, users.id')->get();
 	
		
    $attendances    = activity_participant::distinct()->join('users', 'activity_participants.user_id', '=', 'users.id')
                      ->join('attendance_records', 'attendance_records.user_id', '=', 'users.id')->where('attendance_records.activity_id', $activity_item)
                      ->selectRaw('Date(attendance_records.created_at) as tanggal, users.name, role, users.id')->get();
*/
//    return activity_participant::where('role', 'PESERTA')->get();

    $attendances   = attendance_record::where('activity_id', $activity_item)->selectRaw('Date(created_at) as tanggal, user_id ')->get();
		
    $noAttendances = activity_participant::whereNotIn('user_id', $attendances->pluck('user_id'))->where('activity_id', $activity_item)->get();






		//$noAttendances = activity_participant::join('users', 'activity_participants.user_id', '=', 'users.id')->leftjoin('attendance_records', 'attendance_records.user_id', '=', 'users.id')->where('activity_participants.activity_id', $activity_item)->where('role', 'PESERTA')->selectRaw('users.id, name, Date(attendance_records.created_at) as tanggal, role')->get();
		$subjects = subject::all();
		$evaluations = evaluation::join('users', 'users.id', '=', 'evaluations.user_id')->where('activity_id', $activity_item)->get();
		$participants = activity_participant::join('users', 'users.id', '=', 'activity_participants.user_id')->where('activity_id', $activity_item)->get();
		
		return view('activities.monitoring', compact(['period', 'start', 'subjects', 'evaluations', 'participants', 'attendances', 'noAttendances', 'role', 'activity','activities', 'activity_item']));
	}
	
	
	
	public function participants($activity, $activity_item)
	{
		$activities = activity::get();
    $role =activity_participant::distinct()->where('user_id', Auth::user()->id)->get();
		
//	 	$participants = User::distinct('users.id')->join('activity_participants', 'activity_participants.user_id', '=', 'users.id')->join('job_descs', 'users.id', '=', 'job_descs.user_id')->join('job_titles', 'job_descs.job_title_id', '=', 'job_titles.id')->join('work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id')->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')->where('activity_id', $activity_item)->where('role', 'PESERTA')->get(['users.id', 'name', 'job_title', 'NAMA_KAB']);

    $participants = activity_participant::where('activity_id', $activity_item)->get();

		$pemandu_pemandu = User::distinct('users.id')->join('activity_participants', 'activity_participants.user_id', '=', 'users.id')->join('job_descs', 'users.id', '=', 'job_descs.user_id')->join('job_titles', 'job_descs.job_title_id', '=', 'job_titles.id')->join('work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id')->join('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')->where('activity_id', $activity_item)->where('role', 'PEMANDU')->get(['users.id', 'name', 'job_title', 'NAMA_KAB']);
		
		$panitia_panitia = User::distinct('users.id')->join('activity_participants', 'activity_participants.user_id', '=', 'users.id')->join('job_descs', 'users.id', '=', 'job_descs.user_id')->join('job_titles', 'job_descs.job_title_id', '=', 'job_titles.id')->join('work_zones', 'job_descs.work_zone_id', '=', 'work_zones.id')->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')->where('activity_id', $activity_item)->where('role', 'PANITIA')->get(['users.id', 'name', 'job_title', 'NAMA_KAB']);
		
		return view('activities.participants', compact(['role', 'participants', 'pemandu_pemandu', 'panitia_panitia', 'activity','activities', 'activity_item']));
	}
	
	public function evaluation_check($activity, $activity_item)
	{
		$activities = activity::get();
		$role =activity_participant::where('user_id', Auth::user()->id)->get();	
		
		$evaluations = evaluation::where('evaluations.activity_id', $activity_item)->join('subjects', 'subjects.id', '=', 'evaluations.subject_id')->join('users', 'users.id', '=', 'evaluations.user_id')->get();
		
		$participants = activity_participant::join('users', 'users.id', '=', 'activity_participants.user_id')->where('role', 'PESERTA')->get();
		
		return view('activities.evaluation-check', compact(['role', 'participants', 'evaluations', 'activity','activities', 'activity_item']));
	}
	
	public function evaluation_result($activity, $activity_item)
	{
		$activities = activity::get();
		$role =activity_participant::where('user_id', Auth::user()->id)->get();	
		
		$subjects = subject::where('activity_id', $activity_item)->where('evaluation_sheet', 1)->get();
		
		$questions = evaluation_question::where('activity_id', $activity_item)->where('for_all_subjects', 1)->get();
		$answers = evaluation_answer::get();
		
		
		$participants = activity_participant::distinct()->join('users', 'users.id', '=', 'activity_participants.user_id')->join('job_descs', 'job_descs.user_id', '=', 'users.id')->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')->join('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')->join('job_titles', 'job_descs.job_title_id', 'job_titles.id')->where('role', 'PESERTA')->get(['users.id', 'users.name', 'job_title', 'NAMA_KAB']);
		
		$evaluations = evaluation::join('evaluation_questions', 'evaluations.question_id', '=', 'evaluation_questions.id')->join('evaluation_answers', 'evaluations.answer_id', '=', 'evaluation_answers.id')->join('subjects', 'subjects.id', '=', 'evaluations.subject_id')->join('users', 'users.id', '=', 'evaluations.user_id')->where('evaluations.activity_id', $activity_item)->whereIN('user_id', $participants->pluck('id'))->get();
		
		$kabupaten = allvillage::all();
						
		return view('activities.evaluation-result', compact(['role', 'subjects', 'questions', 'answers', 'participants', 'evaluations', 'activity','activities', 'activity_item', 'kabupaten']));
	}
	
	public function ajaxEvaluationResult(Request $request)
	{
		
		$chart 	= array();
		$chart1 = array();		
		$chartx = array();
		$chartj = array();
		$chartk = array();		
		$chartl = array();	
		$scales = evaluation_answer::join('evaluation_questions', 'evaluation_questions.id', '=', 'evaluation_answers.evaluation_question_id')->where('for_all_subjects', 1)->get();
		$subjects = subject::where('evaluation_sheet', 1)->get();		
		$questions = evaluation_question::where('for_all_subjects', 1)->get();
		
		//$count = evaluation::join('evaluation_answers', 'evaluations.answer_id', '=', 'evaluation_answers.id')->where('question_id', $question->id )->where('scale', $scale->scale)->count();

		foreach($scales as $scale)
		{					
			$chart[] = [$scale->answer];
		}		
	
		$x=0;
		foreach($questions as $question)
		{			
			$i=0;
			foreach($scales->unique('scale') as $scale)
			{
				$count = evaluation::join('evaluation_answers', 'evaluations.answer_id', '=', 'evaluation_answers.id')->where('question_id', $question->id )->where('scale', $scale->scale)->count();
				$chartj[] = $count;
				
				$chartk = $chartj[$x*4 + $i];
				$charty = $chart[$x*4 + $i];
				$chartl[$i] = $chartk;
				$chartt[$i] = $charty;
				$i++;				
			}			
			$chartq[$x] = [ Arr::flatten(Arr::collapse($chartt)),  Arr::flatten($chartl) ];
			$x++;			
		}
		
		$count1 = count($chartq[0][0]);
		$count2 = count($chartq);
		
		$x=0;
		foreach($questions as $question)
		{
			for($i=0; $i<$count1; $i++)
			{
				$i1 = $chartq[$x][0][$i];
				$u1 = $chartq[$x][1][$i];
				$chart12[$i] = [$i1 => $u1];
			}
			
			$chart1[$x] = Arr::collapse([['question' => $question->question], Arr::collapse($chart12)]);
			$x++;
		}
		//$chart1 = $chartq;
		
		/*

				
		$chart1 = [
			[ 'id' => 'd1', 'region' =>  'USA', 	'value' => 20],
			[ 'id' => 'd2', 'region' =>  'India', 	'value' => 12],
			[ 'id' => 'd3', 'region' =>  'China', 	'value' => 11],
			[ 'id' => 'd4', 'region' =>  'Germany', 'value' => 6],
			[ 'id' => 'd4', 'region' =>  'Indonesia', 'value' => 17]
		];

		*/
			// evaluation::join('evaluation_answers', 'evaluations.answer_id', '=', 'evaluation_answers.id')->get('scale');
		
		return response()->json($chart1); 
		
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function listing_attendant($activity, $activity_item)
	{	
		$role =activity_participant::where('user_id', Auth::user()->id)->get();
		$activities = activity::get();	
		$districts = allvillage::distinct('KD_KAB')->get(['KD_KAB', 'NAMA_KAB']);
		return view('activities.attendant_listing', compact(['role', 'districts', 'activity_item', 'activity', 'activities']));
	}
	
	public function ajaxAttendance(Request $request)
	{
		$participatans 	= activity_participant::distinct()->where('activity_id', $request->activity_id)
						  ->where('role', $request->role)
						  ->join('users', 'users.id', '=', 'activity_participants.user_id')
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
						  ->get(['activity_participants.user_id', 'name', 'NAMA_KAB', 'KD_KAB', 'job_title']);
						  
		$users 			= User::distinct('users.id')->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')	
						  ->where('KD_KAB', $request->kode_kabupaten)				  	  
						  ->whereNotIn('users.id', $participatans->pluck('user_id'))
						  ->select('users.id as user_id', 'name', 'NAMA_KAB', 'KD_KAB', 'job_title')
                          ->get();
		
		$registered_user 	= activity_participant::distinct()
							->where('role', $request->role)
						  ->where('activity_id', $request->activity_id)
						  ->where('district', $request->kode_kabupaten )						
						  ->join('job_descs', 'job_descs.user_id', '=', 'activity_participants.user_id')
						  ->join('users', 'users.id', '=', 'activity_participants.user_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->join('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
							  ->select('users.id as user_id', 'name', 'NAMA_KAB', 'KD_KAB', 'job_title')
                          ->get();		
			
		return response()->json([$registered_user, $users]);   
	}
	
	public function ajaxAttendanceFindName(Request $request)
	{
/*
		$registered_user 	= activity_participant::where('activity_id', $request->kegiatanid)->where('role', $request->role)
							  ->pluck('activity_participants.user_id');
*/					
		
		$registered_user 	= activity_participant::distinct()							  
							  ->join('users', 'users.id', '=', 'activity_participants.user_id')
							  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
							  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
							  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
							  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
							  ->where('activity_id', $request->kegiatanid)
							  ->where('role', $request->role)
							  ->where('users.name', 'like', '%' . $request->nama . '%')	
							  ->orWhere('activity_id', $request->kegiatanid)
							  ->where('role', $request->role)		
							  ->where('job_titles.job_title', 'like', '%' . $request->nama . '%')							  
							  ->select('users.id as user_id', 'name', 'NAMA_KAB', 'job_title')
                              ->get();
			
		$users = User::distinct()->join('job_descs', 'job_descs.user_id', '=', 'users.id')
			->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
			->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
			->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')							
			->where('users.name', 'like', '%' . $request->nama . '%')
			->whereNotIn('user_id', $registered_user->pluck('user_id'))			
			->orWhere('job_titles.job_title', 'like', '%' . $request->nama . '%')
			->whereNotIn('user_id', $registered_user->pluck('user_id'))
								  ->select('users.id as user_id', 'name', 'NAMA_KAB', 'job_title')
                              ->get();
	
		return response()->json([$registered_user, $users]);   
	}
	
	
	public function ajaxRegister(Request $request)
	{
		for($i = 0; $i < $request->count; $i++){
			activity_participant::create([
				'activity_id'	=> $request->activity_id,
				'user_id' => $request->userId[$i],
				'role' 	=> $request->role
			]);
		}
		
		$participans 	= activity_participant::distinct()
						  ->where('activity_id', $request->activity_id)
						  ->where('role', $request->role)
						  ->join('users', 'users.id', '=', 'activity_participants.user_id')
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
						  ->get(['activity_participants.user_id', 'name', 'NAMA_KAB', 'job_title']);
						  
		
			
		$nonParticipans	= User::distinct('users.id')					  
						  ->whereNotIn('users.id', $participans->pluck('user_id'))
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')						  
						  ->get(['users.id as user_id', 'name', 'NAMA_KAB', 'KD_KAB', 'job_title']);
  
						  
		if($request->kode_kabupaten != "" )
		{
			$nonParticipans	= User::distinct('users.id')				  
						  ->where('KD_KAB', $request->kode_kabupaten)
						  ->whereNotIn('users.id', $participans->pluck('user_id'))
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')						  
						  ->get(['users.id as user_id', 'name', 'NAMA_KAB', 'KD_KAB', 'job_title']);
						  
			$participans 	= activity_participant::distinct()
							->where('KD_KAB', $request->kode_kabupaten)
						  ->where('activity_id', $request->activity_id)
						  ->where('role', $request->role)
						  ->join('users', 'users.id', '=', 'activity_participants.user_id')
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
						  ->get(['activity_participants.user_id', 'name', 'NAMA_KAB', 'job_title']);
		}
		
		if($request->nama != "" )
		{
			
			
			$participans 	= activity_participant::distinct()
							->where('users.name', 'like', '%' . $request->nama . '%')
							->where('activity_id', $request->activity_id)
							->where('role', $request->role)
							  ->orWhere('job_titles.job_title', 'like', '%' . $request->nama . '%')
							  ->where('activity_id', $request->activity_id)
							  ->where('role', $request->role)
							  ->join('users', 'users.id', '=', 'activity_participants.user_id')
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
						  ->get(['activity_participants.user_id', 'name', 'NAMA_KAB', 'job_title']);	
						  
			$nonParticipans	= User::distinct('users.id')				  
						  ->where('job_titles.job_title', 'like', '%' . $request->nama . '%')
						  ->whereNotIn('users.id', $participans->pluck('user_id'))
						  ->orWhere('users.name', 'like', '%' . $request->nama . '%')						  
						  ->whereNotIn('users.id', $participans->pluck('user_id'))
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')						  
						  ->get(['users.id as user_id', 'name', 'NAMA_KAB', 'KD_KAB', 'job_title']);		  
			
		}
			
		return response()->json([$participans, $nonParticipans]);
	}
	
	
	public function ready(Request $request)
	{
		$participatans 	= activity_participant::distinct()->where('activity_id', $request->activity_id)
						  ->where('role', $request->role)
						  ->join('users', 'users.id', '=', 'activity_participants.user_id')
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
						  ->get(['activity_participants.user_id', 'name', 'NAMA_KAB', 'job_title']);
						  
		$users 			= User::distinct('users.id')->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')					  	  
						  ->whereNotIn('users.id', $participatans->pluck('user_id'))
						  ->get(['user_id', 'name', 'NAMA_KAB', 'job_title']);
		
		return response()->json([$participatans, $users]);		
	}
	
	/*
	public function moveReg(Request $request)
	{
		
	
		$registered_user 	= activity_participant::where('activity_id', $request->kegiatanid)->where('role', $request->role)
							  ->pluck('activity_participants.user_id');
					
		if($request->nama != null)
		{
			$users = User::distinct()->join('job_descs', 'job_descs.user_id', '=', 'users.id')
			->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
			->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
			->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')							
			->where('users.name', 'like', '%' . $request->nama . '%')			
			->orWhere('job_titles.job_title', 'like', '%' . $request->nama . '%')
			->get(['user_id', 'name', 'NAMA_KAB', 'job_title']);
			
			$unregistered_users = $users->whereNotIn('user_id', $registered_user);
		}
		
		if($request->kode_kabupaten != "Cari berdasarkan kabupaten penugasan")
		{
			
			$unregistered_users = User::distinct()->join('job_descs', 'job_descs.user_id', '=', 'users.id')
				->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
				->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
				->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
				->whereNotIn('users.id', $registered_user)
				->Where('district', $request->kode_kabupaten )
				->get(['user_id', 'name', 'NAMA_KAB', 'job_title']);				
		}
			
		return response()->json($registered_user);
	}
	*/
	
	public function deleteAjax(Request $request)
	{
		for($i = 0; $i < $request->count; $i++){
			activity_participant::where('user_id', $request->regUserId[$i])->where('activity_id', $request->activity_id)->where('role', $request->role)->delete();
		}
	/*	
		$participans = activity_participant::distinct()
			->where('role', $request->role)
			->where('activity_id', $request->activity_id)
			->join('users', 'users.id', '=', 'activity_participants.user_id')
			->join('job_descs', 'job_descs.user_id', '=', 'users.id')
			->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
			->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
			->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
			->get(['activity_participants.user_id', 'name', 'NAMA_KAB', 'job_title']);
			
		$nonParticipans	= User::distinct('users.id')
						  ->whereNotIn('users.id', $participans->pluck('user_id'))
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
                          ->get(['users.id as user_id', 'name', 'NAMA_KAB', 'job_title']);
     */    
        $participans 	= activity_participant::distinct()
						  ->where('activity_id', $request->activity_id)
						  ->where('role', $request->role)
						  ->join('users', 'users.id', '=', 'activity_participants.user_id')
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
						  ->get(['activity_participants.user_id', 'name', 'NAMA_KAB', 'job_title']);
						  
		
			
		$nonParticipans	= User::distinct('users.id')					  
						  ->whereNotIn('users.id', $participans->pluck('user_id'))
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')						  
						  ->get(['users.id as user_id', 'name', 'NAMA_KAB', 'KD_KAB', 'job_title']);
  
						  
		if($request->kode_kabupaten != "" )
		{
			$nonParticipans	= User::distinct('users.id')				  
						  ->where('KD_KAB', $request->kode_kabupaten)
						  ->whereNotIn('users.id', $participans->pluck('user_id'))
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')						  
						  ->get(['users.id as user_id', 'name', 'NAMA_KAB', 'KD_KAB', 'job_title']);
						  
			$participans 	= activity_participant::distinct()
							->where('KD_KAB', $request->kode_kabupaten)
						  ->where('activity_id', $request->activity_id)
						  ->where('role', $request->role)
						  ->join('users', 'users.id', '=', 'activity_participants.user_id')
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
						  ->get(['activity_participants.user_id', 'name', 'NAMA_KAB', 'job_title']);
		}
		
		if($request->nama != "" )
		{
			
			
			$participans 	= activity_participant::distinct()
							->where('users.name', 'like', '%' . $request->nama . '%')
							->where('activity_id', $request->activity_id)
							->where('role', $request->role)
							  ->orWhere('job_titles.job_title', 'like', '%' . $request->nama . '%')
							  ->where('activity_id', $request->activity_id)
							  ->where('role', $request->role)
							  ->join('users', 'users.id', '=', 'activity_participants.user_id')
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')
						  ->get(['activity_participants.user_id', 'name', 'NAMA_KAB', 'job_title']);	
						  
			$nonParticipans	= User::distinct('users.id')				  
						  ->where('job_titles.job_title', 'like', '%' . $request->nama . '%')
						  ->whereNotIn('users.id', $participans->pluck('user_id'))
						  ->orWhere('users.name', 'like', '%' . $request->nama . '%')						  
						  ->whereNotIn('users.id', $participans->pluck('user_id'))
						  ->join('job_descs', 'job_descs.user_id', '=', 'users.id')
						  ->join('job_titles', 'job_titles.id', '=', 'job_descs.job_title_id')
						  ->join('work_zones', 'work_zones.id', '=', 'job_descs.work_zone_id')
						  ->leftjoin('allvillages', 'work_zones.district', '=', 'allvillages.KD_KAB')						  
						  ->get(['users.id as user_id', 'name', 'NAMA_KAB', 'KD_KAB', 'job_title']);		  
			
		}

			
		return response()->json([$participans, $nonParticipans]);
	}
	
	public function lesson_download($library_id)
    {				 
		$library = library::where('id', $library_id)->first();
		return view('lesson-viewer', compact(['library']));
	}
	
}
