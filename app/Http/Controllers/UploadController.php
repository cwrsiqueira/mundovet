<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function imageupload(Request $request) {

        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png'
        ]);
        
        $ext = $request->file->extension();
        $imageName = time().'.'.$ext;

        $request->file->move(public_path('assets/imgs_tinymce'), $imageName);

        return [
            'location' => asset('assets/imgs_tinymce/'.$imageName)
        ];
    }
}
