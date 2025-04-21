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
            background: #2c3e50;
            color: #fff;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }
        .sidebar-title {
            font-family: 'Lemonada', sans-serif;
            font-weight: 600;
            font-size: 1.2rem;
            text-align: center;
            margin-bottom: 10px;
        }
        .sidebar-separator {
            border-top: 1px solid rgba(255, 255, 255, 0.5);
            margin: 10px 20px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            font-size: 0.9rem;
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
            width: 20px;
            height: 20px;
            margin-right: 8px;
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
        .section-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .section-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-title">ADMINISCHOOL</div>
        <div class="sidebar-separator"></div>
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
        <div class="">
            <h1>Parent Dashboard</h1>
        </div>
        <div class="btn-group mb-4" role="group" aria-label="Sections">
            <button type="button" class="btn btn-primary" onclick="loadSection('general')">Informations Générales</button>
            <button type="button" class="btn btn-primary" onclick="loadSection('absence')">Absences</button>
            <button type="button" class="btn btn-primary" onclick="loadSection('convocation')">Convocations</button>
            <button type="button" class="btn btn-primary" onclick="loadSection('warnings')">Avertissements</button>
            <button type="button" class="btn btn-primary" onclick="loadSection('planning')">Planning</button>
            <button type="button" class="btn btn-primary" onclick="loadSection('notes')">Notes</button>
        </div>
        <div id="content" class="section-content">
            <p>Sélectionnez une section pour afficher les données.</p>
        </div>
    </div>

    <script>
        function loadSection(section) {
    console.log(`Chargement de la section : ${section}`);
    fetch(`/child/${section}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log(`Données reçues pour la section ${section} :`, data);
                let htmlContent = '';
                switch (section) {
                    case 'general':
                        htmlContent = `
                            <h2>Informations Générales</h2>
                            <p><strong>Nom :</strong> ${data.data.name}</p>
                            <p><strong>Classe :</strong> ${data.data.class}</p>
                            <p><strong>Date d'inscription :</strong> ${data.data.enrollment_date || 'Non disponible'}</p>
                            <p><strong>Absences :</strong> ${data.data.absences}</p>
                            <p><strong>Convocations :</strong> ${data.data.convocations}</p>
                            <p><strong>Avertissements :</strong> ${data.data.warnings}</p>
                        `;
                        break;

                    case 'planning':
                        if (data.data.planning.length > 0) {
                            console.log('Classe trouvée, affichage du planning.');
                            htmlContent = `
                                <h2>Planning</h2>
                                <a href="/child/planning/download" class="btn btn-success mb-3 float-end" target="_blank">
                                    <img src="https://img.icons8.com/ios-filled/50/ffffff/download.png" alt="Download" style="width: 20px; height: 20px; margin-right: 5px;">
                                    Télécharger le PDF
                                </a>
                                <table class="table table-striped">
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
                        } else {
                            console.log('Aucun planning trouvé pour cette classe.');
                            htmlContent = '<p>Aucun planning disponible pour cette classe.</p>';
                        }
                        break;

                    case 'absence':
                        htmlContent = `
                            <h2>Absences</h2>
                            <p><strong>Nombre d'absences :</strong> ${data.data.absences}</p>
                        `;
                        break;

                    case 'convocation':
                        htmlContent = `
                            <h2>Convocations</h2>
                            <p><strong>Nombre de convocations :</strong> ${data.data.convocations}</p>
                        `;
                        break;

                    case 'warnings':
                        htmlContent = `
                            <h2>Avertissements</h2>
                            <p><strong>Nombre d'avertissements :</strong> ${data.data.warnings}</p>
                        `;
                        break;

                    case 'notes':
                        if (data.data.notes && data.data.notes.length > 0) {
                            htmlContent = `
                                <h2>Notes</h2>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Matière</th>
                                            <th>Note</th>
                                            <th>Commentaire</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.data.notes.map(note => `
                                            <tr>
                                                <td>${note.subject}</td>
                                                <td>${note.grade}</td>
                                                <td>${note.comment || 'Aucun commentaire'}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            `;
                        } else {
                            htmlContent = '<p>Aucune note disponible.</p>';
                        }
                        break;

                    default:
                        console.log(`Affichage de la section ${section}.`);
                        htmlContent = `<p>Section ${section} chargée avec succès.</p>`;
                        break;
                }

                document.getElementById('content').innerHTML = htmlContent;
            } else {
                console.error(`Erreur lors du chargement de la section ${section} :`, data.error);
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
