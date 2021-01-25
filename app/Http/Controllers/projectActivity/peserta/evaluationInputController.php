<?php

namespace App\Http\Controllers\projectActivity\peserta;

use App\subject;
use App\activity;
use App\evaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class evaluationInputController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityParticipantMiddleware']);
    }


    public function show($activity, $id)
    {
        $subject = subject::find($id);
        $activity = $subject->activity;
        return view('activities.participants.evaluation.materi.show', compact(['subject', 'activity', 'id']));
    }

    public function store(Request $request)
    {
        $questions = activity::find($request->activity_id)->quiz->where('for_all_subjects', 1)->count();

        for ($i = 1; $i <= $questions; $i++) {
            $answer                 = "answer" . $i;
            $question               = "question" . $i;
            $question_id            = $request->$question;
            $answer_id              = $request->$answer;

            evaluation::create([
                'user_id'           => Auth::user()->id,
                'activity_id'       => $request->activity_id,
                'subject_id'        => $request->subject_id,
                'question_id'       => $question_id,
                'answer_id'         => $answer_id
            ]);
        }

        return redirect('/kegiatan/peserta/evaluasi/' . $request->activity_id);
    }
}
