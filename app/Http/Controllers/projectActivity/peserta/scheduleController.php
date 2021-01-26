<?php

namespace App\Http\Controllers\projectActivity\peserta;

use App\activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class scheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityParticipantMiddleware']);
    }

    public function show($id)
    {
        $activity = activity::findOrFail($id);
        return view('activities.participants.schedule.show', compact(['activity', 'id']));
    }
}
