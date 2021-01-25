<?php

namespace App\Http\Controllers\projectActivity\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\activity;

class scheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityOrganizerMiddleware']);
    }

    public function show($id)
    {
        $activity = activity::findOrFail($id);
        return view('activities.organizer.schedule.show', compact(['activity', 'id']));
    }
}
