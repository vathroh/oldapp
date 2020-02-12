<?php

namespace App\Http\Controllers;

use App\google_folder;
use Illuminate\Http\Request;

class google_foldersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('document.folder', compact('google_folders'));
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
     * @param  \App\google_folder  $google_folder
     * @return \Illuminate\Http\Response
     */
    public function show(google_folder $google_folder)
    {
        // return view;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\google_folder  $google_folder
     * @return \Illuminate\Http\Response
     */
    public function edit(google_folder $google_folder)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\google_folder  $google_folder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, google_folder $google_folder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\google_folder  $google_folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(google_folder $google_folder)
    {
        //
    }
}
