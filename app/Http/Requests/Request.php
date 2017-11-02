<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
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
            $filename = $folder . '/' . $field .Carbon::now(). '.' . $file->getClientOriginalExtension();
            //Log::info('Filename:'.$filename);
            if (Storage::disk('s3')->put($filename, File::get($file),'public'))
                return Storage::disk('s3')->url($filename);

        }

        if ($this->input($field) == "")
            return "";
        return null;
    }



}
