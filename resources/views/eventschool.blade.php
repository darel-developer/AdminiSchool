<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un événement</title>
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
            border-right: 1px solid #34495e;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar-title {
            font-family: 'Lemonada', sans-serif;
            font-weight: 600;
            font-size: 1.8rem;
            text-align: center;
            color: #ecf0f1;
            margin-bottom: 20px;
        }
        .sidebar-separator {
            border-top: 1px solid #34495e;
            margin: 10px 20px;
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
        .sidebar-item.active {
            
            color: #ffffff;
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
            background: #2c3e50; /* Couleur de fond similaire */
            border-right: 1px solid #ddd;
            color: #ecf0f1;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 8px 15px; /* Réduction de la taille des paddings */
            font-size: 0.9rem; /* Taille de police similaire */
            margin: 5px 0; /* Espacement entre les éléments */
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Effet hover similaire */
            transform: scale(1.05);
        }
        .sidebar-item img {
            width: 20px; /* Taille des icônes similaire */
            height: 20px;
            margin-right: 8px; /* Espacement entre l'icône et le texte */
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
        /* From Uiverse.io by Nawsome */ 
.loader {
  position: relative;
  width: 75px;
  height: 100px;
}

.loader__bar {
  position: absolute;
  bottom: 0;
  width: 10px;
  height: 50%;
  background: rgb(0, 0, 0);
  transform-origin: center bottom;
  box-shadow: 1px 1px 0 rgba(0, 0, 0, 0.2);
}

.loader__bar:nth-child(1) {
  left: 0px;
  transform: scale(1, 0.2);
  -webkit-animation: barUp1 4s infinite;
  animation: barUp1 4s infinite;
}

.loader__bar:nth-child(2) {
  left: 15px;
  transform: scale(1, 0.4);
  -webkit-animation: barUp2 4s infinite;
  animation: barUp2 4s infinite;
}

.loader__bar:nth-child(3) {
  left: 30px;
  transform: scale(1, 0.6);
  -webkit-animation: barUp3 4s infinite;
  animation: barUp3 4s infinite;
}

.loader__bar:nth-child(4) {
  left: 45px;
  transform: scale(1, 0.8);
  -webkit-animation: barUp4 4s infinite;
  animation: barUp4 4s infinite;
}

.loader__bar:nth-child(5) {
  left: 60px;
  transform: scale(1, 1);
  -webkit-animation: barUp5 4s infinite;
  animation: barUp5 4s infinite;
}

.loader__ball {
  position: absolute;
  bottom: 10px;
  left: 0;
  width: 10px;
  height: 10px;
  background: rgb(44, 143, 255);
  border-radius: 50%;
  -webkit-animation: ball624 4s infinite;
  animation: ball624 4s infinite;
}

@keyframes ball624 {
  0% {
    transform: translate(0, 0);
  }

  5% {
    transform: translate(8px, -14px);
  }

  10% {
    transform: translate(15px, -10px);
  }

  17% {
    transform: translate(23px, -24px);
  }

  20% {
    transform: translate(30px, -20px);
  }

  27% {
    transform: translate(38px, -34px);
  }

  30% {
    transform: translate(45px, -30px);
  }

  37% {
    transform: translate(53px, -44px);
  }

  40% {
    transform: translate(60px, -40px);
  }

  50% {
    transform: translate(60px, 0);
  }

  57% {
    transform: translate(53px, -14px);
  }

  60% {
    transform: translate(45px, -10px);
  }

  67% {
    transform: translate(37px, -24px);
  }

  70% {
    transform: translate(30px, -20px);
  }

  77% {
    transform: translate(22px, -34px);
  }

  80% {
    transform: translate(15px, -30px);
  }

  87% {
    transform: translate(7px, -44px);
  }

  90% {
    transform: translate(0, -40px);
  }

  100% {
    transform: translate(0, 0);
  }
}

@-webkit-keyframes barUp1 {
  0% {
    transform: scale(1, 0.2);
  }

  40% {
    transform: scale(1, 0.2);
  }

  50% {
    transform: scale(1, 1);
  }

  90% {
    transform: scale(1, 1);
  }

  100% {
    transform: scale(1, 0.2);
  }
}

@keyframes barUp1 {
  0% {
    transform: scale(1, 0.2);
  }

  40% {
    transform: scale(1, 0.2);
  }

  50% {
    transform: scale(1, 1);
  }

  90% {
    transform: scale(1, 1);
  }

  100% {
    transform: scale(1, 0.2);
  }
}

@-webkit-keyframes barUp2 {
  0% {
    transform: scale(1, 0.4);
  }

  40% {
    transform: scale(1, 0.4);
  }

  50% {
    transform: scale(1, 0.8);
  }

  90% {
    transform: scale(1, 0.8);
  }

  100% {
    transform: scale(1, 0.4);
  }
}

@keyframes barUp2 {
  0% {
    transform: scale(1, 0.4);
  }

  40% {
    transform: scale(1, 0.4);
  }

  50% {
    transform: scale(1, 0.8);
  }

  90% {
    transform: scale(1, 0.8);
  }

  100% {
    transform: scale(1, 0.4);
  }
}

@-webkit-keyframes barUp3 {
  0% {
    transform: scale(1, 0.6);
  }

  100% {
    transform: scale(1, 0.6);
  }
}

@keyframes barUp3 {
  0% {
    transform: scale(1, 0.6);
  }

  100% {
    transform: scale(1, 0.6);
  }
}

@-webkit-keyframes barUp4 {
  0% {
    transform: scale(1, 0.8);
  }

  40% {
    transform: scale(1, 0.8);
  }

  50% {
    transform: scale(1, 0.4);
  }

  90% {
    transform: scale(1, 0.4);
  }

  100% {
    transform: scale(1, 0.8);
  }
}

@keyframes barUp4 {
  0% {
    transform: scale(1, 0.8);
  }

  40% {
    transform: scale(1, 0.8);
  }

  50% {
    transform: scale(1, 0.4);
  }

  90% {
    transform: scale(1, 0.4);
  }

  100% {
    transform: scale(1, 0.8);
  }
}

@-webkit-keyframes barUp5 {
  0% {
    transform: scale(1, 1);
  }

  40% {
    transform: scale(1, 1);
  }

  50% {
    transform: scale(1, 0.2);
  }

  90% {
    transform: scale(1, 0.2);
  }

  100% {
    transform: scale(1, 1);
  }
}

@keyframes barUp5 {
  0% {
    transform: scale(1, 1);
  }

  40% {
    transform: scale(1, 1);
  }

  50% {
    transform: scale(1, 0.2);
  }

  90% {
    transform: scale(1, 0.2);
  }

  100% {
    transform: scale(1, 1);
  }
}
    </style>
</head>
<body>
    <!-- Loader -->
    <div id="loader" class="loader" style="display: none;">
        <div class="loader__bar"></div>
        <div class="loader__bar"></div>
        <div class="loader__bar"></div>
        <div class="loader__bar"></div>
        <div class="loader__bar"></div>
        <div class="loader__ball"></div>
    </div>

    <!-- Barre de navigation -->
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
        
        <a href="{{ route('helpsupport') }}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>

       <div class="content">
        <h1 id="main-title">Ajouter un événement</h1>
        <ul class="nav nav-tabs mb-4" id="eventTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="event-tab" data-bs-toggle="tab" data-bs-target="#event" type="button" role="tab" aria-controls="event" aria-selected="true">
                    Événement
                </button> 
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="announcement-tab" data-bs-toggle="tab" data-bs-target="#announcement" type="button" role="tab" aria-controls="announcement" aria-selected="false">
                    Annonce
                </button>
            </li>
        </ul>
        <div class="tab-content" id="eventTabsContent">
            <div class="tab-pane fade show active" id="event" role="tabpanel" aria-labelledby="event-tab">
                <!-- Formulaire événement existant -->
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
                                <option value="Spectacle de fin d'année">Spectacle de fin d'année</option
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
    
            // Show loader on form submission
           /* const form = document.getElementById('eventForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent immediate form submission for demonstration
                const loader = document.getElementById('loader');
                loader.style.display = 'block';
    
                // Hide loader after 5 seconds
                setTimeout(() => {
                    loader.style.display = 'none';
                    form.submit(); // Submit the form after the loader duration
                }, 5000); // 5 seconds
            });*/
        });
    </script>
</body>
</html>
