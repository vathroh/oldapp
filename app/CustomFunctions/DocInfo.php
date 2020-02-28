<?php

namespace App\CustomFunctions;

use Illuminate\Support\Facades\Storage;
use App\Document;
use App\google_folder;
use App\village;

class DocInfo
{
    public function SafeFile($KodeKegiatan, $files, $fileName, $JenisDokumen, $kd_kel, $kd_kab, $new_folder_name, $parent_folder_code, $tipedokumen)
    {
        $nama_desa = village::where('KD_KEL', $kd_kel)->get('NAMA_DESA')[0]['NAMA_DESA'];
        $nama_kabupaten = village::where('KD_KAB', $kd_kab)->get('NAMA_KAB')[0]['NAMA_KAB'];
        $parent_folder_path = google_folder::where('kode_folder', $parent_folder_code)->get('path_folder')[0]['path_folder'];
        $new_folder_path = $parent_folder_path . '/' . $new_folder_name;
        $fileExtension = $files->getClientOriginalExtension();
        $fileName .= ' ' . $nama_desa . ' ' . $nama_kabupaten;
        $noUrut = Document::where('file_name', $fileName)->count() + 1;
        $newFileName = $fileName . "(" . $noUrut . ")";
        // return $nama_desa;

        if (google_folder::where('path_folder', $new_folder_path)->exists()) {
            $saved_folder_id = google_folder::where('path_folder', $new_folder_path)->get('id_folder')[0]['id_folder'];

            Storage::disk('google')->putFileAs($saved_folder_id, $files, $newFileName);

            $AllFiles = Storage::disk('google')->allFiles($saved_folder_id);
            $FilesCount = count($AllFiles);
            for ($x = 0; $x < $FilesCount; $x++) {
                $file_id = substr($AllFiles[$x], 34, 33);
                if (Document::where('file_id', $file_id)->doesntExist()) {
                    $document = new document;
                    $document->folder_id = $saved_folder_id;
                    $document->file_id = $file_id;
                    $document->file_name = $newFileName;
                    $document->file_extension =  $fileExtension;
                    $document->tipe_dokumen =  $tipedokumen;
                    $document->jenis_dokumen =  $JenisDokumen;
                    $document->uploaded_by =  '-';
                    $document->scope = '-';
                    $document->kode_kegiatan = $KodeKegiatan;
                    $document->nama_desa = $nama_desa;
                    $document->nama_kab = $nama_kabupaten;
                    $document->Comments = '-';
                    $document->path = $new_folder_path;
                    $document->link = 'https://drive.google.com/file/d/' . $file_id . '/view';
                    $document->save();
                }
            }
        }
    }
}
