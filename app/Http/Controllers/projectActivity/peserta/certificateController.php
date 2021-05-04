<?php

namespace App\Http\Controllers\projectActivity\peserta;

use App\activity;
use App\attendance_record;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
	$certificates   = $activity->certificate;



	if (is_null($certificates)) {
           $status =  "Sertifikat belum diset";
        } elseif ( Carbon::parse($certificates->release_date)->timestamp >  Carbon::now()->timestamp){
            $status = "Sertifikat belum di rilis, silahkan kembali pada tanggal " . Carbon::parse($certificates->release_date)->format('d M Y');
	} else {
		$status = "OK";
	}

	$breakDays = explode(',', $activity->break);

        if (Auth::User()->ActivityAttendances->where('activity_id', $id)->count() >= Carbon::parse($activity->start_date)->diffInDays(Carbon::parse($activity->finish_date)) + 1 - count($breakDays) and auth::User()->ActivityEvaluations->where('activity_id', $id)->unique('subject_id')->count() >= $activity->subjects->where('evaluation_sheet', 1)->count()) {
            $certificate = "berhak";
        } else {
            $certificate = "tidak berhak";
	};
	
	for($i = 0; $i < count($breakDays); $i++){
		$break[] = Carbon::parse($breakDays[$i])->timestamp;
	}
	

	for( $i = 0; $i <= Carbon::parse($activity->start_date)->diffInDays($activity->finish_date); $i++ ){
		if( array_search(Carbon::parse($activity->start_date)->addDays($i)->timestamp, $break)===false){
			$day[] = Carbon::parse($activity->start_date)->addDays($i)->format('l, d F Y');
		}
	}	
	
	return view('activities.participants.certificate.show', compact(['activity', 'certificate', 'attendances', 'activity_item', 'role', 'id', 'breakDays', 'break', 'status']));
    }



    public function download($id)
    {
        $activity       = activity::findOrFail($id);
	$activity_item  = $id;
        $role           = "PESERTA";
	$attendances    = attendance_record::where('activity_id', $id)->selectRaw('*, Date(created_at) as tanggal')->get();
        $certificates   = $activity->certificate;

        if (is_null($certificates)) {
            return "Sertifikat belum diset";
        } elseif (Carbon::parse($certificates->release_date)->timestamp >  Carbon::now()->timestamp) {
            return "Sertifikat belum di rilis, silahkan kembali pada tanggal " . $certificates->release_date;
        }
	
	$breakDays = explode(',', $activity->break);

        if (Auth::User()->ActivityAttendances->where('activity_id', $id)->count() >= Carbon::parse($activity->start_date)->diffInDays(Carbon::parse($activity->finish_date)) + 1 - count($breakDays) and auth::User()->ActivityEvaluations->where('activity_id', $id)->unique('subject_id')->count() >= $activity->subjects->where('evaluation_sheet', 1)->count()) {
            if (Auth::User()->ActivityBlackList->where('activity_id', $id)->count() == 0) {
                $role       = "PESERTA";
                $username   = Auth::User()->sertificate;
                $name       = [$username];

        //         return view('activities.participants.certificate.certificate', compact(['username', 'role', 'certificates']));

                $pdf = PDF::loadView('activities.participants.certificate.certificate', compact(['username', 'role', 'certificates']));

                return $pdf->setPaper('a4', 'landscape')->download('Sertifikat ' . $activity->name .' atas nama ' . $username . '.pdf');
            } else {

                return redirect('/kegiatan/peserta/sertifikat/' . $id);
            };
        } else {
            return redirect('/kegiatan/peserta/sertifikat/' . $id);
        };
    }
}
