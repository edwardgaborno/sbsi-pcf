<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryFile;

class FilepondController extends Controller
{
    public function storePCFDocument(Request $request)
    {
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
                $filename =  $file->getClientOriginalName();
                $folder = uniqid() . '-' .now()->timestamp;
                $file->storeAs('pcf_files/tmp/' . $folder, $filename);

                TemporaryFile::create([
                    'folder' => $folder,
                    'file_name' => $filename,
                ]);
                
                return $folder;
        }

        return '';
    }
}
