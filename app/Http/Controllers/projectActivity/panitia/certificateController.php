<?php

namespace App\Http\Controllers\projectActivity\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\attendance_record;
use Carbon\Carbon;
use App\activity;
use PDF;

class certificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityOrganizerMiddleware: $id']);
    }


    public function show($id)
    {
        $activity       = activity::findOrFail($id);
        $attendances    = attendance_record::where('activity_id', $id)->selectRaw('*, Date(created_at) as tanggal')->get();

        return view('activities.organizer.certificate.show', compact(['activity', 'attendances', 'id']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download($id)
    {
        $activity       = activity::findOrFail($id);
        $role           = "PANITIA";
        $username       = Auth::User()->sertificate;
        $name           = [$username];

        //return view('activities.organizer.certificate.certificate', compact(['username', 'role']));

        $pdf = PDF::loadView('activities.participants.certificate.certificate', compact(['username', 'role']));
        return $pdf->setPaper('a4', 'landscape')->download('certificate.pdf');
    }
}
