<?php

namespace App\Http\Controllers\projectActivity\peserta;

use App\activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class materialsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityParticipantMiddleware']);
    }

    public function show($id)
    {
        $activity = activity::findOrFail($id);
        return view('activities.participants.materials.show', compact(['activity', 'id']));
    }
}
