<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UploadedFile;
use SebastianBergmann\Type\NullType;

class UploadController extends Controller
{   

    public function store(Request $request):RedirectResponse
    {
        #checks if the request does have a file indeed. 
        $request->validate([
            'userfile' => 'required|file|max:50000000',
        ]);

        

        $file = $request->file('userfile');     #declaration of file as userfile in request via file method
        $size = $request->file('userfile')->getSize();

        $originalFileName = $file->getClientOriginalName();     #get file name
        $originalFileExtension = $file->getClientOriginalExtension();     #get file extension
        $trueFileName = $originalFileName;     #file name and extension into one variable 


        $user = auth()->user();     #retrieve authenticated user via auth facade, user method
        $username = $user->name;        #get username from the retrieved user

        $id = Auth::user()->id;     #retrieve authenticate user ID via auth facade. Different method than the one above because ID is not existent in the user model. 


        $path = "private/{$username}";      #declaration of file path

        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $originalFileName)) {
            return redirect()->back()->with('error', 'File name contains invalid characters.');
        }

        if (Storage::exists("$path/$trueFileName")) {
            return redirect()->back()->with('error', 'File already exists.');
        }


        Storage::putFileAs($path, $file, $trueFileName);
        #Store in the private disk at $path, the $file, with $trueFileName name.

        $uploadedFile = new UploadedFile();
        $uploadedFile->user_id=$id;
        $uploadedFile->filepath='storage/app/'.$path.'/'.$originalFileName;
        $uploadedFile->filename=$originalFileName;
        $uploadedFile->filetype=$originalFileExtension;
        $uploadedFile->filesize=$size;
        $uploadedFile->save();

        return redirect()->route('dashboard')->with('status', "File `{$uploadedFile->original_name}` uploaded successfully.");

        #Initialization of a new File model. After the initialization we will store the relevant values in the models declared variables.


        #Send the saved data in the newly initiated model to the PGSQL DB for storage.


    }
    //return upload index.
    public function create()
    {
        return view('uploads.create');
    }

    // shows the uploads index
    public function index()
    {
        $uploadedFiles = Auth::user()->files;
        return view('dashboard', compact('uploadedFiles'));
    }

    public function download(UploadedFile $uploadedFile)
{

        // Debug the file atributes...atributes seem ok
        #dd('File attributes', $uploadedFile->toArray());


    if (is_null($uploadedFile->filepath)) {
        return abort(404, '$id');
    }

    $path = $uploadedFile->filepath;

    #main error : not found - file at the given $path : storage/app/private/test1/filename.file does not exist - - IS NULL
    return response()->download($path);

    #return response()->streamDownload(function ()  use ($uploadedFile) {
    #    echo Storage::disk('private')->get($uploadedFile->filepath);
    #s  }, $uploadedFile->filename);

}
}
