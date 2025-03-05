<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        if (Auth::check()) return redirect('/');
        return view('auth.login');
    }

    public function store()
    {
        // dd('todo!');
        // dd(request()->all());

        // validate
        $validateAttributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // attempt to login the user
        // can add a 2nd argument "true" to keep remembering the user
        if (!Auth::attempt($validateAttributes)) {
            // from Illuminate\Validation\ValidationException
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match'
            ]);
        }

        // regenerate the session token
        request()->session()->regenerate();

        return redirect('/');
    }

    public function destroy()
    {
        // dd('log the user out');
        Auth::logout(); // destroys the session of the currently authenticated user

        return redirect('/login');
    }
}
