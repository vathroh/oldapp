<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Document;
use App\google_folder;
use Illuminate\Http\Request;
use App\kabupaten;
use App\village;
use App\ksm;
use App\jenisfoto;
use App\jenisdokumenksm;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = DB::table('documents')
            ->where('tipe_dokumen', 'IMAGE')
            ->orderByDesc('updated_at')
            ->paginate(9);
        $google_folders = google_folder::all();
        return view('document.index', compact(['documents', 'google_folders']));
    }

    public function table()
    {
        $documents = DB::table('documents')
            ->orderByDesc('updated_at')
            ->paginate(12);

        $google_folders = google_folder::all();

        return view('document.table', compact(['documents', 'google_folders']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kabupaten = kabupaten::all();
        $villages = village::all();
        return view('document.create', compact('kabupaten'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function storeFoto(Request $request)
    {


        $id_folder_tahun = '1G-r0wAeydxUePrK-91JKGCvgtFQI9L2j';
        $metadataTahun = Storage::disk('google')->getAdapter()->getMetadata($id_folder_tahun);
        $namaTahun = substr($metadataTahun['name'], -4);
        $Foto = jenisfoto::where('parent', $request->jenisDokumenFoto)->get('JenisFoto');
        $jenisDokumenFoto = $Foto[0]['JenisFoto'];

        $nama_kab = kabupaten::where('kode_kab', $request->foto_kabupaten)->get('NAMA_KAB');
        $nama_kabupaten = $nama_kab[0]['NAMA_KAB'];
        $path_kab = 'OPT-1 / BDI 2018 / ' . $request->foto_kabupaten . ' ' . $nama_kabupaten;
        $folder_baru =  $id_folder_tahun . '/' . $request->foto_kabupaten . ' ' . $nama_kabupaten;


        if (google_folder::where('path_folder', $path_kab)->doesntExist()) {
            Storage::disk('google')->makeDirectory($folder_baru);

            $f = Storage::disk('google')->directories($id_folder_tahun);
            $g = count($f);


            for ($x = 0; $x < $g; $x++) {
                $k = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $k)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($k);

                    google_folder::create([
                        'kode_folder' => $namaTahun . $request->foto_kabupaten,
                        'parent_folder' => $id_folder_tahun,
                        'id_folder' => $i["path"],
                        'nama_folder' => $i["name"],
                        'path_folder' =>  $path_kab
                    ]);
                }
            }
        }

        //Folder Kelurahan
        $id_folder_kab_exist = google_folder::where('path_folder', $path_kab)->get('id_folder')[0]['id_folder'];
        $nama_desa = village::where('KD_KEL', $request->foto_kelurahan)->get('NAMA_DESA')[0]['NAMA_DESA'];
        $path_desa =  $path_kab . ' / ' . $request->foto_kelurahan . ' ' . $nama_desa;
        $folder_baru =  $id_folder_kab_exist . '/' . $request->foto_kelurahan . ' ' . $nama_desa;

        $kecamatan = village::where('KD_KEL', $request->foto_kelurahan)->get('NAMA_KEC')[0]['NAMA_KEC'];
        $kode_kel = $request->foto_kelurahan;

        if (google_folder::where('path_folder', $path_desa)->doesntExist()) {
            Storage::disk('google')->makeDirectory($folder_baru);

            $f = Storage::disk('google')->directories($id_folder_kab_exist);
            $g = count($f);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $k)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($k);

                    google_folder::create([
                        'kode_folder' => $namaTahun . $request->foto_kelurahan,
                        'parent_folder' => $id_folder_kab_exist,
                        'id_folder' => $i["path"],
                        'nama_folder' => $i["name"],
                        'path_folder' =>  $path_desa
                    ]);
                }
            }
        }

        // //Folder KSM
        $id_folder_desa_exist = google_folder::where('path_folder', $path_desa)->get('id_folder')[0]['id_folder'];
        $nama_ksm = ksm::where('KD_KSM', $request->foto_ksm)->get('NAMA_KSM')[0]['NAMA_KSM'];
        $path_ksm = $path_desa . ' / '  . $nama_ksm;
        $folder_baru =  $id_folder_desa_exist . '/' . $nama_ksm;


        if (google_folder::where('path_folder', $path_ksm)->doesntExist()) {
            Storage::disk('google')->makeDirectory($folder_baru);

            $f = Storage::disk('google')->directories($id_folder_desa_exist);
            $g = count($f);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $k)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($k);
                    $google_folder = new google_folder;
                    google_folder::create([
                        'kode_folder' => $namaTahun . $request->foto_ksm,
                        'parent_folder' => $id_folder_desa_exist,
                        'id_folder' => $i["path"],
                        'nama_folder' => $i["name"],
                        'path_folder' =>  $path_ksm
                    ]);
                }
            }
        }
        $namaksm = ksm::where('KD_KSM', $request->foto_ksm)->get('NAMA_KSM')[0]['NAMA_KSM'];
        if ($request->jenisDokumenFoto == 1) {
            // //Folder DOK PERSIAPAN
            $id_folder_ksm_exist = google_folder::where('path_folder', $path_ksm)->get('id_folder')[0]['id_folder'];
            $path_folder_baru = $path_ksm . ' / '  . 'DOK PERSIAPAN';
            $folder_baru =  $id_folder_ksm_exist . '/' . 'DOK PERSIAPAN';
            $newName = $request->jenisDokumenFoto . ' KSM ' . $namaksm . ' KEL ' .  ' ' . $nama_desa . ' ' . $nama_kabupaten;
        } else if ($request->jenisDokumenFoto == 2) {
            // //Folder DOK PERSIAPAN
            $id_folder_ksm_exist = google_folder::where('path_folder', $path_ksm)->get('id_folder')[0]['id_folder'];
            $path_folder_baru = $path_ksm . ' / '  . 'DOK PERSIAPAN';
            $folder_baru =  $id_folder_ksm_exist . '/' . 'DOK PERSIAPAN';
            $newName = $jenisDokumenFoto . ' KSM ' . $namaksm . ' KEL ' .  ' ' . $nama_desa . ' ' . $nama_kabupaten;
        } else if ($request->jenisDokumenFoto == 3) {
            // //Folder DOK PERSIAPAN
            $id_folder_ksm_exist = google_folder::where('path_folder', $path_ksm)->get('id_folder')[0]['id_folder'];
            $path_folder_baru = $path_ksm . ' / '  . 'DOK PERSIAPAN';
            $folder_baru =  $id_folder_ksm_exist . '/' . 'DOK PERSIAPAN';
            $newName = $jenisDokumenFoto . ' KSM ' . $namaksm . ' KEL ' .  ' ' . $nama_desa . ' ' . $nama_kabupaten;
        } else {
            // //Folder KEGIATAN
            $id_folder_ksm_exist = google_folder::where('path_folder', $path_ksm)->get('id_folder')[0]['id_folder'];
            $path_folder_baru = $path_ksm . ' / ' . $request->foto_kegiatan;
            $folder_baru =  $id_folder_ksm_exist . '/' . $request->foto_kegiatan;
            $newName =  $jenisDokumenFoto . ' ' . $request->TitikFoto . ' KSM ' . $namaksm . ' KEL ' .  ' ' . $nama_desa . ' ' . $nama_kabupaten;
        }

        if (google_folder::where('path_folder', $path_folder_baru)->doesntExist()) {
            Storage::disk('google')->makeDirectory($folder_baru);

            $f = Storage::disk('google')->directories($id_folder_ksm_exist);
            $g = count($f);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $k)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($k);
                    $google_folder = new google_folder;
                    google_folder::create([
                        'kode_folder' => $namaTahun . $request->jenisDokumenFoto,
                        'parent_folder' => $id_folder_ksm_exist,
                        'id_folder' => $i["path"],
                        'nama_folder' => $i["name"],
                        'path_folder' =>  $path_folder_baru
                    ]);
                }
            }
        }

        $files = $request->file('file_foto');
        $fileExtension = $files->getClientOriginalExtension();
        $fileSize = $files->getClientSize();

        if (google_folder::where('path_folder', $path_folder_baru)->exists()) {
            $id_currentfolder = google_folder::where('path_folder', $path_folder_baru)->get('id_folder');
            $savefolder = $id_currentfolder[0]['id_folder'];
            Storage::disk('google')->putFileAs($savefolder, $files, $newName);

            $jmlDokumen = Storage::disk('google')->allFiles($savefolder);

            $g = count($jmlDokumen);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($jmlDokumen[$x], 34, 33);
                if (Document::where('file_id', $k)->doesntExist()) {
                    $document = new document;
                    $document->file_id = $k;
                    $document->file_name = $newName;
                    $document->file_extension =  $fileExtension;
                    $document->file_Size =  $fileSize;
                    $document->tipe_dokumen =  'IMAGE';
                    $document->jenis_dokumen =  $jenisDokumenFoto;
                    $document->uploaded_by =  '-';
                    $document->scope = '-';
                    $document->kode_kegiatan = '-';
                    $document->kode_kel = $kode_kel;
                    $document->desa = $nama_desa;
                    $document->kecamatan = $kecamatan;
                    $document->kabupaten = $nama_kabupaten;
                    $document->link = 'https://drive.google.com/file/d/' . $k . '/view';
                    $document->save();
                }
            }
        }

        return redirect('/doc');
    }


    public function store(Request $request)
    {
        $id_folder_tahun = '1G-r0wAeydxUePrK-91JKGCvgtFQI9L2j';
        $metadataTahun = Storage::disk('google')->getAdapter()->getMetadata($id_folder_tahun);
        $namaTahun = substr($metadataTahun['name'], -4);

        $nama_kab = village::where('KD_KAB', $request->kabupaten)->get('NAMA_KAB');
        $nama_kabupaten = $nama_kab[0]['NAMA_KAB'];
        $path_kab = 'OPT-1 / BDI 2018 / ' . $request->kabupaten . ' ' . $nama_kabupaten;
        $folder_baru =  $id_folder_tahun . '/' . $request->kabupaten . ' ' . $nama_kabupaten;


        if (google_folder::where('path_folder', $path_kab)->doesntExist()) {
            Storage::disk('google')->makeDirectory($folder_baru);

            $f = Storage::disk('google')->directories($id_folder_tahun);
            $g = count($f);
            // return $f;

            for ($x = 0; $x < $g; $x++) {
                $k = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $k)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($k);
                    $h = substr($i["path"], 34, 33);
                    $j = substr($i["path"], 0, 33);
                    $google_folder = new google_folder;
                    google_folder::create([
                        'kode_folder' => $namaTahun . $request->kabupaten,
                        'parent_folder' => $id_folder_tahun,
                        'id_folder' => $i["path"],
                        'nama_folder' => $i["name"],
                        'path_folder' =>  $path_kab
                    ]);
                }
            }
        }

        //Folder Kelurahan
        $id_folder_kab_exist = google_folder::where('path_folder', $path_kab)->get('id_folder')[0]['id_folder'];

        $nama_desa = village::where('KD_KEL', $request->kelurahan)->get('NAMA_DESA')[0]['NAMA_DESA'];
        $path_desa =  $path_kab . ' / ' . $request->kelurahan . ' ' . $nama_desa;
        $folder_baru =  $id_folder_kab_exist . '/' . $request->kelurahan . ' ' . $nama_desa;



        $kd_kel = $request->kelurahan;;
        $kec = village::where('KD_KEL', $kd_kel)->get('NAMA_KEC');
        $kecamatan = $kec[0]['NAMA_KEC'];

        if (google_folder::where('path_folder', $path_desa)->doesntExist()) {
            Storage::disk('google')->makeDirectory($folder_baru);

            $f = Storage::disk('google')->directories($id_folder_kab_exist);
            $g = count($f);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $k)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($k);
                    $h = substr($i["path"], 34, 33);
                    $j = substr($i["path"], 0, 33);
                    $google_folder = new google_folder;
                    google_folder::create([
                        'kode_folder' => $namaTahun . $kd_kel,
                        'parent_folder' => $id_folder_tahun,
                        'id_folder' => $i["path"],
                        'nama_folder' => $i["name"],
                        'path_folder' => $path_desa
                    ]);
                }
            }
        }

        $id_folder_desa_exist = google_folder::where('path_folder', $path_desa)->get('id_folder')[0]['id_folder'];

        if ($request->jenisDokumen === "PENCAIRAN TAHAP 1") {
            $path_folderDokumen = $path_desa . ' / ' . 'PENCAIRAN';
            $folderDokumen = $id_folder_desa_exist . '/PENCAIRAN';
            $kode_folderDokumen = $namaTahun . $kd_kel . 'CAIR';
        } elseif ($request->jenisDokumen === "PENCAIRAN TAHAP 2") {
            $path_folderDokumen = $path_desa . ' / ' . 'PENCAIRAN';
            $folderDokumen = $id_folder_desa_exist . '/PENCAIRAN';
            $kode_folderDokumen = $namaTahun . $kd_kel . 'CAIR';
        } elseif ($request->jenisDokumen === "LPJ BKM") {
            $path_folderDokumen = $path_desa . ' / ' . 'PENCAIRAN';
            $folderDokumen = $id_folder_desa_exist . '/PENCAIRAN';
            $kode_folderDokumen = $namaTahun . $kd_kel . 'CAIR';
        } else {
            $path_folderDokumen = $path_desa . ' / ' . 'PERENCANAAN';
            $folderDokumen = $id_folder_desa_exist . '/PERENCANAAN';
            $kode_folderDokumen =  $namaTahun . $kd_kel . 'RENCANA';
        }

        if (google_folder::where('path_folder', $path_folderDokumen)->doesntExist()) {
            Storage::disk('google')->makeDirectory($folderDokumen);
            $f = Storage::disk('google')->directories($id_folder_desa_exist);
            $g = count($f);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $k)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($k);
                    $h = substr($i["path"], 34, 33);
                    $j = substr($i["path"], 0, 33);
                    $google_folder = new google_folder;
                    google_folder::create([
                        'kode_folder' => $kode_folderDokumen,
                        'parent_folder' => $id_folder_tahun,
                        'id_folder' => $i["path"],
                        'nama_folder' => $i["name"],
                        'path_folder' => $path_folderDokumen
                    ]);
                }
            }
        }

        $files = $request->file('file');
        $fileName = $files->getClientOriginalName();
        $fileExtension = $files->getClientOriginalExtension();
        $fileSize = $files->getClientSize();
        $fileName = $request->jenisDokumen . ' ' . $nama_desa . ' ' . $nama_kabupaten;


        if (google_folder::where('path_folder', $path_folderDokumen)->exists()) {
            $id_currentfolder = google_folder::where('path_folder', $path_folderDokumen)->get('id_folder');
            $savefolder = $id_currentfolder[0]['id_folder'];

            Storage::disk('google')->putFileAs($savefolder, $files, $fileName);

            $jmlDokumen = Storage::disk('google')->allFiles($savefolder);
            $g = count($jmlDokumen);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($jmlDokumen[$x], 34, 33);
                if (Document::where('file_id', $k)->doesntExist()) {
                    $document = new document;
                    $document->file_id = $k;
                    $document->file_name = $fileName;
                    $document->file_extension =  $fileExtension;
                    $document->file_Size =  $fileSize;
                    $document->tipe_dokumen =  'PDF';
                    $document->jenis_dokumen =  $request->jenisDokumen;
                    $document->uploaded_by =  '-';
                    $document->scope = '-';
                    $document->kode_kegiatan = '-';
                    $document->kode_kel = $kd_kel;
                    $document->desa = $nama_desa;
                    $document->kecamatan = $kecamatan;
                    $document->kabupaten = $nama_kabupaten;
                    $document->link = 'https://drive.google.com/file/d/' . $k . '/view';
                    $document->save();
                }
            }
        }
        return redirect('/doc');
    }

    public function storeKSM(Request $request)
    {

        $id_folder_tahun = '1G-r0wAeydxUePrK-91JKGCvgtFQI9L2j';
        $metadataTahun = Storage::disk('google')->getAdapter()->getMetadata($id_folder_tahun);
        $namaTahun = substr($metadataTahun['name'], -4);

        $nama_kab = village::where('KD_KAB', $request->ksm_kabupaten)->get('NAMA_KAB');
        $nama_kabupaten = $nama_kab[0]['NAMA_KAB'];
        $path_kab = 'OPT-1 / BDI 2018 / ' . $request->ksm_kabupaten . ' ' . $nama_kabupaten;
        $folder_baru =  $id_folder_tahun . '/' . $request->ksm_kabupaten . ' ' . $nama_kabupaten;


        if (google_folder::where('path_folder', $path_kab)->doesntExist()) {
            Storage::disk('google')->makeDirectory($folder_baru);

            $f = Storage::disk('google')->directories($id_folder_tahun);
            $g = count($f);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $k)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($k);
                    $h = substr($i["path"], 34, 33);
                    $j = substr($i["path"], 0, 33);
                    $google_folder = new google_folder;
                    google_folder::create([
                        'kode_folder' => $namaTahun . $request->ksm_kabupaten,
                        'parent_folder' => $id_folder_tahun,
                        'id_folder' => $i["path"],
                        'nama_folder' => $i["name"],
                        'path_folder' =>  $path_kab
                    ]);
                }
            }
        }

        //Folder Kelurahan
        $id_folder_kab_exist = google_folder::where('path_folder', $path_kab)->get('id_folder')[0]['id_folder'];
        $nama_kelurahan = village::where('KD_KEL', $request->ksm_kelurahan)->get('NAMA_DESA');
        $nama_desa = $nama_kelurahan[0]['NAMA_DESA'];
        $path_desa =  $path_kab . ' / ' . $request->ksm_kelurahan . ' ' . $nama_desa;
        $folder_baru =  $id_folder_kab_exist . '/' . $request->ksm_kelurahan . ' ' . $nama_desa;

        $kec = village::where('KD_KEL', $request->ksm_kelurahan)->get('NAMA_KEC');
        $kecamatan = $kec[0]['NAMA_KEC'];
        $kode_kel = village::where('KD_KEL', $request->ksm_kelurahan)->get('KD_KEL');
        $kd_kel = $kode_kel[0]['KD_KEL'];

        if (google_folder::where('path_folder', $path_desa)->doesntExist()) {
            Storage::disk('google')->makeDirectory($folder_baru);

            $f = Storage::disk('google')->directories($id_folder_kab_exist);
            $g = count($f);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $k)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($k);
                    $h = substr($i["path"], 34, 33);
                    $j = substr($i["path"], 0, 33);
                    $google_folder = new google_folder;
                    google_folder::create([
                        'kode_folder' => $namaTahun . $request->ksm_kelurahan,
                        'parent_folder' => $id_folder_kab_exist,
                        'id_folder' => $i["path"],
                        'nama_folder' => $i["name"],
                        'path_folder' =>  $path_desa
                    ]);
                }
            }
        }

        //Folder KSM
        $id_folder_desa_exist = google_folder::where('path_folder', $path_desa)->get('id_folder')[0]['id_folder'];
        $path_ksm = $path_desa . ' / ' . $request->ksm_ksm;
        $folder_baru =  $id_folder_desa_exist . '/' . $request->ksm_ksm;


        if (google_folder::where('path_folder', $path_ksm)->doesntExist()) {
            Storage::disk('google')->makeDirectory($folder_baru);

            $f = Storage::disk('google')->directories($id_folder_desa_exist);
            $g = count($f);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $k)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($k);
                    $h = substr($i["path"], 34, 33);
                    $j = substr($i["path"], 0, 33);
                    $google_folder = new google_folder;
                    google_folder::create([
                        'kode_folder' => $namaTahun . $request->ksm_ksm,
                        'parent_folder' => $id_folder_desa_exist,
                        'id_folder' => $i["path"],
                        'nama_folder' => $i["name"],
                        'path_folder' =>  $path_ksm
                    ]);
                }
            }
        }

        //Folder KSM
        if ($request->jenisDokumen_ksm == 1) {
            $folderDok = 'DOK PERENCANAAN';
        } else if ($request->jenisDokumen_ksm == 2) {
            $folderDok = 'DOK PERENCANAAN';
        } else if ($request->jenisDokumen_ksm == 6) {
            $folderDok = 'DOK PENGADAAN';
        } else if ($request->jenisDokumen_ksm == 7) {
            $folderDok = 'LPJ KEGIATAN';
        } else {
            $folderDok = 'DOK PERSIAPAN';
        }

        $id_folder_ksm_exist = google_folder::where('path_folder', $path_ksm)->get('id_folder')[0]['id_folder'];
        $path_folder_baru = $path_ksm . ' / ' . $folderDok;
        $folder_baru =  $id_folder_ksm_exist . '/' . $folderDok;

        if (google_folder::where('path_folder', $path_folder_baru)->doesntExist()) {
            Storage::disk('google')->makeDirectory($folder_baru);

            $f = Storage::disk('google')->directories($id_folder_ksm_exist);
            $g = count($f);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($f[$x], 34, 33);
                if (google_folder::where('id_folder', $k)->doesntExist()) {
                    $i = Storage::disk('google')->getAdapter()->getMetadata($k);
                    $h = substr($i["path"], 34, 33);
                    $j = substr($i["path"], 0, 33);
                    $google_folder = new google_folder;
                    google_folder::create([
                        'kode_folder' => $namaTahun . $request->ksm_ksm . $folderDok,
                        'parent_folder' => $id_folder_ksm_exist,
                        'id_folder' => $i["path"],
                        'nama_folder' => $i["name"],
                        'path_folder' =>  $path_folder_baru
                    ]);
                }
            }
        }

        $files = $request->file('file_ksm');
        $fileExtension = $files->getClientOriginalExtension();
        $fileSize = $files->getClientSize();

        $DokumenKSM = jenisDokumenksm::where('NO', $request->jenisDokumen_ksm)->get('JenisDokumen')[0]['JenisDokumen'];
        $dokumenisi = $request->macamDokumen_ksm . ' ';
        $newName =  $dokumenisi . $DokumenKSM . ' KSM ' . $request->ksm_ksm . ' KEL ' .  ' ' . $nama_desa . ' ' . $nama_kabupaten;

        if (google_folder::where('path_folder', $path_folder_baru)->exists()) {
            $id_currentfolder = google_folder::where('path_folder', $path_folder_baru)->get('id_folder');
            $savefolder = $id_currentfolder[0]['id_folder'];
            Storage::disk('google')->putFileAs($savefolder, $files, $newName);

            $jmlDokumen = Storage::disk('google')->allFiles($savefolder);

            $g = count($jmlDokumen);

            for ($x = 0; $x < $g; $x++) {
                $k = substr($jmlDokumen[$x], 34, 33);
                if (Document::where('file_id', $k)->doesntExist()) {
                    $document = new document;
                    $document->file_id = $k;
                    $document->file_name = $newName;
                    $document->file_extension =  $fileExtension;
                    $document->file_Size =  $fileSize;
                    $document->tipe_dokumen =  'PDF';
                    $document->uploaded_by =  '-';
                    $document->scope = '-';
                    $document->jenis_dokumen =  $DokumenKSM;
                    $document->kode_kegiatan = '-';
                    $document->kode_kel = $kd_kel;
                    $document->desa = $nama_desa;
                    $document->kecamatan = $kecamatan;
                    $document->kabupaten = $nama_kabupaten;
                    $document->link = 'https://drive.google.com/file/d/' . $k . '/view';
                    $document->save();
                }
            }
        }

        return redirect('/doc');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {

        // return $document;
        // return view('document.folder', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
