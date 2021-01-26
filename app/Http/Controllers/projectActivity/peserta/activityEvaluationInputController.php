<?php

namespace App\Http\Controllers\projectActivity\peserta;

use App\activity;
use App\evaluation;
use App\evaluation_question;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class activityEvaluationInputController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityParticipantMiddleware']);
    }


    public function show($id)
    {
        $activity = activity::find($id);
        return view('activities.participants.evaluation.pelatihan.show', compact(['activity', 'id']));
    }

    public function store(request $request)
    {
        // return $request;
        $questions = activity::find($request->activity_id)->quiz->where('for_all_subjects', 1)->count();

        for ($i = 1; $i <= $questions; $i++) {
            $answer                 = "answer" . $i;
            $question               = "question" . $i;
            $question_id            = $request->$question;
            $answer_id              = $request->$answer;

            evaluation::create([
                'user_id'           => Auth::user()->id,
                'activity_id'       => $request->activity_id,
                'subject_id'        => 0,
                'question_id'       => $question_id,
                'answer_id'         => $answer_id
            ]);
        }

        return redirect('/kegiatan/peserta/evaluasi/' . $request->activity_id);
    }
}
