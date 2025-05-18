<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            padding: 10px;
            overflow-y: auto;
            background-color: #f8f9fa;
        }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 10px;
            max-width: 80%;
        }
        .message.sent {
            background-color: #007bff;
            color: white;
            margin-left: auto;
        }
        .message.received {
            background-color: #e9ecef;
            color: black;
            margin-right: auto;
        }
        .message .sender {
            font-size: 0.8em;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .message .content {
            word-break: break-word;
        }
        .message .time {
            font-size: 0.7em;
            margin-top: 5px;
            opacity: 0.8;
        }
        .message .attachment {
            margin-top: 10px;
        }
        .chat-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: #fff;
        }
        .chat-input textarea {
            flex-grow: 1;
            resize: none;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }
        .chat-input button {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <div class="sidebar">
        <div class="sidebar-title">ADMINISCHOOL</div>
        <div class="sidebar-separator"></div>
        <a href="#" class="sidebar-item">
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
        <a href="{{ route('notifications.page') }}" class="sidebar-item">
            <img src="{{ asset('images/notification.png') }}" alt="notification">
            <span>Notification</span>
            <span id="notificationBadge" class="badge bg-danger ms-2" style="display: none;">0</span>
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

    <!-- Contenu principal -->
    <div class="content">
        <h1>Messagerie Parent</h1>

        <!-- Dropdown for selecting a child -->
        <div class="mb-3">
            <label for="childSelect" class="form-label">Sélectionner un enfant</label>
            <select class="form-select" id="childSelect">
                <option value="">Choisir un enfant...</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" data-class-id="{{ $student->class_id }}">
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Liste des enseignants -->
        <div id="teachersList" class="list-group">
            @foreach($teachers as $teacher)
                <div class="teacher-item list-group-item list-group-item-action"
                     data-teacher-id="{{ $teacher->id }}"
                     data-class-id="{{ $teacher->class_id }}"
                     style="display: none;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">{{ $teacher->first_name }} {{ $teacher->last_name }}</h6>
                            <small class="text-muted">{{ $teacher->subject }}</small>
                        </div>
                        <button class="btn btn-primary btn-sm contact-teacher"
                                data-teacher-id="{{ $teacher->id }}">
                            Contacter
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Zone de messagerie -->
        <div class="chat-container">
            <div class="chat-header" id="chatHeader">Sélectionnez un enseignant pour commencer</div>
            <div class="chat-messages" id="chatMessages">
                <!-- Les messages seront chargés ici -->
            </div>
            <div class="chat-input">
                <form id="messageForm" class="d-flex align-items-center w-100">
                    @csrf
                    <textarea id="messageInput" rows="1" placeholder="Écrivez votre message ici..." disabled></textarea>
                    <input type="file" id="attachmentInput" class="form-control" style="max-width: 200px; margin-left: 10px;" disabled>
                    <button type="submit" class="btn btn-primary" id="sendMessageBtn" disabled>Envoyer</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const childSelect = document.getElementById('childSelect');
            const teachersList = document.getElementById('teachersList');
            const chatMessages = document.getElementById('chatMessages');
            const chatHeader = document.getElementById('chatHeader');
            const messageInput = document.getElementById('messageInput');
            const attachmentInput = document.getElementById('attachmentInput');
            const sendMessageBtn = document.getElementById('sendMessageBtn');
            const messageForm = document.getElementById('messageForm');

            let selectedTeacherId = null;
            let selectedChildId = null;

            // Gérer le changement d'enfant sélectionné
            childSelect.addEventListener('change', function() {
                selectedChildId = this.value;
                const selectedOption = this.options[this.selectedIndex];
                const classId = selectedOption.dataset.classId;

                console.log('Sélection changée :', {
                    selectedChildId,
                    classId
                });

                // Afficher/masquer les enseignants en fonction de la classe
                document.querySelectorAll('.teacher-item').forEach(item => {
                    const teacherClassId = item.dataset.classId;
                    console.log('Comparaison :', {
                        teacherClassId,
                        classId,
                        match: teacherClassId === classId
                    });

                    if (classId && teacherClassId === classId) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Réinitialiser la conversation
                chatHeader.textContent = 'Sélectionnez un enseignant pour commencer';
                chatMessages.innerHTML = '';
                messageInput.disabled = true;
                attachmentInput.disabled = true;
                sendMessageBtn.disabled = true;
            });

            // Gérer le clic sur les boutons "Contacter"
            document.querySelectorAll('.contact-teacher').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const teacherId = this.dataset.teacherId;
                    const childId = childSelect.value;

                    console.log('Clic sur Contacter :', {
                        teacherId,
                        childId
                    });

                    if (!childId) {
                        alert('Veuillez sélectionner un enfant d\'abord');
                        return;
                    }

                    startConversation(teacherId, childId);
                });
            });

            // Fonction pour démarrer une conversation
            function startConversation(teacherId, childId) {
                console.log('Démarrage conversation :', {
                    teacherId,
                    childId
                });

                selectedTeacherId = teacherId;
                selectedChildId = childId;

                const teacher = document.querySelector(`.teacher-item[data-teacher-id="${teacherId}"]`);
                console.log('Enseignant trouvé :', teacher);

                const teacherName = teacher ? teacher.querySelector('h6').textContent : 'Enseignant';

                chatHeader.textContent = `Discussion avec ${teacherName}`;
                messageInput.disabled = false;
                attachmentInput.disabled = false;
                sendMessageBtn.disabled = false;
                loadMessages();
            }

            // Charger les messages
            function loadMessages() {
                if (!selectedTeacherId) {
                    console.log('Pas d\'enseignant sélectionné');
                    return;
                }

                console.log('Chargement des messages pour l\'enseignant:', selectedTeacherId);

                fetch(`/chat/messages/${selectedTeacherId}`)
                    .then(response => {
                        console.log('Réponse reçue:', response);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Messages reçus:', data);
                        chatMessages.innerHTML = '';

                        if (!data.messages || data.messages.length === 0) {
                            chatMessages.innerHTML = '<div class="text-center text-muted p-3">Aucun message dans cette conversation.</div>';
                            return;
                        }

                        data.messages.forEach(message => {
                            const messageElement = document.createElement('div');
                            messageElement.className = `message ${message.sender.type === 'parent' ? 'sent' : 'received'}`;

                            let content = `
                                <div class="sender">${message.sender.name}</div>
                                <div class="content">${message.message || ''}</div>
                            `;

                            if (message.attachment) {
                                const extension = message.attachment.split('.').pop().toLowerCase();
                                const isImage = ['jpg', 'jpeg', 'png', 'gif'].includes(extension);

                                content += `
                                    <div class="attachment">
                                        ${isImage
                                            ? `<img src="${message.attachment}" class="img-fluid" style="max-height: 200px;" alt="Pièce jointe">`
                                            : `<a href="${message.attachment}" target="_blank">Voir la pièce jointe</a>`
                                        }
                                    </div>
                                `;
                            }

                            content += `<div class="time">${new Date(message.created_at).toLocaleString()}</div>`;
                            messageElement.innerHTML = content;
                            chatMessages.appendChild(messageElement);
                        });

                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des messages:', error);
                        chatMessages.innerHTML = `
                            <div class="alert alert-danger m-3">
                                Erreur lors du chargement des messages: ${error.message}
                            </div>
                        `;
                    });
            }

            // Gérer l'envoi des messages
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Tentative d\'envoi de message');

                if (!selectedTeacherId || (!messageInput.value.trim() && !attachmentInput.files[0])) {
                    console.log('Données manquantes pour l\'envoi');
                    return;
                }

                const formData = new FormData();
                formData.append('teacher_id', selectedTeacherId);
                if (selectedChildId) formData.append('student_id', selectedChildId);
                if (messageInput.value.trim()) formData.append('message', messageInput.value.trim());
                if (attachmentInput.files[0]) formData.append('attachment', attachmentInput.files[0]);

                // Ajouter le token CSRF
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                console.log('Envoi du message avec les données:', {
                    teacherId: selectedTeacherId,
                    studentId: selectedChildId,
                    message: messageInput.value.trim()
                });

                sendMessageBtn.disabled = true;
                messageInput.disabled = true;
                attachmentInput.disabled = true;

                fetch('/chat/send', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Réponse du serveur:', data);
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    messageInput.value = '';
                    attachmentInput.value = '';
                    loadMessages();
                })
                .catch(error => {
                    console.error('Erreur lors de l\'envoi:', error);
                    alert(`Erreur lors de l'envoi du message: ${error.message}`);
                })
                .finally(() => {
                    sendMessageBtn.disabled = false;
                    messageInput.disabled = false;
                    attachmentInput.disabled = false;
                });
            });

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
        });
    </script>
</body>
</html>
