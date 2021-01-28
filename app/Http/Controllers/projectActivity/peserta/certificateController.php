<?php

namespace App\Http\Controllers\projectActivity\peserta;

use App\activity;
use App\attendance_record;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class certificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityParticipantMiddleware']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity_item  = $id;
        $role           = "PESERTA";
        $activity       = activity::findOrFail($id);
        $attendances    = attendance_record::where('activity_id', $id)->selectRaw('*, Date(created_at) as tanggal')->get();

        if (Auth::User()->ActivityAttendances->where('activity_id', $id)->count() >= Carbon::parse($activity->start_date)->diffInDays(Carbon::parse($activity->finish_date)) + 1 and auth::User()->ActivityEvaluations->where('activity_id', $id)->unique('subject_id')->count() >= $activity->subjects->where('evaluation_sheet', 1)->count()) {
            $certificate = "berhak";
        } else {
            $certificate = "tidak berhak";
        };

        return view('activities.participants.certificate.show', compact(['activity', 'certificate', 'attendances', 'activity_item', 'role', 'id']));
    }



    public function download($id)
    {
        $activity       = activity::findOrFail($id);



        if (Auth::User()->ActivityAttendances->where('activity_id', $id)->count() >= Carbon::parse($activity->start_date)->diffInDays(Carbon::parse($activity->finish_date)) + 1 and auth::User()->ActivityEvaluations->where('activity_id', $id)->unique('subject_id')->count() >= $activity->subjects->where('evaluation_sheet', 1)->count()) {
            if (Auth::User()->ActivityBlackList->where('activity_id', $id)->count() == 0) {
                $role       = "PESERTA";
                $username   = Auth::User()->sertificate;
                $name       = [$username];

                // return view('activities.participants.certificate.certificate', compact(['username', 'role']));

                $pdf = PDF::loadView('activities.participants.certificate.certificate', compact(['username', 'role']));

                return $pdf->setPaper('a4', 'landscape')->download('certificate.pdf');
            } else {

                return redirect('/kegiatan/peserta/sertifikat/' . $id);
            };
        } else {
            return redirect('/kegiatan/peserta/sertifikat/' . $id);
        };
    }
}
