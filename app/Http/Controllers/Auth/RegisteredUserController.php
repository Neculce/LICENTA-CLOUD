<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    //Show Reg.view
    public function create(): View
    {
        return view('auth.register');
    }
    /**
     * Handle an incoming registration request.
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            #validate name : input, max25, only contains alphanumericals and dashes, unique name (checks with database tables to ensure this)
            'name' => ['required', 'string', 'max:255', 'unique:'.User::class],
            #validate email input : all lowercase, unique (checks with database tables to ensure uniqueness)
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            #validate password : passwords must be confirmed and use rules defined in Rules via defaults method.
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        #Creates user's directory at storage/user_files/usernames
        $username = $user->name; // assuming you have a 'username' field in your User model
        $path = "private/{$username}";

        Storage::makeDirectory($path);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
