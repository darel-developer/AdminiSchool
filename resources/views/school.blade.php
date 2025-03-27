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
            background: linear-gradient(135deg, #ee7724, #d8363a, #dd3675, #b44593);
            color: #fff;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .sidebar-item img {
            width: 30px;
            height: 30px;
            margin-right: 15px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            background: #fff;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }

        /* Styles personnalisés */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #ee7724, #d8363a, #dd3675, #b44593);
            border-right: 1px solid #ddd;
            color: #fff;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            margin: 5px 0;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }
        .sidebar-item img {
            width: 30px;
            height: 30px;
            margin-right: 15px;
        }
        .content {
            margin-left: 250px;
            flex-grow: 1;
            padding: 20px;
            background: #fff;
        }
        .content h1 {
            color: #333;
        }

        /* Styles pour les petits écrans */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: 60px;
                flex-direction: row;
                justify-content: space-around;
                padding: 0;
                border-right: none;
                border-top: 1px solid #ddd;
                position: fixed;
                bottom: 0;
                left: 0;
            }
            .sidebar-item {
                flex-direction: column;
                align-items: center;
                padding: 5px;
                font-size: 12px;
            }
            .sidebar-item img {
                margin-right: 0;
                margin-bottom: 5px;
            }
            .content {
                margin: 0;
                padding-bottom: 80px; 
            }
        }

        /* Animation pour les formulaires */
        .form-section {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .form-section.active {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="{{route('documentschool')}}" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            Document
        </a>
        <a href="{{route('eventschool')}}" class="sidebar-item">
            <img src="{{ asset('images/Event.png') }}" alt="document">
            Evenement
        </a>
        <a href="{{route('schoolpaiement')}}" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="paiement">
            Paiement
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Settings
        </a>
        <a href="{{route('helpsupport')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
        <a href="{{route('userschool')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="user">
            Users
        </a>
        <a href="{{route('studentschool')}}" class="sidebar-item">
            <img src="{{ asset('images/action.png') }}" alt="user">
            student
        </a>
        <a href="{{ route('create.teacher') }}" class="sidebar-item">
            <img src="{{ asset('images/teacher.png') }}" alt="teacher">
            Create Teacher
        </a>
    </div>

    <div class="content">
        <div class="container mt-5">
            <h1 id="main-title">Téléversement des données</h1>
            <div class="mt-4">
                <div id="form1" class="form-section active">
                    <form id="uploadStudentForm" method="POST" action="{{ route('student.upload') }}" enctype="multipart/form-data">
                        @csrf <!-- Token de sécurité pour Laravel -->
                        <div class="mb-3">
                            <label for="studentFile" class="form-label">Sélectionnez un fichier (Excel, TXT, CSV)</label>
                            <input type="file" name="studentFile" id="studentFile" class="form-control" accept=".xlsx, .xls, .csv, .txt" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Téléverser</button>
                    </form>
                    <button id="nextBtn" class="btn btn-secondary mt-3">Next</button>
                </div>
                <div id="form2" class="form-section">
                    <form id="uploadClassForm" method="POST" action="{{ route('classes.upload') }}" enctype="multipart/form-data">
                        @csrf <!-- Token de sécurité pour Laravel -->
                        <div class="mb-3">
                            <label for="classFile" class="form-label">Sélectionnez un fichier classe (Excel, TXT, CSV)</label>
                            <input type="file" name="classFile" id="classFile" class="form-control" accept=".xlsx, .xls, .csv, .txt" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Téléverser</button>
                    </form>
                    <button id="nextBtn2" class="btn btn-secondary mt-3">Next</button>
                    <button id="backBtn" class="btn btn-secondary mt-3">Back</button>
                </div>
                <div id="form3" class="form-section">
                    <form id="uploadPlanningForm" method="POST" action="{{ route('plannings.upload') }}" enctype="multipart/form-data">
                        @csrf <!-- Token de sécurité pour Laravel -->
                        <div class="mb-3">
                            <label for="planningFile" class="form-label">Sélectionnez un fichier planning (Excel, TXT, CSV)</label>
                            <input type="file" name="planningFile" id="planningFile" class="form-control" accept=".xlsx, .xls, .csv, .txt" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Téléverser</button>
                    </form>
                    <button id="backBtn2" class="btn btn-secondary mt-3">Back</button>
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