<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie Parent</title>
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
            background: #2c3e50;
            color: #fff;
            padding: 20px 0;
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
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 80vh;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
        }
        .chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }
        .chat-messages {
            flex-grow: 1;
            padding: 18px 10px 10px 10px;
            overflow-y: auto;
            background: linear-gradient(135deg, #f8f9fa 80%, #e3e6ed 100%);
            display: flex;
            flex-direction: column;
        }
        .chat-message-bubble {
            max-width: 75%;
            padding: 14px 20px;
            border-radius: 22px;
            margin-bottom: 18px;
            word-break: break-word;
            font-size: 1rem;
            display: inline-block;
            position: relative;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            transition: box-shadow 0.2s, background 0.2s;
        }
        .chat-message-bubble:hover {
            box-shadow: 0 4px 18px rgba(0,0,0,0.13);
            background-color: #f1f3f7;
        }
        .chat-message-sent {
            align-self: flex-end;
            background: linear-gradient(135deg, #007bff 80%, #0056b3 100%);
            color: #fff;
            border-bottom-right-radius: 4px;
            border-bottom-left-radius: 18px;
        }
        .chat-message-received {
            align-self: flex-start;
            background: linear-gradient(135deg, #e9ecef 80%, #dbe4ee 100%);
            color: #333;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 18px;
        }
        .chat-message-meta {
            font-size: 0.78em;
            opacity: 0.7;
            margin-top: 7px;
            text-align: right;
            font-style: italic;
        }
        .chat-message-attachment {
            margin-top: 7px;
            display: block;
            font-size: 0.97em;
        }
        .chat-message-bubble .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            position: absolute;
            top: -10px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.10);
        }
        .chat-message-sent .avatar {
            right: -42px;
            background: #007bff;
        }
        .chat-message-received .avatar {
            left: -42px;
            background: #e9ecef;
        }
        .chat-input {
            display: flex;
            padding: 14px 10px;
            border-top: 1px solid #e0e0e0;
            background: #f8f9fa;
        }
        .chat-input textarea {
            flex-grow: 1;
            resize: none;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px;
            font-size: 1rem;
            background: #fff;
            transition: border 0.2s;
        }
        .chat-input textarea:focus {
            border: 1.5px solid #007bff;
            outline: none;
        }
        .chat-input button {
            margin-left: 12px;
            border-radius: 8px;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .chat-input input[type="file"] {
            max-width: 180px;
            margin-left: 10px;
            border-radius: 8px;
            background: #f1f3f7;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                width: 180px;
                z-index: 1050;
                transition: transform 0.3s ease;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .sidebar-toggle {
                display: flex;
            }
            .content {
                margin-left: 0;
                padding: 18px 2vw 18px 2vw;
            }
        }
        @media (max-width: 767.98px) {
            .sidebar {
                width: 140px;
            }
            .sidebar-toggle {
                display: flex;
            }
            .content {
                margin-left: 0;
                padding: 10px 1vw 10px 1vw;
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
                padding: 10px 18px;
            }
            .sidebar-toggle {
                display: flex;
            }
            .content {
                padding: 8px 2px 8px 2px;
            }
        }
        /* Ajouté : overlay pour la sidebar */
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
        }
        .sidebar-toggle:focus {
            outline: none;
        }
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
        }
    </style>
</head>
<body>
    <!-- Hamburger menu button -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Menu">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Barre de navigation -->
    <div class="sidebar d-flex flex-column" id="sidebarMenu">
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
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="paiement">
            Paiement
        </a>
        <a href="{{route('parentchat')}}" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Messagerie
        </a>
       
        <a href="{{route('parentchild')}}" class="sidebar-item">
            <img src="{{ asset('images/Add_User.png') }}" alt="help support">
            Ajouter Enfant
        </a>
        <a href="{{route('profileschool')}}" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Paramètres
        </a>
        <a href="{{route('helpsupport')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <!-- Contenu principal -->
    <div class="content">
        <h1>Messagerie Parent</h1>

        <!-- Dropdown for selecting a child -->
        <div class="mb-3">
            <label for="childSelector" class="form-label">Sélectionnez un enfant</label>
            <select id="childSelector" class="form-select">
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ $loop->first ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary mb-3" id="contactTeacherBtn">Contactez un enseignant</button>

        <!-- Modal pour la sélection de l'enseignant -->
        <div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="teacherModalLabel">Sélectionnez un enseignant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="teacherList" class="list-group">
                            <!-- Les enseignants seront chargés ici dynamiquement -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone de messagerie -->
        <div class="chat-container">
            <div class="chat-header" id="chatHeader">Sélectionnez un enseignant pour commencer</div>
            <div class="chat-messages" id="chatMessages">
                <!-- Les messages seront chargés ici -->
            </div>
            <div class="chat-input">
                <textarea id="messageInput" rows="1" placeholder="Écrivez votre message ici..."></textarea>
                <input type="file" id="attachmentInput" class="form-control" style="max-width: 200px; margin-left: 10px;">
                <button class="btn btn-primary" id="sendMessageBtn" disabled>Envoyer</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let selectedChildId = {{ $students->isNotEmpty() ? $students->first()->id : 'null' }}; 
            const childSelector = document.getElementById('childSelector');
            const contactTeacherBtn = document.getElementById('contactTeacherBtn');
            const chatHeader = document.getElementById('chatHeader');
            const chatMessages = document.getElementById('chatMessages');
            const messageInput = document.getElementById('messageInput');
            const attachmentInput = document.getElementById('attachmentInput');
            const sendMessageBtn = document.getElementById('sendMessageBtn');
            const teacherList = document.getElementById('teacherList');
            let selectedTeacherId = null;
            let messagePollingInterval = null; // Ajout pour le polling

            // Récupérer l'id du parent connecté depuis lebackend (Blade)
            const parentId = {{ Auth::guard('tuteur')->user()->id ?? 'null' }};

            childSelector.addEventListener('change', function () {
                selectedChildId = this.value;
                chatHeader.textContent = 'Sélectionnez un enseignant pour commencer';
                chatMessages.innerHTML = '';
                sendMessageBtn.disabled = true;
                stopMessagePolling(); // Arrêter le polling lors du changement d'enfant
            });

            
            contactTeacherBtn.addEventListener('click', function () {
                if (!selectedChildId) {
                    alert('Veuillez sélectionner un enfant.');
                    return;
                }

                fetch(`/get-teachers?child_id=${selectedChildId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        teacherList.innerHTML = '';
                        data.teachers.forEach(teacher => {
                            const listItem = document.createElement('li');
                            listItem.className = 'list-group-item list-group-item-action';
                            // Ajoute la matière à côté du nom de l'enseignant
                            listItem.innerHTML = `<span>${teacher.first_name} ${teacher.last_name}</span> <span class="badge bg-info ms-2">${teacher.subject}</span>`;
                            listItem.dataset.id = teacher.id;
                            listItem.addEventListener('click', function () {
                                selectedTeacherId = teacher.id;
                                chatHeader.textContent = `Discussion avec ${teacher.first_name} ${teacher.last_name}`;
                                sendMessageBtn.disabled = false;
                                loadMessages();
                                startMessagePolling(); // Démarrer le polling
                                const teacherModal = bootstrap.Modal.getInstance(document.getElementById('teacherModal'));
                                teacherModal.hide();
                            });
                            teacherList.appendChild(listItem);
                        });

                        const teacherModal = new bootstrap.Modal(document.getElementById('teacherModal'));
                        teacherModal.show();
                    })
                    .catch(error => {
                        alert('Erreur lors du chargement des enseignants.');
                    });
            });

           
            function loadMessages() {
                if (!selectedTeacherId) return;

                fetch(`/get-messages/${selectedTeacherId}?child_id=${selectedChildId}`)
                    .then(response => response.json())
                    .then(data => {
                        chatMessages.innerHTML = '';
                        data.messages.forEach(message => {
                            // Determine qui est l'expéditeur
                            // 'parent' == tuteur connecté, sinon 'teacher'
                            const isSent = message.sender && message.sender.type === 'parent';
                            const bubbleClass = isSent ? "chat-message-bubble chat-message-sent" : "chat-message-bubble chat-message-received";
                            let html = '';
                            if (message.message) {
                                html += `<div>${message.message}</div>`;
                            }
                            if (message.attachment) {
                                html += `<a class="chat-message-attachment" href="${message.attachment}" target="_blank">📎 Pièce jointe</a>`;
                            }
                            html += `<div class="chat-message-meta">${message.sender ? message.sender.name : ""} &middot; ${message.created_at ?? ""}</div>`;
                            const messageElement = document.createElement('div');
                            messageElement.className = bubbleClass;
                            messageElement.innerHTML = html;
                            chatMessages.appendChild(messageElement);
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    })
                    .catch(error => {
                        alert('Erreur lors de la récupération des messages.');
                    });
            }

            // Polling automatique des messages
            function startMessagePolling() {
                stopMessagePolling();
                if (selectedTeacherId) {
                    messagePollingInterval = setInterval(loadMessages, 3000);
                }
            }
            function stopMessagePolling() {
                if (messagePollingInterval) {
                    clearInterval(messagePollingInterval);
                    messagePollingInterval = null;
                }
            }

            // Arrêter le polling lors du changement d'enfant ou d'enseignant
            childSelector.addEventListener('change', function () {
                chatHeader.textContent = 'Sélectionnez un enseignant pour commencer';
                chatMessages.innerHTML = '';
                sendMessageBtn.disabled = true;
                stopMessagePolling();
            });

            // SUPPRIMEZ CE BLOC EN DOUBLE (gardez un seul addEventListener pour contactTeacherBtn)
            // contactTeacherBtn.addEventListener('click', function () {
            //     ...existing code...
            // });

            
            sendMessageBtn.addEventListener('click', function () {
                if (!selectedTeacherId || !selectedChildId) {
                    alert('Veuillez sélectionner un enseignant et un enfant.');
                    return;
                }
                const formData = new FormData();
                formData.append('teacher_id', selectedTeacherId);
                formData.append('student_id', selectedChildId); // Doit être student_id, pas child_id
                if (messageInput.value.trim()) {
                    formData.append('message', messageInput.value.trim());
                }
                if (attachmentInput.files.length) {
                    formData.append('attachment', attachmentInput.files[0]);
                }

                fetch('/send-message', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageInput.value = '';
                        attachmentInput.value = '';
                        toggleSendButton();
                        loadMessages();
                        // Le polling continue, pas besoin de recharger la page
                    } else {
                        alert(data.error || 'Erreur lors de l\'envoi du message.');
                    }
                })
                .catch(error => {
                    alert('Erreur lors de l\'envoi du message.');
                });
            });

            function toggleSendButton() {
                sendMessageBtn.disabled = !selectedTeacherId || !selectedChildId || (!messageInput.value.trim() && !attachmentInput.files.length);
            }

            messageInput.addEventListener('input', toggleSendButton);
            attachmentInput.addEventListener('change', toggleSendButton);

            function updateNotificationBadge() {
                fetch('{{ route("notifications.unread-count") }}')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('notificationBadge');
                        if (data.unreadNotificationsCount > 0) {
                            badge.textContent = data.unreadNotificationsCount;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération des notifications non lues :', error);
                    });
            }

            // Update the badge every 30 seconds
            setInterval(updateNotificationBadge, 30000);

            // Initial badge update
            updateNotificationBadge();

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
        });
    </script>
</body>
</html>