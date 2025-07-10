<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('users.login');
    }
    public function showRegister()
    {
        return view('users.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'min:3', 'unique:users'],
            'password' => ['required', 'min:3', 'confirmed'],
        ], [
            'name.required' => 'Поле "Имя" обязательно для заполнения',
            'name.min' => 'Имя должно содержать минимум :min символа',
            'email.required' => 'Поле "Email" обязательно для заполнения',
            'email.email' => 'Введите корректный email адрес',
            'email.min' => 'Email должен содержать минимум :min символа',
            'email.unique' => 'Этот email уже зарегистрирован',
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
            'password.min' => 'Пароль должен содержать минимум :min символа',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('showLogin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'min:3'],
            'password' => ['required', 'min:3'],
        ], [
            'email.required' => 'Поле Email обязательно для заполнения',
            'email.email' => 'Введите корректный email адрес',
            'email.min' => 'Email должен содержать минимум :min символа',
            'password.required' => 'Поле Пароль обязательно для заполнения',
            'password.min' => 'Пароль должен содержать минимум :min символа',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Пользователь с такими данными не найден',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('home');
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);

        if (Auth::check() && Auth::id() == $user->id) {
            return view('users.profile', compact('user'));
        }

        return redirect()->route('home')->with('error', 'Вы можете просматривать только свой профиль');
    }
}
