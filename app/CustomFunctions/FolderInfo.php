<?php

namespace App\CustomFunctions;

use App\google_folder;
use App\village;
use App\ksm;
use Illuminate\Support\Facades\Storage;

class FolderInfo
{
    private $parent_folder_id,
        $parent_folder_path,
        $parent_folder_code,
        $new_folder_path,
        $new_folder,
        $new_folder_code,
        $new_folder_name,
        $new_folder_request,
        $new_folder_level,
        $JenisDokumen;

    public function CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request)
    {
        $parent_folder_path = google_folder::where('kode_folder', $parent_folder_code)->get('path_folder')[0]['path_folder'];
        $parent_folder_id = google_folder::where('kode_folder', $parent_folder_code)->get('id_folder')[0]['id_folder'];
        $new_folder_code = $parent_folder_code . $new_folder_request;
        $new_folder_path = $parent_folder_path . '/' .  $new_folder_name;
        $new_folder =  $parent_folder_id . '/' .  $new_folder_name;

        $this->GoogleDriveFolder($parent_folder_id, $new_folder_path, $new_folder_code, $new_folder);
    }

    public function GoogleDriveFolder($parent_folder_id, $new_folder_path, $new_folder_code, $new_folder)
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
                        'kode_folder' => $new_folder_code,
                        'parent_folder' => $parent_folder_id,
                        'id_folder' => $new_folder_id,
                        'nama_folder' => $newMetadata["name"],
                        'path_folder' =>  $new_folder_path
                    ]);
                }
            }
        }
    }

    public function CreateAndSavePencairanPerencanaanFolder($parent_folder_code, $JenisDokumen, $new_folder_code)
    {
        $parent_folder_path = google_folder::where('kode_folder', $parent_folder_code)->get('path_folder')[0]['path_folder'];
        $parent_folder_id = google_folder::where('kode_folder', $parent_folder_code)->get('id_folder')[0]['id_folder'];


        if ($JenisDokumen === "PENCAIRAN TAHAP 1") {
            $new_folder_path = $parent_folder_path . '/PENCAIRAN';
            $new_folder = $parent_folder_id . '/PENCAIRAN';
            $new_folder_code .=  'PENCAIRAN';
        } elseif ($JenisDokumen === "PENCAIRAN TAHAP 2") {
            $new_folder_path = $parent_folder_path . '/PENCAIRAN';
            $new_folder = $parent_folder_id . '/PENCAIRAN';
            $new_folder_code .=  'PENCAIRAN';
        } elseif ($JenisDokumen === "LPJ BKM") {
            $new_folder_path = $parent_folder_path . '/PENCAIRAN';
            $new_folder = $parent_folder_id . '/PENCAIRAN';
            $new_folder_code .=  'PENCAIRAN';
        } else {
            $new_folder_path =  $parent_folder_path . '/PERENCANAAN';
            $new_folder = $parent_folder_id . '/PERENCANAAN';
            $new_folder_code .= 'PERENCANAAN';
        }
        $this->GoogleDriveFolder($parent_folder_id, $new_folder_path, $new_folder_code, $new_folder);
    }
}
