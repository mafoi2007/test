<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$userTypes = ['admin', 'cell', 'prof', 'eco'];

$profPages = [
    'note' => 'Note',
    'stat' => 'Stat',
];

Route::get('/', function (Request $request) {
    $userType = $request->session()->get('user_type');

    if ($request->session()->get('authenticated') === true && is_string($userType)) {
        return redirect()->route($userType.'.dashboard');
    }

    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) use ($userTypes) {
    $credentials = $request->validate([
        'login' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $userType = strtolower($credentials['login']);

    if (! in_array($userType, $userTypes, true) || $credentials['password'] !== $userType) {
        return back()
            ->withErrors(['login' => 'Identifiants incorrects.'])
            ->onlyInput('login');
    }

    $request->session()->regenerate();
    $request->session()->put('authenticated', true);
    $request->session()->put('user_type', $userType);

    return redirect()->intended(route($userType.'.dashboard'));
})->name('login.attempt');

foreach ($userTypes as $userType) {
    Route::get('/'.$userType.'/dashboard', function (Request $request) use ($userType) {
        if ($request->session()->get('authenticated') !== true) {
            return redirect()->route('login');
        }

        $authenticatedUserType = $request->session()->get('user_type');

        if (! is_string($authenticatedUserType)) {
            return redirect()->route('login');
        }

        if ($authenticatedUserType !== $userType) {
            return redirect()->route($authenticatedUserType.'.dashboard');
        }

         return view('dashboard', ['userType' => $userType, 'activePage' => 'dashboard']);
    })->name($userType.'.dashboard');
}

foreach ($profPages as $page => $title) {
    Route::get('/prof/'.$page, function (Request $request) use ($page, $title) {
        if ($request->session()->get('authenticated') !== true) {
            return redirect()->route('login');
        }

        $authenticatedUserType = $request->session()->get('user_type');

        if (! is_string($authenticatedUserType)) {
            return redirect()->route('login');
        }

        if ($authenticatedUserType !== 'prof') {
            return redirect()->route($authenticatedUserType.'.dashboard');
        }

        return view('dashboard', [
            'userType' => 'prof',
            'activePage' => $page,
            'pageTitle' => $title,
        ]);
    })->name('prof.'.$page);
}

Route::get('/dashboard', function (Request $request) {
     $userType = $request->session()->get('user_type');

    if ($request->session()->get('authenticated') !== true || ! is_string($userType)) {
        return redirect()->route('login');
    }

    return redirect()->route($userType.'.dashboard');
})->name('dashboard');

Route::post('/logout', function (Request $request) {
    $request->session()->forget(['authenticated', 'user_type']);
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');
