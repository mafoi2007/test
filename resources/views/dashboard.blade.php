<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tableau de bord | {{ strtoupper($userType) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-body-tertiary">
    @php
        $label = strtoupper($userType);
        $navigation = [
            ['label' => 'Vue d\'ensemble', 'active' => true],
            ['label' => 'Utilisateurs', 'active' => false],
            ['label' => 'Rapports', 'active' => false],
            ['label' => 'Paramètres', 'active' => false],
        ];
        $stats = [
            ['label' => 'Dossiers actifs', 'value' => '128', 'trend' => '+12%', 'variant' => 'primary'],
            ['label' => 'Tâches terminées', 'value' => '84', 'trend' => '+8%', 'variant' => 'success'],
            ['label' => 'Alertes ouvertes', 'value' => '7', 'trend' => '-3%', 'variant' => 'warning'],
        ];
    @endphp

    <div class="dashboard-shell d-flex min-vh-100">
        <aside class="sidebar bg-dark text-white d-none d-lg-flex flex-column p-4">
            <a href="{{ route($userType.'.dashboard') }}" class="brand d-flex align-items-center gap-3 mb-5 text-white text-decoration-none">
                <span class="brand-mark rounded-4 d-inline-flex align-items-center justify-content-center fw-bold">{{ substr($label, 0, 1) }}</span>
                <span>
                    <span class="d-block fw-bold fs-5">Espace {{ $label }}</span>
                    <small class="text-white-50">Console de gestion</small>
                </span>
            </a>

            <nav class="nav nav-pills flex-column gap-2">
                @foreach ($navigation as $item)
                    <a class="nav-link d-flex align-items-center gap-3 {{ $item['active'] ? 'active' : 'text-white-50' }}" href="#">
                        <span class="nav-dot"></span>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto rounded-4 bg-white bg-opacity-10 p-3">
                <p class="mb-1 fw-semibold">Besoin d'aide ?</p>
                <small class="text-white-50">Consultez les rapports ou contactez le support interne.</small>
            </div>
        </aside>

        <div class="flex-grow-1">
            <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top shadow-sm">
                <div class="container-fluid px-4">
                    <button class="btn btn-outline-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-label="Ouvrir le menu">
                        ☰
                    </button>
                    <div class="ms-3 ms-lg-0">
                        <span class="navbar-brand mb-0 h1 fw-bold">Tableau de bord</span>
                        <span class="badge rounded-pill text-bg-primary">{{ $label }}</span>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-3">
                        <div class="d-none d-md-block text-end">
                            <span class="d-block fw-semibold">Bienvenue, {{ $label }}</span>
                            <small class="text-muted">Session sécurisée</small>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-dark rounded-pill px-4">Se déconnecter</button>
                        </form>
                    </div>
                </div>
            </nav>

            <main class="container-fluid p-4 p-xl-5">
                <section class="hero-card rounded-5 p-4 p-lg-5 mb-4 text-white shadow-lg">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <p class="text-uppercase fw-semibold letter-spaced mb-2">Pilotage moderne</p>
                            <h1 class="display-6 fw-bold mb-3">Suivez les indicateurs clés de l'espace {{ $label }} en temps réel.</h1>
                            <p class="lead mb-0 text-white-75">Une interface Bootstrap claire avec Navbar, Sidebar, cartes statistiques et activités récentes.</p>
                        </div>
                        <div class="col-lg-4">
                            <div class="bg-white bg-opacity-10 rounded-4 p-4 backdrop-blur">
                                <span class="text-white-50">Performance globale</span>
                                <div class="d-flex align-items-end gap-2 mt-2">
                                    <strong class="display-5">92%</strong>
                                    <span class="badge text-bg-success mb-3">+5%</span>
                                </div>
                                <div class="progress bg-white bg-opacity-25" role="progressbar" aria-label="Performance globale" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-success" style="width: 92%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="row g-4 mb-4">
                    @foreach ($stats as $stat)
                        <div class="col-md-4">
                            <article class="card border-0 shadow-sm h-100 rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="text-muted mb-1">{{ $stat['label'] }}</p>
                                            <h2 class="fw-bold mb-0">{{ $stat['value'] }}</h2>
                                        </div>
                                        <span class="badge rounded-pill text-bg-{{ $stat['variant'] }}">{{ $stat['trend'] }}</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                <div class="row g-4">
                    <div class="col-xl-8">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white border-0 p-4">
                                <h2 class="h5 fw-bold mb-0">Activité récente</h2>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr><th>Projet</th><th>Responsable</th><th>Statut</th><th>Échéance</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Audit qualité</td><td>Équipe {{ $label }}</td><td><span class="badge text-bg-success">Validé</span></td><td>Aujourd'hui</td></tr>
                                        <tr><td>Suivi opérationnel</td><td>Coordination</td><td><span class="badge text-bg-primary">En cours</span></td><td>Cette semaine</td></tr>
                                        <tr><td>Rapport mensuel</td><td>Direction</td><td><span class="badge text-bg-warning">À relire</span></td><td>Fin du mois</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h2 class="h5 fw-bold mb-3">Priorités</h2>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item px-0 d-flex justify-content-between"><span>Synchroniser les équipes</span><span class="badge text-bg-info">Nouveau</span></div>
                                    <div class="list-group-item px-0 d-flex justify-content-between"><span>Mettre à jour les données</span><span class="badge text-bg-secondary">Planifié</span></div>
                                    <div class="list-group-item px-0 d-flex justify-content-between"><span>Partager le bilan</span><span class="badge text-bg-dark">Important</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">Espace {{ $label }}</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="nav nav-pills flex-column gap-2">
                @foreach ($navigation as $item)
                    <a class="nav-link {{ $item['active'] ? 'active' : 'text-white-50' }}" href="#">{{ $item['label'] }}</a>
                @endforeach
            </nav>
        </div>
    </div>
</body>
</html>
