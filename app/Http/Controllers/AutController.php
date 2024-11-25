<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AutController extends Controller
{
    public function inregistrare(Request $request) {
        $date = $request->validate([
            'name'=>['required', 'min:3', 'max:20'],
            'prenume'=>['required', 'min:3', 'max:20'],
            'email'=>['required', 'email', Rule::unique('users', 'email')],
            'password'=>['required', 'min:8', 'confirmed']
        ]);
        $date['password'] = bcrypt($date['password']);
        $date['functie'] = 'USER';
        $user = User::create($date);
        auth()->login($user);
        return redirect('/')->with('success', 'Contul a fost creat cu succes!');
    }

    public function logare(Request $request) {
        $date = $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if(auth()->attempt(['email' => $date['email'], 'password' => $date['password']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Te-ai logat cu succes!');
        } else {
            return redirect('/logare');
        }
        
    }

    public function delogare() {
        auth()->logout();
        return redirect('/');
    }
}
