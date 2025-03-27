<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un événement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        /* Animation pour l'alerte de succès */
        .alert {
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
        }
        .alert.show {
            opacity: 1;
            transform: translateY(0);
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
        <a href="#" class="sidebar-item">
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
        <h1 id="main-title">Ajouter un événement</h1>
        <div class="mt-4">
            @if(session('success'))
                <div class="alert alert-success show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form id="eventForm" method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Type d'événement</label>
                    <select class="form-control" id="title" name="title" required>
                        <option value="">-- Sélectionnez un événement --</option>
                        <optgroup label="Réunions">
                            <option value="Réunion des parents d'élèves">Réunion des parents d'élèves</option>
                            <option value="Réunion du conseil de classe">Réunion du conseil de classe</option>
                            <option value="Réunion des professeurs">Réunion des professeurs</option>
                            <option value="Réunion du personnel">Réunion du personnel</option>
                        </optgroup>

                        <optgroup label="Événements scolaires">
                            <option value="Journée portes ouvertes">Journée portes ouvertes</option>
                            <option value="Journée culturelle">Journée culturelle</option>
                            <option value="Journée sportive">Journée sportive</option>
                            <option value="Cérémonie de remise des diplômes">Cérémonie de remise des diplômes</option>
                            <option value="Spectacle de fin d'année">Spectacle de fin d'année</option>
                        </optgroup>

                        <optgroup label="Examens et évaluations">
                            <option value="Session d'examens">Session d'examens</option>
                            <option value="Devoirs surveillés">Devoirs surveillés</option>
                            <option value="Baccalauréat blanc">Baccalauréat blanc</option>
                            <option value="Brevet blanc">Brevet blanc</option>
                        </optgroup>

                        <optgroup label="Sorties et voyages">
                            <option value="Sortie pédagogique">Sortie pédagogique</option>
                            <option value="Voyage scolaire">Voyage scolaire</option>
                            <option value="Classe de découverte">Classe de découverte</option>
                            <option value="Visite musée/exposition">Visite musée/exposition</option>
                        </optgroup>

                        <optgroup label="Administratif">
                            <option value="Convocation">Convocation</option>
                            <option value="Commission disciplinaire">Commission disciplinaire</option>
                            <option value="Réunion d'information orientation">Réunion d'information orientation</option>
                        </optgroup>

                        <optgroup label="Autres">
                            <option value="Formation des enseignants">Formation des enseignants</option>
                            <option value="Journée pédagogique">Journée pédagogique</option>
                            <option value="Forum des métiers">Forum des métiers</option>
                            <option value="Autre (précisez en description)">Autre (précisez en description)</option>
                        </optgroup>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="event_date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                </div>

                <div class="mb-3">
                    <label for="event_time" class="form-label">Heure</label>
                    <input type="time" class="form-control" id="event_time" name="event_time" required>
                </div>

                <div class="mb-3">
                    <label for="class" class="form-label">Classe</label>
                    <select class="form-control" id="class" name="class" required>
                        <option value="">-- Sélectionnez une classe --</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->name }}">{{ $classe->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Soumettre</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                }, 3000); // Masquer l'alerte après 3 secondes
            }
        });
    </script>
</body>
</html>
