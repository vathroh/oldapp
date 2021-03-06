<?php

namespace App\Http\Controllers\projectActivity\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class personilsRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'projectActivityAdminMiddleware']);
    }

    public function show($id)
    {
        return view('activities.admin.personilRegister.show');
    }
}
