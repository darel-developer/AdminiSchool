<!-- filepath: /c:/xampp/htdocs/Adminischool/resources/views/schoolpaiement.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Paiements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #22304f 0%, #34495e 100%);
            color: #ecf0f1;
            border-right: 1px solid #34495e;
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
            font-size: 1.6rem;
            text-align: center;
            color: #ecf0f1;
            margin-bottom: 30px;
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
        .content {
            margin-left: 250px;
            padding: 32px 24px 24px 24px;
            flex-grow: 1;
            min-height: 100vh;
            background: #f4f7fb;
            transition: margin-left 0.3s;
        }
        .table {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.07);
            overflow: hidden;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-primary {
            border-radius: 8px;
            font-weight: 500;
        }
        .alert-success {
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
        /* Overlay for sidebar on mobile */
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
        /* Responsive styles */
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
            .content {
                margin-left: 0;
                padding: 18px 2vw 18px 2vw;
            }
            .sidebar-toggle {
                display: flex;
            }
        }
        @media (max-width: 767.98px) {
            .content {
                padding: 10px 1vw 10px 1vw;
            }
            .sidebar {
                width: 140px;
            }
            .table-responsive {
                overflow-x: auto;
            }
            .table th, .table td {
                font-size: 0.95rem;
                padding: 0.5rem;
            }
        }
        @media (max-width: 575.98px) {
            .sidebar {
                width: 100vw;
                padding: 14px 0;
            }
            .sidebar-title {
                font-size: 1.1rem;
            }
            .sidebar-item {
                font-size: 0.98rem;
                padding: 10px 18px;
            }
            .content {
                padding: 8px 2px 8px 2px;
            }
            .table th, .table td {
                font-size: 0.89rem;
                padding: 0.35rem;
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
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar" id="sidebarMenu">
        <div class="sidebar-title">ADMINISCHOOL</div>
        <a href="{{route('dashboard')}}" class="sidebar-item">
            <img src="{{ asset('images/Statistics.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="{{route('school')}}" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            DONNEES
        </a>
        <a href="{{ route('documentschool') }}" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            Documents
        </a>
        <a href="{{ route('eventschool') }}" class="sidebar-item">
            <img src="{{ asset('images/Event.png') }}" alt="event">
            Evenements
        </a>
        <a href="{{ route('schoolpaiement') }}" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="payment">
            Paiements
        </a>
        
        <a href="{{route('userschool')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="user">
            Utilisateur
        </a>
        <a href="{{route('studentschool')}}" class="sidebar-item">
            <img src="{{ asset('images/action.png') }}" alt="user">
            Etudiant
        </a>
        <a href="{{ route('create.teacher') }}" class="sidebar-item">
            <img src="{{ asset('images/teacher.png') }}" alt="teacher">
            Créer enseignant
        </a>
        <a href="{{ route('cahiertexte') }}" class="sidebar-item">
            <img src="{{ asset('images/Book.png') }}" alt="teacher">
           cahier de texte
        </a>
        <a href="{{ route('helpsupport') }}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="content">
        <div class="container-fluid mt-4">
            <h1 class="mb-4 text-center" style="font-weight:700;letter-spacing:1px;">Liste des Paiements</h1>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Type de Paiement</th>
                            <th>Montant</th>
                            <th>Numéro de Facture</th>
                            <th>État</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paiements as $paiement)
                            <tr>
                                <td>{{ $paiement->nom }}</td>
                                <td>{{ $paiement->prenom }}</td>
                                <td>{{ $paiement->typepaiement }}</td>
                                <td>{{ $paiement->montant }}</td>
                                <td>{{ $paiement->num_facture }}</td>
                                <td>{{ $paiement->etat }}</td>
                                <td>
                                    <a href="{{ route('showpaiement', $paiement->id) }}" class="btn btn-primary">Verifier</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
        sidebarToggle.addEventListener('click', function() {
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
        sidebarOverlay.addEventListener('click', closeSidebar);
        // Close sidebar on navigation (mobile)
        document.querySelectorAll('.sidebar-item').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) closeSidebar();
            });
        });
    </script>
</body>
</html>