<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class downloadController extends Controller
{
    public function download($folder, $file) 
    {

        return Response::download(public_path('/storage/' . $folder . "/" . $file));
        
        //return Storage::download('storage/library/' . $file);
    }
}
