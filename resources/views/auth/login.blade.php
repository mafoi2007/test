<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Authentification</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-900 antialiased">
    <main class="flex min-h-screen items-center justify-center px-6 py-12">
        <section class="w-full max-w-md rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-200">
            <div class="mb-8 text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-indigo-600">Espace sécurisé</p>
                <h1 class="mt-3 text-3xl font-bold text-slate-950">Connexion</h1>
                <p class="mt-2 text-sm text-slate-600">Saisissez votre login et votre mot de passe.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="login" class="block text-sm font-medium text-slate-700">Login</label>
                    <input
                        id="login"
                        name="login"
                        type="text"
                        value="{{ old('login') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="mt-2 block w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-950 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="mt-2 block w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-950 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                    >
                </div>

                <button type="submit" class="w-full rounded-2xl bg-indigo-600 px-4 py-3 font-semibold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                    Se connecter
                </button>
            </form>

            <p class="mt-6 rounded-2xl bg-slate-50 px-4 py-3 text-center text-sm text-slate-600">
                Identifiants par défaut : <strong>admin</strong> / <strong>admin</strong>
            </p>
        </section>
    </main>
</body>
</html>
