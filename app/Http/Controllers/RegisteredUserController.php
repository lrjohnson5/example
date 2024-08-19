<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        // dd('In the store method');

        // validate

        // dd('In the validate portion');

        $attributes = request()->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'max:254'],
            'password' => ['required', 'confirmed'] // checks with password_confirmation column
        ]);

        // dd('assigned attributes');

        // create user
        $user = User::create($attributes);

        // dd($user);

        // log in
        Auth::login($user);

        // redirect

        // dd('redirecting');

       return redirect('/jobs');
    }
}
