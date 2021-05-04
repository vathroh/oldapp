<?php

namespace App\Http\Controllers\projectActivity\pemandu;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\attendance_record;
use Carbon\Carbon;
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
	$certificates   = $activity->certificate;



	if (is_null($certificates)) {
           $status =  "Sertifikat belum diset";
        } elseif ( Carbon::parse($certificates->release_date)->timestamp >  Carbon::now()->timestamp){
            $status = "Sertifikat belum di rilis, silahkan kembali pada tanggal " . Carbon::parse($certificates->release_date)->format('d M Y');
	} else {
		$status = "OK";
	}

        return view('activities.instructor.certificate.show', compact(['status', 'activity', 'attendances', 'id']));
    }


    public function download($id)
    {
        $activity   = activity::findOrFail($id);
        $role       = "PEMANDU";
        $username   = Auth::User()->sertificate;
        $name       = [$username];
        $certificates   = $activity->certificate;

        if (is_null($certificates)) {
            return "Sertifikat belum diset";
        } elseif (Carbon::parse($certificates->release_date)->timestamp >  Carbon::now()->timestamp) {
            return "Sertifikat belum di rilis, silahkan kembali pada tanggal " . $certificates->release_date;
        }
	
//	return view('activities.instructor.certificate.certificate', compact(['username', 'role', 'certificates']));

        $pdf = PDF::loadView('activities.instructor.certificate.certificate', compact(['username', 'role', 'certificates']));
        return $pdf->setPaper('a4', 'landscape')->download('SERTIFIKAT '.$activity->name. ' atas nama ' . $username .'.pdf');
    }
}
