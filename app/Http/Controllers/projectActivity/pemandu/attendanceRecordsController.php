<?php

namespace App\Http\Controllers\projectActivity\pemandu;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\attendance_record;
use App\activity;

class attendanceRecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityInstructorMiddleware']);
    }

    public function store(Request $request)
    {
        attendance_record::create([
            'user_id'        => Auth::user()->id,
            'activity_id'     => $request->activity_id
        ]);

        return redirect('/kegiatan/pemandu/absensi/' . $request->activity_id);
    }

    public function show($id)
    {
        $activity       = activity::find($id);
        $activity_id    =  attendance_record::where('activity_id', $id)->where('user_id', Auth::User()->id)
            ->selectRaw('*, Date(created_at) as tanggal')->get();

        return view('activities.instructor.attendance_records.show', compact(['activity_id', 'activity', 'id']));
    }
}
