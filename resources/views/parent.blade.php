<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
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
    <div class="sidebar">
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
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/notification.png') }}" alt="notification">
            Notification
        </a>
        <a href="{{route('parentchild')}}" class="sidebar-item">
            <img src="{{ asset('images/Add_User.png') }}" alt="enfant">
            Add Enfant
        </a>
        <a href="{{route('profileschool')}}" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Settings
        </a>
        <a href="{{route('helpsupport')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Parent Dashboard</h1>
        <div class="btn-group" role="group" aria-label="Sections">
            <button type="button" class="btn btn-primary" onclick="loadSection('general')">Informations Générales</button>
            <button type="button" class="btn btn-primary" onclick="loadSection('absence')">Absences</button>
            <button type="button" class="btn btn-primary" onclick="loadSection('convocation')">Convocations</button>
            <button type="button" class="btn btn-primary" onclick="loadSection('warnings')">Avertissements</button>
            <button type="button" class="btn btn-primary" onclick="loadSection('planning')">Planning</button>
            <button type="button" class="btn btn-primary" onclick="loadSection('notes')">Notes</button>
        </div>
        <div id="content" class="mt-4">
            <p>Sélectionnez une section pour afficher les données.</p>
        </div>
    </div>

    <script>
        function loadSection(section) {
            fetch(`/child/${section}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let htmlContent = '';
                        switch (section) {
                            case 'general':
                                htmlContent = `
                                    <h2>Informations Générales</h2>
                                    <p>Nom: ${data.data.name}</p>
                                    <p>Classe: ${data.data.class}</p>
                                    <p>Date d'inscription: ${data.data.enrollment_date}</p>
                                `;
                                break;
                            case 'absence':
                                htmlContent = `
                                    <h2>Absences</h2>
                                    <p>Nombre d'absences: ${data.data.absences}</p>
                                `;
                                break;
                            case 'convocation':
                                htmlContent = `
                                    <h2>Convocations</h2>
                                    <p>Nombre de convocations: ${data.data.convocations}</p>
                                `;
                                break;
                            case 'warnings':
                                htmlContent = `
                                    <h2>Avertissements</h2>
                                    <p>Nombre d'avertissements: ${data.data.warnings}</p>
                                `;
                                break;
                            case 'planning':
                                htmlContent = `
                                    <h2>Planning</h2>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Heure Début</th>
                                                <th>Heure Fin</th>
                                                <th>Code</th>
                                                <th>Enseignant</th>
                                                <th>Salle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${data.data.planning.map(planning => `
                                                <tr>
                                                    <td>${planning.date}</td>
                                                    <td>${planning.start_time}</td>
                                                    <td>${planning.end_time}</td>
                                                    <td>${planning.code}</td>
                                                    <td>${planning.teacher}</td>
                                                    <td>${planning.room}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                `;
                                break;
                            case 'notes':
                                htmlContent = `
                                    <h2>Notes</h2>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Matière</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${data.data.notes.map(note => `
                                                <tr>
                                                    <td>${note.subject}</td>
                                                    <td>${note.grade}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                `;
                                break;
                            default:
                                htmlContent = `<p>Section inconnue.</p>`;
                                break;
                        }
    
                        document.getElementById('content').innerHTML = htmlContent;
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
