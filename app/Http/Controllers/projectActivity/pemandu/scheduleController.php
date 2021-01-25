<?php

namespace App\Http\Controllers\projectActivity\pemandu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\activity;

class scheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityInstructorMiddleware']);
    }

    public function show($id)
    {
        $activity = activity::findOrFail($id);
        return view('activities.instructor.schedule.show', compact(['activity', 'id']));
    }
}
