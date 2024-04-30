    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;


    class UserFileStore extends Controller
    {

        public function storeas(Request $request)
    {
        $request->validate([
            'user_file' => 'required|file|max:5000',
        ]);

        $user = auth()->user();
        $username = $user->username;

        $user_file = Storage::disk( name : 'private')->putFileAs( path:'/'.$username, $request->file( key: 'user_file'));
    }
    }


