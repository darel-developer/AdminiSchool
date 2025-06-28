<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2c3e50">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #22304f 0%, #34495e 100%);
            color: #fff;
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
            font-size: 1.4rem;
            text-align: center;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }
        .sidebar-separator {
            border-top: 1px solid rgba(255, 255, 255, 0.5);
            margin: 10px 20px;
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
            flex-grow: 1;
            padding: 32px 24px 24px 24px;
            background: #f4f7fb;
            min-height: 100vh;
            transition: margin-left 0.3s;
        }
        .container {
            max-width: 900px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.07);
            padding: 32px 24px;
        }
        .section-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .section-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.07);
        }
        .table {
            margin-top: 20px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
        .notification-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            cursor: pointer;
            z-index: 2000;
        }
        .notification-icon img {
            width: 30px;
            height: 30px;
        }
        .notification-icon .notification-new img {
            animation: bell-shake 0.7s cubic-bezier(.36,.07,.19,.97) both;
        }
        .btn-group .btn {
            border-radius: 8px !important;
            font-weight: 500;
        }
        .modal-content {
            border-radius: 14px;
        }
        .alert {
            border-radius: 8px;
        }
        /* Responsive styles */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                width: 180px;
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
            .container {
                padding: 18px 2vw;
            }
        }
        @media (max-width: 767.98px) {
            .sidebar {
                width: 100vw;
                height: 60px;
                flex-direction: row;
                justify-content: space-around;
                padding: 0;
                border-right: none;
                border-top: 1px solid #ddd;
                position: fixed;
                bottom: 0;
                left: 0;
                top: auto;
                z-index: 1000;
            }
            .sidebar-title, .sidebar-separator, .sidebar-item span {
                display: none;
            }
            .sidebar-item {
                flex-direction: column;
                align-items: center;
                padding: 5px;
                font-size: 0.7rem;
                text-align: center;
                margin: 0 2px;
            }
            .sidebar-item img {
                margin: 0;
                width: 24px;
                height: 24px;
            }
            .content {
                margin-left: 0;
                padding-bottom: 70px;
            }
            .container {
                padding: 10px 1vw;
            }
            .notification-icon {
                top: 10px;
                right: 10px;
            }
        }
        @media (max-width: 575.98px) {
            .sidebar {
                width: 100vw;
                padding: 8px 0;
            }
            .sidebar-title {
                font-size: 1.1rem;
            }
            .sidebar-item {
                font-size: 0.98rem;
                padding: 6px 10px;
            }
            .content {
                padding: 8px 2px 8px 2px;
            }
            .container {
                padding: 8px 2px;
            }
        }
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
        }
        /* Animation de secousse pour la cloche */
        @keyframes bell-shake {
            0% { transform: rotate(0); }
            10% { transform: rotate(-15deg); }
            20% { transform: rotate(10deg); }
            30% { transform: rotate(-10deg); }
            40% { transform: rotate(6deg); }
            50% { transform: rotate(-4deg); }
            60% { transform: rotate(2deg); }
            70% { transform: rotate(-1deg); }
            80%, 100% { transform: rotate(0); }
        }
        .bell-animate {
            animation: bell-shake 1s cubic-bezier(.36,.07,.19,.97) both;
        }
    </style>
</head>
<body>
    <!-- Hamburger menu button -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Menu" style="display:none;">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column" id="sidebarMenu">
        <div class="sidebar-title">ADMINISCHOOL</div>
        <div class="sidebar-separator"></div>
        <a href="{{route('parent')}}" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            <span>Dashboard</span>
        </a>
        <a href="{{route('parentdocument')}}" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            <span>Document</span>
        </a>
        <a href="{{route('parentpaiement')}}" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="paiement">
            <span>Paiement</span>
        </a>
        <a href="{{route('parentchat')}}" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            <span>Messagerie</span>
        </a>
        <a href="#" class="sidebar-item" onclick="openNotificationModal()">
            <img src="{{ asset('images/notification.png') }}" alt="notification">
            <span>Notification</span>
        </a>
        <a href="{{route('parentchild')}}" class="sidebar-item">
            <img src="{{ asset('images/Add_User.png') }}" alt="enfant">
            <span>Ajouter Enfant</span>
        </a>
        <a href="{{route('profileschool')}}" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            <span>Paramètre</span>
        </a>
        <a href="{{route('helpsupport')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            <span>Aide</span>
        </a>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <!-- Notification Icon -->
    <div class="notification-icon" id="notificationIcon">
        <a href="#" onclick="openNotificationModal(); return false;" style="position:relative;">
            <img id="notificationBell" src="https://img.icons8.com/ios-filled/50/000000/bell.png" alt="Notifications">
            <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
                0
            </span>
        </a>
    </div>
    <!-- Content -->
    <div class="content">
        <div class="container">
            <h1>Parent Dashboard</h1>
            <h3>Sélectionnez un enfant</h3>
            <select id="childSelector" class="form-select mb-4">
                <option value="" disabled selected>Choisissez un enfant</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>

            <div class="btn-group mb-4" role="group" aria-label="Sections">
                <button type="button" class="btn btn-primary" onclick="loadSection('general')">Informations Générales</button>
                <button type="button" class="btn btn-primary" onclick="loadSection('planning')">Planning</button>
                <button type="button" class="btn btn-primary" onclick="loadSection('notes')">Notes</button>
                <button type="button" class="btn btn-primary" onclick="loadSection('edit')">Modifier les données</button>
                <button type="button" class="btn btn-primary" onclick="loadSection('bulletins')">Bulletins</button>
            </div>

            <div id="content" class="section-content">
                <p>Sélectionnez une section pour afficher les données.</p>
            </div>
        </div>
    </div>

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="notificationModalLabel">
                        <img src="https://img.icons8.com/ios-filled/24/ffffff/bell.png" alt="Notifications" style="margin-right:8px;">
                        Notifications
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <ul id="notificationList" class="list-group list-group-flush">
                        <!-- Notifications seront chargés ici -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
        // Always show hamburger on mobile/tablet
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

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }
        // Close sidebar on navigation (mobile)
        document.querySelectorAll('.sidebar-item').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) closeSidebar();
            });
        });

        // --- Gestion de la cloche de notification avec animation et nombre ---
        let lastUnreadCount = 0;
        let notificationIsActive = false;
        let pollingInterval = null;

        function updateNotificationBadge() {
            fetch('{{ route("notifications.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notificationBadge');
                    const bell = document.getElementById('notificationBell');
                    if (data.unreadNotificationsCount > 0) {
                        badge.textContent = data.unreadNotificationsCount;
                        badge.style.display = 'inline-block';

                        // Si nouvelle notification, active l'animation et la couleur rouge
                        if (data.unreadNotificationsCount > lastUnreadCount) {
                            bell.classList.add('bell-animate');
                            bell.style.filter = 'invert(16%) sepia(94%) saturate(7482%) hue-rotate(357deg) brightness(93%) contrast(119%)'; // Rouge
                            notificationIsActive = true;
                        } else if (!notificationIsActive) {
                            // Si badge > 0 mais pas de nouvelle, garde la couleur rouge sans animation
                            bell.classList.remove('bell-animate');
                            bell.style.filter = 'invert(16%) sepia(94%) saturate(7482%) hue-rotate(357deg) brightness(93%) contrast(119%)'; // Rouge
                        }
                    } else {
                        // Pas de notifications non lues : cloche noire, pas d'animation
                        badge.style.display = 'none';
                        bell.classList.remove('bell-animate');
                        bell.style.filter = 'invert(0%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%)'; // Noir
                        notificationIsActive = false;
                    }
                    lastUnreadCount = data.unreadNotificationsCount;
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des notifications non lues :', error);
                });
        }

        pollingInterval = setInterval(updateNotificationBadge, 2000);
        updateNotificationBadge();
        window.updateNotificationBadge = updateNotificationBadge;

        // Fonction appelée quand on ouvre la modal de notifications
        function openNotificationModal() {
            fetch('{{ route("notifications.page") }}')
                .then(response => response.json())
                .then(data => {
                    const notificationList = document.getElementById('notificationList');
                    notificationList.innerHTML = '';

                    // Filtrer les notifications de moins de 3 jours
                    const now = new Date();
                    const filteredNotifications = data.notifications.filter(notification => {
                        const notifDate = new Date(notification.created_at);
                        const diffTime = Math.abs(now - notifDate);
                        const diffDays = diffTime / (1000 * 60 * 60 * 24);
                        return diffDays <= 3;
                    });

                    if (filteredNotifications.length === 0) {
                        notificationList.innerHTML = '<li class="list-group-item text-center text-muted py-4"><img src="https://img.icons8.com/ios-filled/50/cccccc/bell.png" style="width:32px;height:32px;"><br>Aucune notification disponible.</li>';
                    } else {
                        filteredNotifications.forEach(notification => {
                            const listItem = document.createElement('li');
                            listItem.className = 'list-group-item d-flex align-items-start py-3';
                            listItem.innerHTML = `
                                <div class="me-3">
                                    <img src="https://img.icons8.com/color/36/000000/appointment-reminders--v2.png" alt="Notif" style="width:32px;height:32px;">
                                </div>
                                <div style="flex:1;">
                                    <div class="fw-bold mb-1" style="color:#0d6efd;">${notification.title || 'Notification'}</div>
                                    <div class="mb-1">${notification.message}</div>
                                    <div class="text-muted small">${new Date(notification.created_at).toLocaleString()}</div>
                                </div>
                            `;
                            notificationList.appendChild(listItem);
                        });
                    }

                    const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
                    modal.show();

                    // Marquer les notifications comme lues et remettre la cloche à l'état normal
                    markNotificationsAsRead();
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des notifications :', error);
                    const notificationList = document.getElementById('notificationList');
                    notificationList.innerHTML = '<li class="list-group-item text-danger text-center">Erreur lors de la récupération des notifications.</li>';
                    const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
                    modal.show();
                });
        }

        // Quand on marque les notifications comme lues, la cloche redevient noire et l'animation s'arrête
        function markNotificationsAsRead() {
            fetch('{{ route("notifications.mark-as-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remet la cloche à l'état normal (noir, pas d'animation)
                    const bell = document.getElementById('notificationBell');
                    bell.classList.remove('bell-animate');
                    bell.style.filter = 'invert(0%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%)'; // Noir
                    // Remettre le badge à 0
                    const badge = document.getElementById('notificationBadge');
                    badge.textContent = 0;
                    badge.style.display = 'none';
                    window.updateNotificationBadge();
                }
            })
            .catch(error => {
                console.error('Erreur lors de la mise à jour des notifications :', error);
            });
        }
    </script>
    <script>
        let selectedChildId = {{ $students->first()->id ?? 'null' }}; 

        document.addEventListener('DOMContentLoaded', function () {
            const childSelector = document.getElementById('childSelector');
            const content = document.getElementById('content');

            
            if (childSelector && selectedChildId) {
                childSelector.value = selectedChildId;
                content.innerHTML = '<p>Sélectionnez une section pour afficher les données.</p>';
            }

            
            childSelector.addEventListener('change', function () {
                selectedChildId = this.value;
                content.innerHTML = '<p>Sélectionnez une section pour afficher les données.</p>';
            });

            
            window.loadSection = function (section) {
                if (!selectedChildId) {
                    alert('Veuillez sélectionner un enfant.');
                    return;
                }

                fetch(`/child/${section}/${selectedChildId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
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
                                        htmlContent = `
                                            <h2>Planning</h2>
                                            <a href="/child/planning/download/${selectedChildId}" class="btn btn-success mb-3 float-end" target="_blank">
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
                                        htmlContent = '<p>Aucun planning disponible.</p>';
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
                                                            <td>${note.matiere}</td>
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

                                case 'bulletins':
                                    if (data.data && data.data.url) {
                                        htmlContent = `
                                            <h2>Bulletin de notes</h2>
                                            <div class="w-100" style="height:70vh;">
                                                <iframe src="${data.data.url}" style="width:100%;height:100%;" frameborder="0"></iframe>
                                                <a href="${data.data.url}" class="btn btn-success mt-3" download target="_blank">
                                                    <img src="https://img.icons8.com/ios-filled/24/ffffff/download.png" style="width:20px;height:20px;margin-right:5px;"> Télécharger le bulletin
                                                </a>
                                            </div>
                                        `;
                                    } else {
                                        htmlContent = `<div class="alert alert-danger text-center">${data.error || 'Bulletin non disponible.'}</div>`;
                                    }
                                    break;

                                case 'edit':
                                    htmlContent = `
                                        <h2>Modifier les données de l'enfant</h2>
                                        <form id="editChildForm">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nom</label>
                                                <input type="text" class="form-control" id="name" name="name" value="${data.data.name}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="class" class="form-label">Classe</label>
                                                <input type="text" class="form-control" id="class" name="class" value="${data.data.class}" required>
                                            </div>
                                            <button type="button" class="btn btn-primary" onclick="updateChild(${data.data.id})">Mettre à jour</button>
                                        </form>
                                    `;
                                    break;

                                default:
                                    htmlContent = `<p>Section ${section} chargée avec succès.</p>`;
                                    break;
                            }

                            document.getElementById('content').innerHTML = htmlContent;
                        } else {
                            document.getElementById('content').innerHTML = `<p>${data.error}</p>`;
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération des données :', error);
                        document.getElementById('content').innerHTML = `<p>Erreur lors de la récupération des données : ${error.message}</p>`;
                    });
            };
        });

        function updateChild(childId) {
            const form = document.getElementById('editChildForm');
            const formData = new FormData(form);

            fetch(`/child/update/${childId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Données mises à jour avec succès.');
                    loadSection('general'); 
                } else {
                    alert('Erreur lors de la mise à jour des données.');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la mise à jour des données :', error);
            });
        }
    </script>
</body>
</html>