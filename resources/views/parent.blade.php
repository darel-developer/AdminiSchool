<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #ee7724, #d8363a, #dd3675, #b44593);
            color: #fff;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 10px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
     <!-- Barre de navigation -->
     <div class="sidebar">
        <a href="{{route('parent')}}" class="sidebar-item">
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
        <a href="{{route('parentchat')}}" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/notification.png') }}" alt="help support">
            notification
        </a>
        <a href="{{route('parentchild')}}" class="sidebar-item">
            <img src="{{ asset('images/notification.png') }}" alt="help support">
            add enfant
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

    <!-- Content -->
    <div class="content">
        <h1>Données de l'enfant</h1>
        <div id="main-content">
            <!-- Les informations de l'enfant s'afficheront ici -->
        </div>

        <div class="mt-4">
            <button class="btn btn-outline-primary" onclick="loadChildData('information')">Information</button>
            <button class="btn btn-outline-primary" onclick="loadChildData('absence')">Absence</button>
            <button class="btn btn-outline-primary" onclick="loadChildData('note')">Note</button>
            <button class="btn btn-outline-primary" onclick="loadChildData('convocation')">Convocation</button>
            <button class="btn btn-outline-primary" onclick="loadChildData('planning')">Planning</button>
            <button class="btn btn-outline-primary" onclick="loadChildData('barbillard')">Barbillard</button>
        </div>
    </div>

    <script>
        function loadChildData(section) {
    // Récupérer le nom de l'enfant associé au tuteur connecté
    const childName = '{{ auth()->guard('tuteur')->user()->childName ?? '' }}'; 

    if (!childName) {
        alert('Aucun enfant associé à cet utilisateur.');
        return;
    }

    fetch(`/child/${section}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const content = document.getElementById('main-content');
                let htmlContent = '';

                switch (section) {
                    case 'information':
                        htmlContent = `
                            <h2>Informations</h2>
                            <p>Nom : ${data.data.name}</p>
                            <p>Classe : ${data.data.class}</p>
                            <p>Date d'inscription : ${data.data.enrollment_date}</p>
                            <p>Absences : ${data.data.absences}</p>
                            <p>Convocations : ${data.data.convocations}</p>
                            <p>Warings : ${data.data.warnings}</p>
                        `;
                        break;
                    case 'absence':
                        htmlContent = `
                            <h2>Absences</h2>
                            <p>Nombre d'absences : ${data.data.absences}</p>
                        `;
                        break;
                    case 'note':
                        htmlContent = `
                            <h2>Notes</h2>
                            <p>Les notes seront affichées ici...</p>
                        `;
                        break;
                    case 'convocation':
                        htmlContent = `
                            <h2>Convocations</h2>
                            <p>${data.data.convocations}</p>
                        `;
                        break;
                    case 'planning':
                        htmlContent = `
                            <h2>Planning</h2>
                            <p>Le planning des activités sera affiché ici...</p>
                        `;
                        break;
                    case 'barbillard':
                        htmlContent = `
                            <h2>Barbillard</h2>
                            <p>${data.data.warnings}</p>
                        `;
                        break;
                    default:
                        htmlContent = `<p>Section inconnue.</p>`;
                        break;
                }

                content.innerHTML = htmlContent;
            } else {
                alert(data.error || 'Une erreur est survenue.');
            }
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données :', error);
            alert('Erreur lors de la récupération des données.');
        });
}

    </script>
    
</body>
</html>
