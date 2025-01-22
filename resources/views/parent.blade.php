<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                padding-bottom: 80px; /* Espace pour la barre de navigation */
            }
        }

         /* Nouveau conteneur pour le profil */
         .profile-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 20px;
            background-color: 
        }
        .profile-container img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .profile-container .profile-info {
            text-align: right;
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
                padding-bottom: 80px; /* Espace pour la barre de navigation */
            }
        }
    </style>
</head>
<body>
     <!-- Barre de navigation -->
     <div class="sidebar">
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            Document
        </a>
        <a href="{{route('parentpaiement')}}" class="sidebar-item">
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
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>

    <div class="content">
        <h1 id="main-title">Enfant Static</h1>
        <div id="main-content">
            <div class="profile-container">
                <!-- Photo de profil -->
                <img src="" alt="Photo">
                <div class="profile-info">
                    <!-- Nom de l'utilisateur et type de compte -->
                    <h5>{{ Auth::user()->firstName }} {{ Auth::user()->secondName }}</h5>
                    <p> {{ Auth::user()->accountType }}</p>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-outline-primary" onclick="showContent('information')">Information</button>
            <button class="btn btn-outline-primary" onclick="showContent('absence')">Absence</button>
            <button class="btn btn-outline-primary" onclick="showContent('note')">Note</button>
            <button class="btn btn-outline-primary" onclick="showContent('convocation')">Convocation</button>
            <button class="btn btn-outline-primary" onclick="showContent('planning')">Planning</button>
            <button class="btn btn-outline-primary" onclick="showContent('barbillard')">Barbillard</button>
        </div>

        <!-- Sections de contenu -->
        <div id="information" class="content-section">
            <h2>Informations</h2>
            <p>Voici les informations disponibles...</p>
        </div>
        <div id="absence" class="content-section">
            <h2>Absence</h2>
            <p>Gestion des absences ici...</p>
        </div>
        <div id="note" class="content-section">
            <h2>Note</h2>
            <p>Liste des notes ici...</p>
        </div>
        <div id="convocation" class="content-section">
            <h2>Convocation</h2>
            <p>Gestion des convocations ici...</p>
        </div>
        <div id="planning" class="content-section">
            <h2>Planning</h2>
            <p>Planning des activités ici...</p>
        </div>
        <div id="barbillard" class="content-section">
            <h2>Barbillard</h2>
            <p>Informations sur le barbillard ici...</p>
        </div>
    </div>

    <script>
         function showContent(sectionId) {
        // Masquer tous les contenus
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });

        // Afficher le contenu spécifique
        const section = document.getElementById(sectionId);
        if (section) {
            section.classList.add('active');
        }

        // Charger les informations si la section est "information"
        if (sectionId === 'information') {
            fetch("{{ route('student.info') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const student = data.data;
                        const infoContent = `
                            <h2>Informations</h2>
                            <p><strong>Nom:</strong> ${student.name}</p>
                            <p><strong>Classe:</strong> ${student.class}</p>
                            <p><strong>Date d'inscription:</strong> ${student.enrollment_date}</p>
                            <p><strong>Absences:</strong> ${student.absences}</p>
                            <p><strong>Convocations:</strong> ${student.convocations}</p>
                            <p><strong>Avertissements:</strong> ${student.warnings}</p>
                        `;
                        section.innerHTML = infoContent;
                    } else {
                        section.innerHTML = `<p>${data.message}</p>`;
                    }
                })
                .catch(error => {
                    section.innerHTML = `<p>Erreur lors du chargement des données.</p>`;
                    console.error('Erreur:', error);
                });
        }
    }
    </script>
</body>
</html>
