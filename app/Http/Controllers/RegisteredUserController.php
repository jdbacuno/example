<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        if (Auth::check()) return redirect('/');
        return view('auth.register');
    }

    public function store()
    {
        // dd('todo!');
        // dd(request()->all());

        // validate
        $validateAttributes = request()->validate([
            'first_name' => ['required'], // ['min:6'] -> means, minimum of 6 chars
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', Password::min(6)->letters()->numbers(), 'confirmed'], // password_confirmation
        ]);

        // dd($validateAttributes);

        // create the user
        $user = User::create($validateAttributes);

        // log in
        // Auth::login($user); 
        // redirect somewhere
        // return redirect('/jobs');

        // or instead of loggin in and redirecting somewhere
        // redirect back to the form with a success message
        return redirect('/register')->with('success', 'Successfully registered! You may now log in.');
    }
}
