<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Paiements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            background: #f4f7fb;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #22304f 0%, #34495e 100%);
            color: #ecf0f1;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.08);
            z-index: 1050;
            transition: transform 0.3s ease;
        }
        .sidebar-title {
            font-family: 'Lemonada', cursive;
            font-weight: 700;
            font-size: 1.4rem;
            text-align: center;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 12px 28px;
            text-decoration: none;
            color: #bdc3c7;
            font-weight: 500;
            border-radius: 8px;
            margin: 4px 12px;
            transition: background 0.2s, color 0.2s;
            font-size: 1.07rem;
        }
        .sidebar-item:hover, .sidebar-item.active {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .sidebar-item img {
            width: 26px;
            height: 26px;
            margin-right: 14px;
        }
        .container {
            max-width: 1100px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.07);
            padding: 32px 24px;
            margin-top: 40px;
        }
        .paiement-card {
            background: #f6f8fc;
            border: 1.5px solid #e3e6ed;
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            transition: box-shadow 0.2s, border 0.2s;
        }
        .paiement-card:hover {
            box-shadow: 0 8px 28px rgba(0,0,0,0.13);
            border-color: #b3c0d1;
        }
        .btn-success, .btn-primary, .btn-outline-primary, .btn-secondary {
            border-radius: 8px;
            font-weight: 500;
        }
        .alert {
            border-radius: 8px;
        }
        /* Hamburger menu */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 18px;
            left: 18px;
            z-index: 1100;
            background: #22304f;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px rgba(44,62,80,0.13);
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(44,62,80,0.25);
            z-index: 1049;
        }
        .sidebar.open ~ .sidebar-overlay {
            display: block;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                width: 180px;
                z-index: 1050;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .container {
                padding: 18px 2vw;
                margin-top: 24px;
            }
            .sidebar-toggle {
                display: flex;
            }
        }
        @media (max-width: 767.98px) {
            .container {
                padding: 10px 1vw;
                margin-top: 16px;
            }
            .sidebar {
                width: 140px;
            }
            .paiement-card {
                padding: 8px 2px;
            }
        }
        @media (max-width: 575.98px) {
            .sidebar {
                width: 100vw;
                padding: 8px 0;
            }
            .sidebar-title {
                font-size: 1.1rem;
            }
            .sidebar-item {
                font-size: 0.98rem;
                padding: 10px 18px;
            }
            .container {
                padding: 8px 2px;
                margin-top: 8px;
            }
        }
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
        }
    </style>
</head>
<body>
    <!-- Hamburger menu button -->
    <!--<button class="sidebar-toggle" id="sidebarToggle" aria-label="Menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar" id="sidebarMenu">
        <div class="sidebar-title">ADMINISCHOOL</div>
        - ...sidebar items if needed... -
    </div>-->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="container mt-5">
        <h1 class="mb-4 text-center" style="font-weight:700;letter-spacing:1px;">Liste des Paiements</h1>
        <div class="row g-4">
            @foreach($paiements as $paiement)
                <div class="col-md-6 col-lg-4">
                    <div class="card paiement-card shadow-sm border-0 h-100" style="position: relative;">
                        <div class="card-body pb-2 pt-3" style="position: relative;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="fw-bold text-primary" style="font-size: 1.1rem;">
                                        {{ $paiement->typepaiement }}
                                    </div>
                                    <div class="text-success" style="font-size: 1.3rem; font-weight: bold;">
                                        {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                                    </div>
                                </div>
                                <a href="{{ route('paiement.download', $paiement->id) }}" class="btn btn-success btn-sm" style="border-radius: 8px;">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-secondary">Facture N° {{ $paiement->num_facture }}</span>
                            </div>
                            <a href="{{ route('paiement.facture', $paiement->id) }}" class="btn btn-outline-primary btn-sm mb-2" target="_blank">
                                Voir la Facture
                            </a>
                        </div>
                        <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-end" style="border-radius: 0 0 18px 18px;">
                            <div>
                                <span class="fw-bold">{{ $paiement->nom }} {{ $paiement->prenom }}</span>
                            </div>
                            <div>
                                <span class="badge {{ $paiement->etat == 'Payé' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $paiement->etat }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="javascript:history.back()" class="btn btn-primary mt-4">Retour</a>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
        // Sidebar toggle for mobile/tablet
        const sidebar = document.getElementById('sidebarMenu');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.style.display = 'none';
        }
        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.style.display = 'block';
        }
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }
        // Close sidebar on navigation (mobile)
        document.querySelectorAll('.sidebar-item').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) closeSidebar();
            });
        });
    </script>
</body>
</html>