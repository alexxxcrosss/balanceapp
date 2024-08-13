<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Форма входа
     *
     * @return void
     */
    public function form()
    {
        return inertia('Auth/Login');
    }

    /**
     * Авторизация пользователя
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('index');
        }

        return back()->withErrors(['login' => 'Неправильный логин или пароль ']);
    }

    /**
     * Выход
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); 
    }
}
