<?php

namespace App\Http\Controllers;

use App\google_file;
use App\google_folder;
use Illuminate\Http\Request;
use App\personnel_evaluation_upload;
use Illuminate\Support\Facades\Storage;

class GoogleDriveController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
        // dd(Storage::disk('google'));

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
        //
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

    public function UploadFoto0(Request $request)
    {
        // dd($request->file("file"));
        // echo "halo";
        // Route::post('/upload', function (Request $request) {
        $request->file("file")->store("1smwHooFqkLU5T7G2ucvJt_qhcGFqq92q", "google");
        // return view('home');
        // })->name("upload");
    }

    public function view($folder_id){
        $folderMetaData = Storage::disk('google')->getAdapter()->getMetadata($folder_id);
        $folders = $this->folder($folder_id);
        $files = $this->files($folder_id);
        return view('google.index', compact(['folders', 'files', 'folderMetaData']));
    }

    public function folder($folder_id){
        $folder = google_folder::where('id_folder', $folder_id)->first();
        $childFolders = Storage::disk('google')->directories($folder_id);
        $childFolderProperties = [];
        
        foreach($childFolders as $key => $childFolder){
            $childFolder_id = substr($childFolder, 34, 33);
            $childFolderMetaData = Storage::disk('google')->getAdapter()->getMetadata($childFolder_id);

            while (google_folder::where('id_folder', $childFolder_id)->doesntExist()) {
                google_folder::create([
                    'parent_folder' => $folder_id,
                    'id_folder' => $childFolder_id,
                    'nama_folder' => $childFolderMetaData['name'],
                    'path_folder' => $folder->path_folder . '/' . $childFolderMetaData['name']
                ]);
            }

            $childFolderProperties[$key]['folder_name'] = $childFolderMetaData['name'];
            $childFolderProperties[$key]['folder_id'] = $childFolder_id;
        }

        return collect($childFolderProperties);

    }

    public function files($folder_id)
    {
        $filesProperties = [];
        $Files = Storage::disk('google')->files($folder_id);
        foreach($Files as $key => $File){
            $file_id = substr($File, 34, 33);
            $fileMetaData = Storage::disk('google')->getAdapter()->getMetadata($file_id);

            while (google_file::where('file_id', $file_id)->doesntExist()) {
                google_file::create([
                    'file_name'         => $fileMetaData["name"],
                    'file_id'           => $file_id,
                    'folder_id'         => $folder_id
                ]);
            }

            personnel_evaluation_upload::where('file_name', $fileMetaData['name'])->update([
                'google_folder_id' => $folder_id,
                'file_id' => $file_id
            ]);

            $filesProperties[$key]['file_name'] = $fileMetaData['name'];
            $filesProperties[$key]['file_id'] = $file_id;

          
        }

        return collect($filesProperties);
    }

}
