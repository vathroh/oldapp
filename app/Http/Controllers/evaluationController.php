<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\activity_participant;
use Illuminate\Http\Request;
use App\evaluation_question;
use App\evaluation_answer;
use App\evaluation;
use App\activity;
use App\subject;

class evaluationController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($activity_id, $subject_id)
    {
		$role =activity_participant::where('user_id', Auth::user()->id)->pluck('role')->first();
		$activity = $activity_id;
		$activity_item = activity::where('id', $activity_id)->pluck('category_id')->first();
		
		$activities = activity::get();
		$subject = subject::where('subjects.id', $subject_id)->where('evaluation_sheet', 1)
			->join('activities', 'subjects.activity_id', '=', 'activities.id')
			->select("*", "subjects.id")->first();
		
		$questions = evaluation_question::where('activity_id', $activity_id)->where('for_all_subjects', 1)->get();
		$answers = evaluation_answer::all();
		return view('activities.evaluations.index', compact(['questions', 'answers', 'subject', 'role', 'activities', 'activity', 'activity_id', 'activity_item']));
	}
	
	
	public function activityEvaluation($activity_id)
    {
		$activities = activity::get();
		$answers = evaluation_answer::all();
		$role =activity_participant::where('user_id', Auth::user()->id)->pluck('role')->first();
		$activity_item = activity::where('id', $activity_id)->pluck('category_id')->first();
		$questions = evaluation_question::where('activity_id', $activity_id)->where('for_all_subjects', 0)->get();
		
		return view('activities.evaluations.activity-evaluation', compact(['questions', 'answers', 'role', 'activities', 'activity_id', 'activity_item']));
	}
	
	
	public function store(Request $request, $activity_id, $subject_id)
	{
		$activity_category = activity::where('id', $activity_id)->pluck('category_id')[0];
		$questions = evaluation_question::where('activity_id', $activity_id)->where('for_all_subjects', 1)->count();	
		
		if(evaluation::where('subject_id', $subject_id)->count() > 0)
		{
			return redirect('activity/' . $activity_category . '/' .  $activity_id);
		}			
		
		for($i=1; $i<= $questions; $i++)
		{
			$quest 			= "question" . $i;
			$question 		= $request->$quest;
			$question_id 	= evaluation_question::where('question', $question)->pluck('id')->first();			
			$answ 			= "answer" . $i;
			$answer_id 		= $request->$answ;
			
			evaluation::create([
					'user_id' 		=>	Auth::user()->id,
					'activity_id' 	=>	$activity_id,
					'subject_id'	=>	$subject_id,
					'question_id'	=> 	$question_id,
					'answer_id'		=>	$answer_id
			]);
			
		}
		
		return redirect('activity/' . $activity_category . '/' .  $activity_id);

	}
	
	
	
	public function evaluationActivityStore(Request $request, $activity_id)
	{
		
		$activity_category = activity::where('id', $activity_id)->pluck('category_id')[0];
		$questions = evaluation_question::where('activity_id', $activity_id)->where('for_all_subjects', 0)->count();	
				
		
		for($i=1; $i<= $questions; $i++)
		{
			$quest 			= "question" . $i;
			$question 		= $request->$quest;
			$question_id 	= evaluation_question::where('activity_id', $activity_id)->pluck('id')->first();			
			$answ 			= "answer" . $i;
			$answer_id 		= $request->$answ;
			
			evaluation::create([
					'user_id' 		=>	Auth::user()->id,
					'activity_id' 	=>	$activity_id,
					'subject_id'	=>	0,
					'question_id'	=> 	$question_id,
					'answer_id'		=>	$answer_id
			]);
			
		}
		
		return redirect('activity/' . $activity_category . '/' .  $activity_id);

	}
}
