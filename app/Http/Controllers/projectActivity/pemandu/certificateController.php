<?php

namespace App\Http\Controllers\projectActivity\pemandu;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\attendance_record;
use App\activity;
use PDF;

class certificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityInstructorMiddleware: $id']);
    }


    public function show($id)
    {
        $activity       = activity::findOrFail($id);
        $attendances    = attendance_record::where('activity_id', $id)->selectRaw('*, Date(created_at) as tanggal')->get();

        return view('activities.instructor.certificate.show', compact(['activity', 'attendances', 'id']));
    }


    public function download($id)
    {
        $activity   = activity::findOrFail($id);
        $role       = "PEMANDU";
        $username   = Auth::User()->sertificate;
        $name       = [$username];

        //return view('activities.instructor.certificate.certificate', compact(['username', 'role']));

        $pdf = PDF::loadView('activities.instructor.certificate.certificate', compact(['username', 'role']));
        return $pdf->setPaper('a4', 'landscape')->download('certificate.pdf');
    }
}
