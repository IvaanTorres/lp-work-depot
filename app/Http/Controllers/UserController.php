<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Termwind\Components\Dd;

class UserController extends Controller
{   
    
    /* ---------------------------------- Auth ---------------------------------- */

    public function show_register(){
        return view('auth.register.index');
    }

    public function register(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'is_teacher' => ['nullable'],
        ]);

        $new_user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->is_teacher
                ? Role::where('value', Roles::Teacher)->first()->id 
                : Role::where('value', Roles::Student)->first()->id,
        ]);
 
        /* Create and log the user in the application */
        Auth::login($new_user);
 
        return redirect()->route('courses_list_page');
    }

    public function show_login(){
        return view('auth.login.index');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        /* Find the user in the database to see if it exists */
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('courses_list_page'));
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login_page')->with('logout_info', 'You have been logged out');
    }
    
}
