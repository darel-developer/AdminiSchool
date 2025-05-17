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
        .notification-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            cursor: pointer;
        }
        .notification-icon img {
            width: 30px;
            height: 30px;
        }
        .notification-icon .notification-new img {
            animation: bell-shake 0.7s cubic-bezier(.36,.07,.19,.97) both;
        }
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
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: fixed;
                bottom: 0;
                left: 0;
                display: flex;
                flex-direction: row;
                justify-content: space-around;
                padding: 10px 0;
                background: #2c3e50;
                z-index: 1000;
            }
            .sidebar-title, .sidebar-separator, .sidebar-item span {
                display: none; /* Hide text and separators */
            }
            .sidebar-item {
                flex-direction: column;
                padding: 5px;
                font-size: 0.7rem;
                text-align: center;
            }
            .sidebar-item img {
                margin: 0;
                width: 24px; /* Adjust icon size */
                height: 24px;
            }
            .content {
                margin-left: 0;
                padding-bottom: 60px; /* Add space for the bottom bar */
            }
        }
    </style>
</head>
<body>
    <script>
        if (window.innerWidth < 768) {
            window.location.href = "/mobile-blocked";
        }
    </script>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
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

    <!-- Notification Icon -->
    <div class="notification-icon" id="notificationIcon">
        <a href="#" onclick="openNotificationModal(); return false;">
            <img src="https://img.icons8.com/ios-filled/50/000000/bell.png" alt="Notifications">
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
                        <!-- Notifications will be dynamically loaded here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let lastUnreadCount = 0;
        function updateNotificationBadge() {
            fetch('{{ route("notifications.unread-count") }}') 
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notificationBadge');
                    const icon = document.getElementById('notificationIcon');
                    if (data.unreadNotificationsCount > 0) {
                        badge.textContent = data.unreadNotificationsCount; 
                        badge.style.display = 'inline-block'; 
                        // Animation si nouvelle notification
                        if (data.unreadNotificationsCount > lastUnreadCount) {
                            icon.classList.add('notification-new');
                            setTimeout(() => icon.classList.remove('notification-new'), 1000);
                        }
                    } else {
                        badge.style.display = 'none'; 
                    }
                    lastUnreadCount = data.unreadNotificationsCount;
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des notifications non lues :', error);
                });
        }

        // Update the badge every 10 seconds
        setInterval(updateNotificationBadge, 10000);

        // Initial badge update
        updateNotificationBadge();
    });

    function openNotificationModal() {
        fetch('{{ route("notifications.page") }}')
            .then(response => response.json())
            .then(data => {
                const notificationList = document.getElementById('notificationList');
                notificationList.innerHTML = '';

                if (data.notifications.length === 0) {
                    notificationList.innerHTML = '<li class="list-group-item text-center text-muted py-4"><img src="https://img.icons8.com/ios-filled/50/cccccc/bell.png" style="width:32px;height:32px;"><br>Aucune notification disponible.</li>';
                } else {
                    data.notifications.forEach(notification => {
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
                        // Optionally, add a separator except for the last item
                        // if (i < data.notifications.length - 1) {
                        //     notificationList.appendChild(document.createElement('hr'));
                        // }
                    });
                }

                const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
                modal.show();

                // Mark notifications as read after opening the modal
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
                updateNotificationBadge();
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
                        document.getElementById('content').innerHTML = '<p>Erreur lors de la récupération des données.</p>';
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

        function openNotificationModal() {
            fetch('{{ route("notifications.page") }}')
                .then(response => response.json())
                .then(data => {
                    const notificationList = document.getElementById('notificationList');
                    notificationList.innerHTML = '';

                    if (data.notifications.length === 0) {
                        notificationList.innerHTML = '<li class="list-group-item text-center text-muted py-4"><img src="https://img.icons8.com/ios-filled/50/cccccc/bell.png" style="width:32px;height:32px;"><br>Aucune notification disponible.</li>';
                    } else {
                        data.notifications.forEach(notification => {
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
                            // Optionally, add a separator except for the last item
                            // if (i < data.notifications.length - 1) {
                            //     notificationList.appendChild(document.createElement('hr'));
                            // }
                        });
                    }

                    const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
                    modal.show();

                    // Mark notifications as read after opening the modal
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
    </script>
</body>
</html>