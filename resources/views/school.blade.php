<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Téléversement des données</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .form-section {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.07);
            padding: 24px 18px;
            margin-bottom: 18px;
        }
        .form-section.active {
            display: block;
            opacity: 1;
        }
        .form-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            font-size: 1.15rem;
        }
        .form-description {
            font-size: 0.97rem;
            color: #6c757d;
            margin-bottom: 15px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 7px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
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
                width: 220px;
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
            .form-section {
                padding: 14px 4px;
            }
            .sidebar {
                width: 180px;
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
            .form-section {
                padding: 10px 2px;
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
            Payments
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
            <h1 id="main-title" class="text-center mb-4" style="font-weight:700;letter-spacing:1px;">Téléversement des données</h1>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <!-- Formulaire pour les élèves -->
                    <div id="form1" class="form-section active">
                    
                    <p class="form-description">
                        Veuillez téléverser un fichier Excel contenant les informations des élèves. Le fichier doit inclure les colonnes suivantes :
                        <strong>name, class, enrollment_date, absences, convocations, warnings</strong>.
                    </p>
                    <form id="uploadStudentForm" method="POST" action="{{ route('student.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="studentFile" class="form-label">Fichier des élèves</label>
                            <input type="file" name="studentFile" id="studentFile" class="form-control" accept=".xlsx, .xls, .csv" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Téléverser</button>
                    </form>
                    <button id="nextBtn" class="btn btn-secondary mt-3">Suivant</button>
                </div>

                <!-- Formulaire pour les classes -->
                <div id="form2" class="form-section">
                    
                    <p class="form-description">
                        Veuillez téléverser un fichier Excel contenant les informations des classes. Le fichier doit inclure la colonne suivante :
                        <strong>name</strong>.
                    </p>
                    <form id="uploadClassForm" method="POST" action="{{ route('classes.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="classFile" class="form-label">Fichier des classes</label>
                            <input type="file" name="classFile" id="classFile" class="form-control" accept=".xlsx, .xls, .csv" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Téléverser</button>
                    </form>
                    <button id="nextBtn2" class="btn btn-secondary mt-3">Suivant</button>
                    <button id="backBtn" class="btn btn-secondary mt-3">Retour</button>
                </div>

                <!-- Formulaire pour le planning -->
                <div id="form3" class="form-section">
                    
                    <p class="form-description">
                        Veuillez téléverser un fichier Excel contenant les informations du planning. Le fichier doit inclure les colonnes suivantes :
                        <strong>class, date, start_time, end_time, code, teacher, room</strong>.
                    </p>
                    <form id="uploadPlanningForm" method="POST" action="{{ route('plannings.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="planningFile" class="form-label">Fichier du planning</label>
                            <input type="file" name="planningFile" id="planningFile" class="form-control" accept=".xlsx, .xls, .csv" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Téléverser</button>
                    </form>
                    <button id="nextBtn3" class="btn btn-secondary mt-3">Suivant</button>
                    <button id="backBtn2" class="btn btn-secondary mt-3">Retour</button>
                </div>

                <!-- Formulaire pour téléverser les bulletins de notes PDF -->
                <div id="form4" class="form-section">
                    <div class="form-header">Téléverser les bulletins de notes (PDF)</div>
                    <p class="form-description">
                        Sélectionnez le dossier contenant tous les bulletins de notes PDF des élèves.<br>
                        Chaque fichier PDF doit être nommé avec le matricule ou l'identifiant unique de l'élève (ex: <b>12345.pdf</b>).
                    </p>
                    <form id="uploadBulletinsForm" method="POST" action="{{ route('bulletins.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="bulletinsFolder" class="form-label">Dossier des bulletins (PDF)</label>
                            <input type="file" name="bulletins[]" id="bulletinsFolder" class="form-control" accept="application/pdf" multiple webkitdirectory directory required>
                            <!-- webkitdirectory permet la sélection de dossier dans Chrome/Edge -->
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sélectionnez les classes concernées :</label><br>
                            @foreach($classes as $class)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="classes[]" id="class_{{ $class->id }}" value="{{ $class->id }}">
                                    <label class="form-check-label" for="class_{{ $class->id }}">{{ $class->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Téléverser les bulletins</button>
                    </form>
                </div>
                <button id="backBtn3" class="btn btn-secondary mt-3">Retour</button>
                
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

        document.getElementById('nextBtn').addEventListener('click', function() {
            document.getElementById('form1').classList.remove('active');
            document.getElementById('form2').classList.add('active');
        });

        document.getElementById('nextBtn2').addEventListener('click', function() {
            document.getElementById('form2').classList.remove('active');
            document.getElementById('form3').classList.add('active');
        });

        document.getElementById('nextBtn3').addEventListener('click', function() {
            document.getElementById('form3').classList.remove('active');
            document.getElementById('form4').classList.add('active');
        });

        document.getElementById('backBtn').addEventListener('click', function() {
            document.getElementById('form2').classList.remove('active');
            document.getElementById('form1').classList.add('active');
        });

        document.getElementById('backBtn2').addEventListener('click', function() {
            document.getElementById('form3').classList.remove('active');
            document.getElementById('form2').classList.add('active');
        });

        document.getElementById('backBtn3').addEventListener('click', function() {
            document.getElementById('form4').classList.remove('active');
            document.getElementById('form3').classList.add('active');
        });
    </script>
</body>
</html>