<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tableau de bord</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 font-sans text-white antialiased">
    <main class="flex min-h-screen items-center justify-center px-6 py-12">
        <section class="w-full max-w-2xl rounded-3xl bg-white/10 p-8 text-center shadow-2xl ring-1 ring-white/15 backdrop-blur">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-indigo-300">Authentifié</p>
            <h1 class="mt-3 text-4xl font-bold">Bienvenue, admin</h1>
            <p class="mt-4 text-slate-300">Vous êtes connecté à l'espace sécurisé.</p>

            <form method="POST" action="{{ route('logout') }}" class="mt-8">
                @csrf
                <button type="submit" class="rounded-2xl bg-white px-5 py-3 font-semibold text-slate-950 transition hover:bg-indigo-100 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                    Se déconnecter
                </button>
            </form>
        </section>
    </main>
</body>
</html>
