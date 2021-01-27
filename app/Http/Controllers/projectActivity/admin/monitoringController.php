<?php

namespace App\Http\Controllers\projectActivity\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class monitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityAdminMiddleware']);
    }

    public function participants($id)
    {
        return view('activities.admin.monitoring.participants');
    }

    public function instructor($id)
    {
        return view('activities.admin.monitoring.participants');
    }

    public function organizer($id)
    {
        return view('activities.admin.monitoring.participants');
    }

    public function evaluation($id)
    {
        return view('activities.admin.monitoring.participants');
    }

    public function assesment($id)
    {
        return view('activities.admin.monitoring.participants');
    }
}
