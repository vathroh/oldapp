<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\blacklist_user;

class blacklistController extends Controller
{
    public function evkinja(Request $request)
    {
        User::find($request->user_id)->blacklists()->sync($request->blacklist);
        $message = "Status Blacklist sudah disimpan";
        return response()->json($message);
    }
}
