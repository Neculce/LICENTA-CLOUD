<?php

namespace App\Http\Controllers;

use App\Models\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadFile extends Controller
{
    public function download(UploadedFile $file)
{
    return response()->streamDownload(function () use ($file) {
      echo Storage::disk('files')->get($file->path);
    }, $file->original_name);
  }
}
