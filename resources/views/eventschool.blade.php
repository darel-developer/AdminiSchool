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
            border-radius: 0 18px 18px 0;
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
            transition: background 0.2s;
        }
        .sidebar-toggle:active, .sidebar-toggle:focus {
            outline: none;
            background: #34495e;
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
        }
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
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
    <!-- Hamburger menu button -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Menu">
        <i class="fas fa-bars"></i>
    </button>
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
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Paramètres
        </a>
        <a href="{{ route('helpsupport') }}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
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
            <div class="tab-pane fade" id="announcement" role="tabpanel" aria-labelledby="announcement-tab">
                <!-- Contenu de l'onglet Annonce -->
                <div class="p-3">
                    <h2>Créer une annonce</h2>
                    <form id="announcementForm" method="POST" action="{{ route('announcements.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="announcement_title" class="form-label">Titre de l'annonce</label>
                            <input type="text" class="form-control" id="announcement_title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="announcement_message" class="form-label">Contenu</label>
                            <textarea class="form-control" id="announcement_message" name="message" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="announcement_classes" class="form-label">Classe(s) concernée(s) <span class="text-muted">(optionnel, laisser vide pour tous les parents)</span></label>
                            <select class="form-control" id="announcement_classes" name="classes[]" multiple>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->name }}">{{ $classe->name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Maintenez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs classes.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Publier l'annonce</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile/tablet (identique à school.blade.php)
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
        function updateSidebarToggleDisplay() {
            if (window.innerWidth < 992) {
                sidebarToggle.style.display = 'flex';
            } else {
                sidebarToggle.style.display = 'none';
                closeSidebar();
            }
        }
        updateSidebarToggleDisplay();
        window.addEventListener('resize', updateSidebarToggleDisplay);

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

        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                }, 3000);
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
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Maintenez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs classes.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Publier l'annonce</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile/tablet (identique à school.blade.php)
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
        function updateSidebarToggleDisplay() {
            if (window.innerWidth < 992) {
                sidebarToggle.style.display = 'flex';
            } else {
                sidebarToggle.style.display = 'none';
                closeSidebar();
            }
        }
        updateSidebarToggleDisplay();
        window.addEventListener('resize', updateSidebarToggleDisplay);

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

        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                }, 3000);
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
