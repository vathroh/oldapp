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
	$certificates   = $activity->certificate;



	if (is_null($certificates)) {
           $status =  "Sertifikat belum diset";
        } elseif ( Carbon::parse($certificates->release_date)->timestamp >  Carbon::now()->timestamp){
            $status = "Sertifikat belum di rilis, silahkan kembalil pada tanggal " . Carbon::parse($certificates->release_date)->format('d M Y');
	} else {
		$status = "OK";
	}
 	
	return view('activities.organizer.certificate.show', compact(['status', 'activity', 'attendances', 'id']));
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
        $certificates   = $activity->certificate;

        if (is_null($certificates)) {
            return "Sertifikat belum diset";
        } elseif (Carbon::parse($certificates->release_date)->timestamp >  Carbon::now()->timestamp) {
            return "Sertifikat belum di rilis, silahkan kembali pada tanggal " . $certificates->release_date;
        }

//        return view('activities.organizer.certificate.certificate', compact(['username', 'role', 'certificates']));

        $pdf = PDF::loadView('activities.organizer.certificate.certificate', compact(['username', 'role', 'certificates']));
        return $pdf->setPaper('a4', 'landscape')->download('SERTIFIKAT '.$activity->name. ' atas nama ' . $username .'.pdf');
    }
}
