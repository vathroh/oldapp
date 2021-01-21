<?php

namespace App\Http\Controllers\projectActivity\peserta;

use App\activity;
use App\attendance_record;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class attendaceRecordsController extends Controller
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
        $role           = "PESERTA";
        $activity       = activity::find($id);
        $activity_item  = $id;

        // return carbon::parse(attendance_record::first()->created_at)->format('l, d F Y');

        $activity_id    =  attendance_record::where('activity_id', $id)
            ->where('user_id', Auth::User()->id)
            ->selectRaw('*, Date(created_at) as tanggal')->get();

        return view('activities.participants.attendance_records.show', compact(['activity_id', 'role', 'activity', 'activity_item', 'id']));
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
}
