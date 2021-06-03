<?php

namespace App\Http\Controllers;

use App\Http\UserController;
use Illuminate\Http\Request;

class FasilitatorController extends Controller
{
    public function user(){
        return new UserController;
    }

    public function fasilitators()
    {
        return $this->user->users_now();
    }

    public function index()
    {
        $fasilitators = $this->fasilitators();
    }
}
