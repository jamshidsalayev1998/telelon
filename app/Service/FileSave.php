<?php

namespace App\Service;

class FileSave
{
    public static function storeFile($folder, $file)
    {
        $nameFile = date('Y-m-d').'_'.date('H-i-s');
        $extension = $file->getClientOriginalExtension();
        $nameFile.='.'.$extension;
        $file->move('files/'.$folder,$nameFile);
        return 'files/'.$folder.'/'.$nameFile;
    }
}
