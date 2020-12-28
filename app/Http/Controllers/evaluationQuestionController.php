<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\evaluation_question;
use App\activity;

class evaluationQuestionController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function index()
    {
        $questions = evaluation_question::join('activities', 'activities.id', '=', 'evaluation_questions.activity_id')
			->select("*", "evaluation_questions.id")->get();
        return view('activities.evaluations.questions.index', compact('questions'));  
    }
    
    
    public function create() 
    {
		$activities = activity::all();
        return view('activities.evaluations.questions.create', compact('activities'));
    }
    
    
    public function store(Request $request)
    {
        evaluation_question::create([
			'activity_id' => $request->activity,
			'for_all_subjects' => $request->for_all_subjects,
			'question' => $request->question
			]);
        return redirect ('evaluation-questions');
	}


	public function edit($id)
    {
        if (Auth::user()->hasAnyRoles(['admin', 'osp']))
        {
			$activities = activity::all();
			$question = evaluation_question::where('evaluation_questions.id', $id)
				->join('activities', 'activities.id', '=', 'evaluation_questions.activity_id')
				->select("*", "evaluation_questions.id")->first();
            return view('activities.evaluations.questions.edit', compact(['activities', 'question']));                            
        }
        
        return redirect('evaluation-questions');
    }
    
    public function update(Request $request, $id)
    {
        evaluation_question::where('id', $id)->update([
			'activity_id' => $request->activity,
			'for_all_subjects' => $request->for_all_subjects,
			'question' => $request->question
		]);
        
        return redirect ('evaluation-questions');                
    }


    public function destroy($id)
    {
        if (Auth::user()->hasAnyRoles(['admin', 'osp']))
        {
            evaluation_question::where('id', $id)->delete();                                         
        }
        
        return redirect('evaluation-questions');                        
    }
}
