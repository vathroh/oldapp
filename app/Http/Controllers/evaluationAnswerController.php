<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\evaluation_question;
use App\evaluation_answer;
use App\activity;


class evaluationAnswerController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $answers = evaluation_answer::join('evaluation_questions', 'evaluation_questions.id', '=', 'evaluation_answers.evaluation_question_id')
			->select("*", "evaluation_answers.id")->get();
        return view('activities.evaluations.answers.index', compact('answers'));  
    }
    
    
    public function create() 
    {
		$activities = activity::all();
        return view('activities.evaluations.answers.create', compact('activities'));
    }
    
    
    public function store(Request $request)
    {
        evaluation_answer::create([
			'evaluation_question_id' => $request->question,
			'answer' => $request->answer,
			'scale' => $request->scale,
			'true_or_false' => $request->true_or_false
			]);
        return redirect ('evaluation-answers');
	}


	public function edit($id)
    {
        if (Auth::user()->hasAnyRoles(['admin', 'osp']))
        {
			$activities = activity::all();
			
			$questions = evaluation_question::all();

			$answer = evaluation_answer::where('evaluation_answers.id', $id)
				->join('evaluation_questions', 'evaluation_questions.id', '=', 'evaluation_answers.evaluation_question_id')
				->join('activities', 'evaluation_questions.activity_id', '=', 'activities.id')
				->select("*", "evaluation_answers.id")->first();
			
            return view('activities.evaluations.answers.edit', compact(['activities', 'answer', 'questions']));                            
        }
        
        return redirect('evaluation-answers');
    }
    
    public function update(Request $request, $id)
    {
        evaluation_answer::where('id', $id)->update([
			'evaluation_question_id' => $request->question,
			'answer' => $request->answer,
			'scale' => $request->scale,
			'true_or_false' => $request->true_or_false
		]);
        
        return redirect ('evaluation-answers');                
    }


    public function destroy($id)
    {
        if (Auth::user()->hasAnyRoles(['admin', 'osp']))
        {
            evaluation_answer::where('id', $id)->delete();                                         
        }
        
        return redirect('evaluation-answers');                        
    }
    
    
    public function dropdown(Request $request)
    {
		$activity_id = $request->get('question_id');
        $questions = evaluation_question::where('activity_id',  $activity_id)->get(['id', 'question']);
        return response()->json($questions);   
	}
		
}
