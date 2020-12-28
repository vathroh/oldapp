<?php

namespace App\Http\Controllers\personnelEvaluation;

use App\personnel_evaluation_setting;
use Illuminate\Support\Facades\Auth;
use App\job_desc;
use App\personnel_evaluator;
use App\personnel_evaluation_aspect;
use App\personnel_evaluation_value;
use App\personnel_evaluation_criteria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\personnel_evaluation_upload;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use App\CustomFunctions\googleFolderParent;
use App\google_folder;
use App\google_file;


class upload extends Controller
{
    public function evidencePage($valueId)
    {
        $id 			      = Auth::user()->id;
		    $lastYear 		  = personnel_evaluation_setting::max('year');
    	  $lastQuarter 	  = personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
		    $evaluators 	  = personnel_evaluator::where('evaluator', job_desc::where('user_id', Auth::user()->id)->pluck('job_title_id')->first())->get();   
    	  $lastSetting 	  = personnel_evaluation_setting::where('year', $lastYear)->where('quarter', $lastQuarter)->where('jobTitleId', Auth::user()->posisi()->first()->id)->get();
		    $aspects 		    = personnel_evaluation_aspect::get();
    	  $value 			    = personnel_evaluation_value::find($valueId);
		    $criterias 		  = personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
        $criteriIds		  = unserialize(personnel_evaluation_setting::where('id',$value->settingId)->pluck('aspectId')->first());
        $uploads        = personnel_evaluation_upload::where('personnel_evaluation_value_id', $valueId)->get();

//return $folder             = 'WEBAPP/Evkinja/' . 'Triwulan_' . $evaluationSetting->quarter .'_Tahun_' . $evaluationSetting->year . '/' . $kota . '/' . str_slug(Auth::user()->name);


		return view('personnelEvaluation.evaluation.upload1', compact(['uploads', 'evaluators', 'value', 'lastSetting', 'criteriIds', 'criterias', 'aspects']));
    }
    

    public function destroy($id)
    {
        $file   = personnel_evaluation_upload::find($id);
        $value  = $file->evaluationValue()->first();

        // use disk "public"
        // Storage::disk('public')->delete($file->path . '/' . $file->file_name); 
        
        //use Google Drive
        if($file->google == ""){
        }else{
            Storage::disk('google')->delete($file->google->file_id);
            $file->google->delete();
        }

        
        $file->delete();
        return redirect('/personnel-evaluation-upload/' . $value->id);
    }


    public function ajaxUploadFile(Request $request)
    {
        $aspects    = personnel_evaluation_aspect::where('criteria_id', $request->criteria)->where('evaluate_to', $request->jobTitleId)->get();
        return response()->json($aspects);
    }


    public function download($fileId)
    {
        $file = personnel_evaluation_upload::find($fileId);
        return Storage::disk('public')->download($file->path . '/' . $file->file_name); 
    }

//============================================================= download ==================================================================


    public function evidence(Request $request, $valueId)
    {
        $image              = $request->file('file');
        $originalFileName   = $image->getClientOriginalName();
        $fileExtension      = $image->getClientOriginalExtension();
        $fileNameOnly       = pathinfo($originalFileName, PATHINFO_FILENAME);
        $fileName           = str_slug($fileNameOnly) . "-" . time() . "." . $fileExtension;
        $kota               = str_slug(Auth::user()->jobDesc()->first()->kabupaten()->first()->NAMA_KAB);
        $evaluationSetting  = personnel_evaluation_value::find($valueId)->evaluationSetting()->first();
        $userName           = str_slug(Auth::user()->name);
        $folder             = 'WEBAPP/Evkinja/' . 'Triwulan_' . $evaluationSetting->quarter .'_Tahun_' . $evaluationSetting->year . '/' . $kota . '/' . $userName;
        
        // use "Public" Disk
        /*$uploadedFileName   = Storage::disk('public')->putFileAs($folder, $image, $fileName);
        personnel_evaluation_upload::create([
            'path'                              => $folder,
            'file_name'                         => $fileName,
            'personnel_evaluation_value_id'     => $request->valueId,
            'personnel_evaluation_criteria_id'  => $request->criteriaId,
            'personnel_evaluation_aspect_id'    => $request->aspectId

        ]);
         */
        //end "Public Disk"
        
        // use Googgle Drive Disk ================================================================
        $this->createGoogleDriveFolder($valueId);
        $folder_id   = google_folder::where('path_folder', $folder)->pluck('id_folder')->first();
        Storage::disk('google')->putFileAs($folder_id, $image, $fileName);

        personnel_evaluation_upload::create([
            'path'                              => $folder,
            'file_name'                         => $fileName,
            'personnel_evaluation_value_id'     => $request->valueId,
            'personnel_evaluation_criteria_id'  => $request->criteriaId,
            'personnel_evaluation_aspect_id'    => $request->aspectId
            
        ]);

        $this->googleFileId($folder_id);
        //end "Google Drive" =======================================================================
        
        $output     	= array('success' => 'File sudah selesai diupload');
        $uploads        = personnel_evaluation_upload::where('personnel_evaluation_value_id', $request->valueId )->get();
        $criterias 		= personnel_evaluation_criteria::orderBy('created_at', 'desc')->get();
        return response()->json([$output, $uploads, $criterias]);
    }


    public function googleFileId($folder_id)
    {
        $AllFiles = Storage::disk('google')->allFiles($folder_id);
        $FilesCount = count($AllFiles);
        for ($x = 0; $x < $FilesCount; $x++) {
            $file_id = substr($AllFiles[$x], 34, 33);
            $fileMetaData = Storage::disk('google')->getAdapter()->getMetadata($file_id);
            
            while(google_file::where('file_id', $file_id)->doesntExist()) {
                google_file::create([
                    'file_name'         => $fileMetaData["name"],
                    'file_id'           => $file_id,
                    'folder_id'         => $folder_id
                ]);
            }

           /* 
            if (personnel_evaluation_upload::where('file_id', $file_id)->doesntExist()) {
                personnel_evaluation_upload::where('id', personnel_evaluation_upload::max('id'))->update([
                    'file_id'           => $file_id,
                    'google_folder_id'  => $folder_id
                ]);
            }
            */
        }
    }

    public function createGoogleDriveFolder($valueId)
    {
        $googleFolder       = new googleFolderParent;
        $lastYear 	        = personnel_evaluation_setting::max('year');
        $lastQuarter        = personnel_evaluation_setting::where('year', $lastYear)->max('quarter');
        $evaluationSetting  = personnel_evaluation_value::find($valueId)->evaluationSetting()->first();
        
        // Create Quarter Folder
        $parent_folder_id   = $googleFolder->evkinja();
        $new_folder         = $parent_folder_id . '/Triwulan_' . $evaluationSetting->quarter .'_Tahun_' . $evaluationSetting->year;
        $new_folder_path    = 'WEBAPP/Evkinja/Triwulan-' . $evaluationSetting->quarter .'-Tahun-' . $evaluationSetting->year;
        $this->googleDriveFolder($parent_folder_id, $new_folder_path, $new_folder);

        //Create Kabupaten/Kota
        $parent_folder_id   = google_folder::where('path_folder', $new_folder_path)->pluck('id_folder')->first();
        $new_folder         = $parent_folder_id . '/' . str_slug(Auth::user()->jobDesc()->first()->kabupaten()->first()->NAMA_KAB);
        $new_folder_path    = 'WEBAPP/Evkinja/Triwulan_' . $evaluationSetting->quarter .'_Tahun_' . $evaluationSetting->year . '/' . str_slug(Auth::user()->jobDesc()->first()->kabupaten()->first()->NAMA_KAB);
        $this->googleDriveFolder($parent_folder_id, $new_folder_path, $new_folder);

        //nama Personil
        $parent_folder_id   = google_folder::where('path_folder', $new_folder_path)->pluck('id_folder')->first();
        $new_folder         = $parent_folder_id . '/' . str_slug(Auth::user()->name);
        $new_folder_path    = 'WEBAPP/Evkinja/Triwulan_' . $evaluationSetting->quarter .'_Tahun_' . $evaluationSetting->year . '/' . str_slug(Auth::user()->jobDesc()->first()->kabupaten()->first()->NAMA_KAB) . '/' . str_slug(Auth::user()->name);
;
        $this->googleDriveFolder($parent_folder_id, $new_folder_path, $new_folder);

    }

    public function googleDriveFolder($parent_folder_id, $new_folder_path, $new_folder)
    {
        if (google_folder::where('path_folder', $new_folder_path)->doesntExist()) {
            Storage::disk('google')->makeDirectory($new_folder);
            $newDirectories = Storage::disk('google')->directories($parent_folder_id);
            $countOfnewDirectories = count($newDirectories);

            for ($x = 0; $x < $countOfnewDirectories; $x++) {
                $new_folder_id = substr($newDirectories[$x], 34, 33);

                if (google_folder::where('id_folder', $new_folder_id)->doesntExist()) {
                    $newMetadata = Storage::disk('google')->getAdapter()->getMetadata($new_folder_id);

                    google_folder::create([
                        'parent_folder' => $parent_folder_id,
                        'id_folder' => $new_folder_id,
                        'nama_folder' => $newMetadata["name"],
                        'path_folder' =>  $new_folder_path
                    ]);
                }
            }
        }

    }











































// ==============================================================================================================================================================
     
    public function upload(Request $request) 
    {
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveFile($save->getFile());
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    /**
     * Saves the file to S3 server
     *
     * @param UploadedFile $file
     *
     * @return JsonResponse
     */
    protected function saveFileToGoogleDrive($file)
    {
        $fileName = $this->createFilename($file);

        $disk = Storage::disk('public');
        // It's better to use streaming Streaming (laravel 5.4+)
        $disk->putFileAs('photos', $file, $fileName);

        // for older laravel
        // $disk->put($fileName, file_get_contents($file), 'public');
        $mime = str_replace('/', '-', $file->getMimeType());

        // We need to delete the file when uploaded to s3
        unlink($file->getPathname());

        return response()->json([
            'path' => $disk->url($fileName),
            'name' => $fileName,
            'mime_type' =>$mime
        ]);
    }

    /**
     * Saves the file
     *
     * @param UploadedFile $file
     *
     * @return JsonResponse
     */
    protected function saveFile(UploadedFile $file)
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        // Group files by the date (week
        $dateFolder = date("Y-m-W");

        // Build the file path
        $filePath = "upload/{$mime}/{$dateFolder}/";
        $finalPath = storage_path("app/".$filePath);

        // move the file name
        $file->move($finalPath, $fileName);

        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }
}
