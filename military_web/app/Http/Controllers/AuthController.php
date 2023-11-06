<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
 

class AuthController extends Controller
{
    public function registrationView()
    {
        return view('auth/registration');
    }
    public function loginView()
    {
        return view('auth/login');
    }
    public function logout()
    {
        Auth::logout();

        return redirect()->route('welcome');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
    
        if (Auth::attempt($credentials)) {
            return redirect()->route('welcome');
        }
        return redirect()->back()->with('error', 'Неправильна скринька або пароль.');
    }
    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'password' => 'required|string|min:8',
            'password2' => 'required|string|same:password',
        ]);
        
        $existingUser = User::where('email', $request->input('email'))->first();
        if ($existingUser) {
            return redirect()->back()->with('error', 'Користувач з такою електронною скринькою вже існує.');
        }
    
        $user = new User();
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->email = $request->input('email');
    
        $user->save();
    
        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Реєстрація успішна. Тепер авторизуйтесь');
    }
    
}
