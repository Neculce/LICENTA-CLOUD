<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UploadedFile;
use SebastianBergmann\Type\NullType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{

    public function store(Request $request): RedirectResponse
    {
        #checks if the request does have a file indeed. 
        $request->validate([
            'userfile' => 'required|file',
        ]);

        //Declaration of file as userfile and size via file method
        $file = $request->file('userfile');
        $size = $request->file('userfile')->getSize();

        //Declaration of trueFileName. Composed of the filename and extension via file methods. 
        $originalFileName = $file->getClientOriginalName();
        $originalFileExtension = $file->getClientOriginalExtension();
        $trueFileName = $originalFileName;

        //Retrieve authenticate user, username and ID
        $user = auth()->user();
        $username = $user->name;
        $id = Auth::user()->id;   //Method differs due to ID not being present in the $user model. Eloquent fault

        $path = "private/{$username}";      #declaration of file path

        //Filename validation code to protect against malicious execution of filenames.
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $originalFileName)) {
            return redirect()->back()->with('error', 'File name contains invalid characters.');
        }

        //Check if the file already exists, if it does return error and aborts.
        if (Storage::exists("$path/$trueFileName")) {
            return redirect()->back()->with('error', 'File already exists.');
        }

        #Store in the private disk at $path, the $file, with $trueFileName name.
        Storage::putFileAs($path, $file, $trueFileName);

        #Initialization of a new File model. After the initialization we will store the relevant values in the models declared variables.
        #Send the saved data in the newly initiated model to the PGSQL DB for storage.

        $uploadedFile = new UploadedFile();
        $uploadedFile->user_id = $id;
        $uploadedFile->filepath = '/app/' . $path . '/' . $originalFileName;
        $uploadedFile->filename = $originalFileName;
        $uploadedFile->filetype = $originalFileExtension;
        $uploadedFile->filesize = $size;
        $uploadedFile->save();

        return redirect()->route('dashboard')->with('status', "File `{$uploadedFile->original_name}` uploaded successfully.");
    }

    public function create()
    {   //Return upload index
        return view('uploads.create');
    }

    public function index()
    {   //Send models in relation to authenticate user to upload index
        $uploadedFiles = Auth::user()->files;
        return view('dashboard', compact('uploadedFiles'));
    }

    public function download(UploadedFile $uploadedFile)
    {
        // Debug the file atributes...atributes seem ok
        // dd('File attributes', $uploadedFile->toArray());

        if (is_null($uploadedFile->filepath)) {
            return abort(404, 'File was not found or does not exist');
        }

        $path = $uploadedFile->filepath;
        if ($uploadedFile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        #return a forcefull file download as a response to the http request
        return response()->download(storage_path($path));

        #return response()->streamDownload(function ()  use ($uploadedFile) {
        #    echo Storage::disk('private')->get($uploadedFile->filepath);
        #}, $uploadedFile->filename);

    }

    public function delete(UploadedFile $uploadedFile)
    {
        // Retrieve file ID and name
        $name = $uploadedFile->filename; // Assuming 'filename' is the column name
        $filepath = $uploadedFile->filepath;

        // Check if the file exists
        if ($uploadedFile) {
            // Attempt to delete the file
            try {
                $uploadedFile->delete();
                
                if(Storage::exists($filepath))
                {Storage::delete($filepath);}
                else{
                    return redirect()->route('dashboard')->with('status', "File deleted from DB but not from storage");
 
                }

                return redirect()->route('dashboard')->with('status', "File `{$name}` deleted successfully.");
            } catch (\Exception $e) {
                return redirect()->route('dashboard')->with('status', "Error deleting file: " . $e->getMessage());
            }
        } else {
            return redirect()->route('dashboard')->with('status', "We encountered an error during the deletion of the file.");
        }
    }
}
