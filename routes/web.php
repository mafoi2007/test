<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if ($request->session()->get('authenticated') === true) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'login' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if ($credentials['login'] !== 'admin' || $credentials['password'] !== 'admin') {
        return back()
            ->withErrors(['login' => 'Identifiants incorrects.'])
            ->onlyInput('login');
    }

    $request->session()->regenerate();
    $request->session()->put('authenticated', true);

    return redirect()->intended(route('dashboard'));
})->name('login.attempt');

Route::get('/dashboard', function (Request $request) {
    if ($request->session()->get('authenticated') !== true) {
        return redirect()->route('login');
    }

    return view('dashboard');
})->name('dashboard');

Route::post('/logout', function (Request $request) {
    $request->session()->forget('authenticated');
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');
