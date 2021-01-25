<?php

namespace App\Http\Controllers\projectActivity\peserta;

use App\activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\subject;

class evaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityParticipantMiddleware']);
    }

    public function show($id)
    {
        $activity   = activity::find($id);
        $uncompletedEvaluation = subject::where('subjects.activity_id', $id)->where('evaluation_sheet', 1)->get();
        return view('activities.participants.evaluation.show', compact(['id', 'activity', 'uncompletedEvaluation']));
    }
}
