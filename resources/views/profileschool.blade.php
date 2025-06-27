<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil du Tuteur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            background-color: #f4f7fb;
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
        .content {
            margin-left: 250px;
            flex-grow: 1;
            padding: 32px 24px 24px 24px;
            background: #fff;
            min-height: 100vh;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.07);
            max-width: 900px;
            margin: 40px auto 0 auto;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.07);
        }
        .card-header {
            border-bottom: 2px solid #ddd;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary, .btn-warning, .btn-sm {
            border-radius: 8px;
            font-weight: 500;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table thead {
            background-color: #343a40;
            color: white;
        }
        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tbody tr:hover {
            background-color: #e9ecef;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
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
                margin-top: 24px;
            }
            .sidebar-toggle {
                display: flex;
            }
        }
        @media (max-width: 767.98px) {
            .content {
                padding: 10px 1vw 10px 1vw;
                margin-top: 16px;
            }
            .sidebar {
                width: 140px;
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
            .content {
                padding: 8px 2px 8px 2px;
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
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar" id="sidebarMenu">
        <div class="sidebar-title">ADMINISCHOOL</div>
        <!-- Ajoutez ici les liens du menu si besoin -->
        <a href="{{route('parent')}}" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="{{route('parentdocument')}}" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            Document
        </a>
        <a href="{{route('parentpaiement')}}" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="paiement">
            Paiement
        </a>
        <a href="{{route('parentchat')}}" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Messagerie
        </a>
        <a href="{{ route('notifications.page') }}" class="sidebar-item">
            <img src="{{ asset('images/notification.png') }}" alt="notification">
            Notification
        </a>
        <a href="{{route('parentchild')}}" class="sidebar-item">
            <img src="{{ asset('images/Add_User.png') }}" alt="enfant">
            Ajouter Enfant
        </a>
        <a href="{{route('profileschool')}}" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Paramètres
        </a>
        <a href="{{route('helpsupport')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="content">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h1>Profil du Tuteur</h1>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('tuteur.updateProfile') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ $tuteur->nom }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $tuteur->prenom }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $tuteur->email }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">Numéro de Téléphone</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $tuteur->phone_number }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
                </form>

                <h2 class="mt-5 text-center">Enfants Associés</h2>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Classe</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->class }}</td>
                                <td>{{ $student->enrollment_date }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editChild({{ $student->id }}, '{{ $student->name }}', '{{ $student->class }}')">Modifier</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Formulaire de modification des données de l'enfant -->
                <div id="editChildFormContainer" class="mt-5" style="display: none;">
                    <h2>Modifier les données de l'enfant</h2>
                    <form id="editChildForm" method="POST">
                        @csrf
                        <input type="hidden" id="childId" name="child_id">
                        <div class="mb-3">
                            <label for="childName" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="childName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="childClass" class="form-label">Classe</label>
                            <select class="form-control" id="childClass" name="class_id" required>
                                @foreach($classes as $class)
                                    <option value="{{ $class->name }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="submitEditChildForm()">Mettre à jour</button>
                    </form>
                </div>

                <script>
                    function editChild(id, name, className) {
                        document.getElementById('editChildFormContainer').style.display = 'block';
                        document.getElementById('childId').value = id;
                        document.getElementById('childName').value = name;
                        document.getElementById('childClass').value = className;
                    }

                    function submitEditChildForm() {
                        const form = document.getElementById('editChildForm');
                        const formData = new FormData(form);
                        const childId = document.getElementById('childId').value;

                        fetch(`/child/update/${childId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Données mises à jour avec succès.');
                                location.reload(); // Reload the page to reflect changes
                            } else {
                                alert('Erreur lors de la mise à jour des données.');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la mise à jour des données :', error);
                        });
                    }
                </script>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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