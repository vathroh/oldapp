<?php

namespace App\Http\Controllers\projectActivity\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class certificatesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityAdminMiddleware']);
    }

    public function index($activity_id)
    {
        return view('');
    }
}
