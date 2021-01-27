<?php

namespace App\Http\Controllers\projectActivity\panitia;

use App\activity;
use App\attendance_record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use illuminate\Support\Facades\Auth;

class attendanceRecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityOrganizerMiddleware']);
    }

    public function store(Request $request)
    {
        attendance_record::create([
            'user_id'           => Auth::user()->id,
            'activity_id'       => $request->activity_id,
            'date'              => date("Y-m-d")
        ]);

        return redirect('/kegiatan/panitia/absensi/' . $request->activity_id);
    }

    public function show($id)
    {
        $activity       = activity::find($id);
        $activity_id    =  attendance_record::where('activity_id', $id)->where('user_id', Auth::User()->id)
            ->selectRaw('*, Date(created_at) as tanggal')->get();

        return view('activities.organizer.attendance_records.show', compact(['activity_id', 'activity', 'id']));
    }
}
