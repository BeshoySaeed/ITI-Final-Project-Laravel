<?php

namespace App\Traits;

Trait  SaveFile
{

    public function SaveImage($path,$image){
        $uploadpath = $path;
        $fileimage=$image;
        $extension = $fileimage->getClientOriginalExtension();
        $filename = time().$fileimage->getClientOriginalName(). '.' . $extension;
        $fileimage->move($uploadpath, $filename);
        return $filename;
    }

    public function SaveFile($path,$file){
        $uploadpath = $path;
        $fileimage=$file;
        $extension = $fileimage->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $fileimage->move($uploadpath, $filename);
        return $filename;
    }

}