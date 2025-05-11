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
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }
        .sidebar-title {
            font-family: 'Lemonada', sans-serif;
            font-weight: 600;
            font-size: 1.8rem;
            text-align: center;
            color: #ecf0f1;
            margin-bottom: 20px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: #bdc3c7;
            font-weight: 500;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .sidebar-item:hover {
            background-color: #34495e;
            color: #ecf0f1;
        }
        .sidebar-item img {
            width: 25px;
            height: 25px;
            margin-right: 15px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            background: #fff;
        }
        .form-section {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .form-section.active {
            display: block;
            opacity: 1;
        }
        .form-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-description {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 15px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="sidebar">
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
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Paramètres
        </a>
        <a href="{{ route('helpsupport') }}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>

    <div class="content">
        <div class="container mt-5">
            <h1 id="main-title" class="text-center">Téléversement des données</h1>
            <div class="mt-4">
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
                    <button id="backBtn2" class="btn btn-secondary mt-3">Retour</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('nextBtn').addEventListener('click', function() {
            document.getElementById('form1').classList.remove('active');
            document.getElementById('form2').classList.add('active');
        });

        document.getElementById('nextBtn2').addEventListener('click', function() {
            document.getElementById('form2').classList.remove('active');
            document.getElementById('form3').classList.add('active');
        });

        document.getElementById('backBtn').addEventListener('click', function() {
            document.getElementById('form2').classList.remove('active');
            document.getElementById('form1').classList.add('active');
        });

        document.getElementById('backBtn2').addEventListener('click', function() {
            document.getElementById('form3').classList.remove('active');
            document.getElementById('form2').classList.add('active');
        });
    </script>
</body>
</html>