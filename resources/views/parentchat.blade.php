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
            padding: 10px;
            overflow-y: auto;
            background-color: #f8f9fa;
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

           
            childSelector.addEventListener('change', function () {
                selectedChildId = this.value;
                chatHeader.textContent = 'Sélectionnez un enseignant pour commencer';
                chatMessages.innerHTML = '';
                sendMessageBtn.disabled = true;
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
                            listItem.textContent = `${teacher.first_name} ${teacher.last_name}`;
                            listItem.dataset.id = teacher.id;
                            listItem.addEventListener('click', function () {
                                selectedTeacherId = teacher.id;
                                chatHeader.textContent = `Discussion avec ${teacher.first_name} ${teacher.last_name}`;
                                sendMessageBtn.disabled = false;
                                loadMessages();
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
                            const messageElement = document.createElement('div');
                            messageElement.textContent = message.message;
                            messageElement.className = 'mb-2 p-2 rounded ' + (message.tuteur_id ? 'bg-primary text-white' : 'bg-light');
                            chatMessages.appendChild(messageElement);
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    })
                    .catch(error => {
                        alert('Erreur lors de la récupération des messages.');
                    });
            }

            
            sendMessageBtn.addEventListener('click', function () {
                if (!selectedTeacherId || !selectedChildId) {
                    alert('Veuillez sélectionner un enseignant et un enfant.');
                    return;
                }
                const formData = new FormData();
                formData.append('teacher_id', selectedTeacherId);
                formData.append('student_id', selectedChildId); // Doit être student_id, pas child_id
                formData.append('message', messageInput.value.trim());
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
        });
    </script>
</body>
</html>