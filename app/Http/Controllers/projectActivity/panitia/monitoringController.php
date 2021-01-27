<?php

namespace App\Http\Controllers\projectActivity\panitia;

use App\activity;
use App\attendance_record;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class monitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityOrganizerMiddleware']);
    }

    public function participants($id)
    {
        $activity = activity::find($id);
        $participants = attendance_record::distinct('attendance_records.id')->where('attendance_records.activity_id', $id)->join('activity_participants', 'activity_participants.user_id', '=', 'attendance_records.user_id')->where('activity_participants.activity_id', $id)->where('role', 'PESERTA')->select('attendance_records.*', 'role')->get();
        return view('activities.organizer.monitoring.participants', compact(['id', 'activity', 'participants']));
    }

    public function instructor($id)
    {
        return view('activities.organizer.monitoring.participants');
    }

    public function organizer($id)
    {
        return view('activities.organizer.monitoring.participants');
    }

    public function evaluation($id)
    {
        return view('activities.organizer.monitoring.participants');
    }

    public function assesment($id)
    {
        return view('activities.organizer.monitoring.participants');
    }
}
