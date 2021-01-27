<?php

namespace App\Http\Controllers\projectActivity\peserta;

use App\activity;
use Carbon\Carbon;
use App\attendance_record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class attendaceRecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityParticipantMiddleware']);
    }


    public function store(Request $request)
    {
        attendance_record::create([
            'user_id'        => Auth::user()->id,
            'activity_id'     => $request->activity_id
        ]);

        return redirect('/kegiatan/peserta/absensi/' . $request->activity_id);
    }


    public function show($id)
    {
        $activity_item  = $id;
        $role           = "PESERTA";
        $activity       = activity::find($id);
        $activity_id    =  attendance_record::where('activity_id', $id)->where('user_id', Auth::User()->id)
            ->selectRaw('*, Date(created_at) as tanggal')->get();

        return view('activities.participants.attendance_records.show', compact(['activity_id', 'role', 'activity', 'activity_item', 'id']));
    }
}
