<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class downloadController extends Controller
{
    public function download($folder, $file) 
    {

        //return Storage::download(asset('storage/' . $folder . "/" . $file));
        
        return Storage::download('storage/library/tmpphpwfyjc8.png');
    }
}
