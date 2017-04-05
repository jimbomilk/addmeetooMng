<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Request extends FormRequest
{

    public function saveFile($field,$folder)
    {
        if (!isset($field) || $field == '')
            return null;
        $file = $this->file($field);
        $filename = null;
        if (isset($file)) {
            $filename = $folder . '/' . $field . '.' . $file->getClientOriginalExtension();
            Storage::disk('local')->put($filename, File::get($file));
        }

        return $filename;
    }

}
