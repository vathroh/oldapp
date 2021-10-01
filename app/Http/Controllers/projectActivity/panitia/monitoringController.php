<?php

namespace App\Http\Controllers\projectActivity\panitia;

use App\job_desc;
use App\activity;
use App\activity_participant;
use App\attendance_record;
use App\biodata;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

class monitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityOrganizerMiddleware']);
    }

    public function users(){
       return new UserController; 
    }

    public function participants($id)
    {
        $activity = activity::find($id);
        $time = \Carbon\Carbon::parse($activity->start_date)->timestamp;
        $activity_date = getdate($time);

        $jobDesc = job_desc::withoutGlobalScopes()->selectRaw('id, user_id, job_title_id, work_zone_id, unix_timestamp(starting_date) as starting_date_timestamp, unix_timestamp(finishing_date) as finishing_date_timestamp, starting_date, finishing_date')->get();

        $jobDescAtTime = $jobDesc->where('starting_date_timestamp', '<=', $time)->where('finishing_date_timestamp', '>=', $time);

        $participants = activity_participant::where('activity_id', $id)->get();

        $attendances = attendance_record::where('activity_id', $id)->get();

        foreach($participants as $participant) {

            $user = $jobDescAtTime->where('user_id', $participant->user_id)->first();
            $telp = biodata::where('nik', $user->user->nik)->first()->HP??'-';
            $gender = biodata::where('nik', $user->user->nik)->first()->gender ?? '-';

            $participant->name = $user->user->name;
            $participant->job_title = $user->posisi->job_title;
            $participant->kab = $user->areaKerja->kabupaten->NAMA_KAB??'OSP1';
            $participant->gender = $gender;
            $participant->telp = $telp;
        }

        foreach($attendances as $attendance){
            $user = $jobDescAtTime->where('user_id', $attendance->user_id)->first();
            $role = $participants->where('user_id', $attendance->user_id)->first();
            $gender = biodata::where('nik', $user->user->nik)->first()->gender ?? '-';

            $attendance->role = $role ? $role->role : '';
            $attendance->gender = $gender;
        }

        return view('activities.organizer.monitoring.participants', compact(['id', 'activity', 'participants', 'attendances']));
    }

    public function instructor($id)
    {
        return view('activities.organizer.monitoring.participants');
    }

    public function organizer($id)
    {
        $activity = activity::find($id);
        $participants = attendance_record::distinct('attendance_records.id')->where('attendance_records.activity_id', $id)->join('activity_participants', 'activity_participants.user_id', '=', 'attendance_records.user_id')->where('activity_participants.activity_id', $id)->where('role', 'PANITIA')->select('attendance_records.*', 'role')->get();
        return view('activities.organizer.monitoring.organizer', compact(['id', 'activity', 'participants']));
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
