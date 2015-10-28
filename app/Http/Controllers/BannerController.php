<?php

namespace APOSite\Http\Controllers;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Config;

class ImageController extends Controller
{

    public function storeImage(UploadedFile $file)
    {
        //Assign a new file name
        $filename = md5(time().$file->getClientOriginalName());
        $file->move(Config::get('assets.images'),$filename);
        return $filename;
    }
}
