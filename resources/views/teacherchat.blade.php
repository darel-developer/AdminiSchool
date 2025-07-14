<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\teacherchat.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat Enseignant</title>
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
            border-right: 1px solid #34495e;
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
            font-size: 1.5rem;
            text-align: center;
            color: #ecf0f1;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }
        .sidebar-separator {
            border-top: 1px solid #34495e;
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
        .content {
            margin-left: 250px;
            padding: 32px 24px 24px 24px;
            flex-grow: 1;
            min-height: 100vh;
            transition: margin-left 0.3s;
        }
        .chat-container {
            max-width: 700px;
            margin: 0 auto;
            height: auto; /* plus de hauteur fixe */
            max-height: 80vh; /* limite raisonnable en hauteur */
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.09);
            overflow: hidden;
        }
        .chat-header {
            background: linear-gradient(90deg, #007bff 80%, #0056b3 100%);
            color: #fff;
            padding: 18px 24px;
            font-weight: 600;
            font-size: 1.15rem;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
            letter-spacing: 0.5px;
        }
        .chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1.2rem 1.5rem;
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
        }
        .message {
    position: relative;
    display: inline-block;
    max-width: 75%;
    padding: 14px 20px;
    margin: 0.5rem;
    border-radius: 22px;
    word-break: break-word;
    font-size: 1rem;
    box-sizing: border-box;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
    transition: box-shadow 0.2s, background 0.2s;
}

.message:hover {
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.13);
    background-color: #f1f3f7;
}

.message.sent {
    align-self: flex-end;
    background: linear-gradient(135deg, #007bff 80%, #0056b3 100%);
    color: #fff;
    border-bottom-right-radius: 4px;
    border-bottom-left-radius: 18px;
}

.message.sent::after {
    content: "";
    position: absolute;
    right: -10px;
    top: 14px;
    border-width: 10px 0 10px 10px;
    border-style: solid;
    border-color: transparent transparent transparent #007bff;
}

.message.received {
    align-self: flex-start;
    background: linear-gradient(135deg, #e9ecef 80%, #dbe4ee 100%);
    color: #333;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 18px;
}

.message.received::after {
    content: "";
    position: absolute;
    left: -10px;
    top: 14px;
    border-width: 10px 10px 10px 0;
    border-style: solid;
    border-color: transparent #e9ecef transparent transparent;
}


        .message .sender {
            font-size: 0.85rem;
            margin-bottom: 0.2rem;
            font-weight: bold;
            opacity: 0.7;
        }
        .message .content {
            font-size: 1.04rem;
        }
        .message .time {
            font-size: 0.75rem;
            opacity: 0.7;
            margin-top: 0.3rem;
            text-align: right;
        }
        .message .attachment {
            margin-top: 0.5rem;
        }
        .message .attachment a {
            color: inherit;
            text-decoration: underline;
        }
        .chat-container .card-footer,
        .chat-container form {
            background: #f8f9fa;
            border-top: 1px solid #e0e0e0;
            padding: 18px 24px;
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
        }
        .chat-container .input-group .form-control {
            border-radius: 8px;
            font-size: 1.05rem;
        }
        .chat-container .btn-primary {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
        }
        .chat-container small.text-muted {
            margin-top: 4px;
        }
        #loadingSpinner {
            display: none;
            text-align: center;
            padding: 1rem;
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
            .chat-container {
                max-width: 98vw;
                margin: 0 auto;
            }
        }
        @media (max-width: 767.98px) {
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
            .content {
                padding: 8px 2px 8px 2px;
            }
            .chat-container {
                max-width: 100vw;
                border-radius: 0;
                box-shadow: none;
            }
            .chat-header, .chat-container .card-footer, .chat-container form {
                border-radius: 0 !important;
                padding: 12px 7vw;
            }
            .chat-messages {
                padding: 1rem 3vw;
            }
            .message {
                max-width: 95vw;
                font-size: 0.98rem;
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
                padding: 8px 10px;
            }
            .content {
                padding: 4px 1vw 4px 1vw;
            }
            .chat-header, .chat-container .card-footer, .chat-container form {
                padding: 10px 2vw;
            }
            .chat-messages {
                padding: 0.7rem 2vw;
            }
            .message {
                max-width: 99vw;
                font-size: 0.95rem;
            }
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
    <div class="sidebar d-flex flex-column" id="sidebarMenu">
        <div class="sidebar-title">ADMINISCHOOL</div>
        <div class="sidebar-separator"></div>
        <a href="{{route('teacher')}}" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="{{route('teacherchat')}}" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
        </a>
        <a href="{{ route('teacher.statistics') }}" class="sidebar-item">
            <img src="{{ asset('images/statistics.png') }}" alt="statistics">
            Statistiques
        </a>
      
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="content">
        <h1 style="font-weight:700;letter-spacing:1px;" class="mb-4">Messagerie Enseignant</h1>
        <button class="btn btn-primary mb-3" id="contactParentBtn" data-bs-toggle="modal" data-bs-target="#parentModal">
            Contactez un parent
        </button>
        <!-- Modal pour la sélection du parent -->
        <div class="modal fade" id="parentModal" tabindex="-1" aria-labelledby="parentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="parentModalLabel">Sélectionnez un parent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="parentsListModal" class="list-group"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Zone de messagerie -->
        <div class="chat-container mt-4">
            <div class="chat-header" id="chatHeader">
                Sélectionnez un parent pour commencer la conversation
            </div>
            <div class="chat-messages" id="chatMessages">
                <div class="text-center text-muted">
                    Sélectionnez un parent pour voir les messages
                </div>
            </div>
            <div id="loadingSpinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </div>
            <div class="card-footer">
                <form id="messageForm" class="d-flex flex-column gap-2">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="messageInput" class="form-control" placeholder="Votre message..." disabled>
                        <input type="file" id="attachmentInput" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" disabled>
                        <button type="submit" id="sendMessageBtn" class="btn btn-primary" disabled>
                            Envoyer
                        </button>
                    </div>
                    <small class="text-muted">Formats acceptés: jpg, jpeg, png, pdf, doc, docx (max 10MB)</small>
                </form>
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
            // Ajouter le token CSRF à toutes les requêtes fetch
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Configuration par défaut pour fetch
            const fetchConfig = {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            };

            const parentsList = document.getElementById('parentsList');
            const chatHeader = document.getElementById('chatHeader');
            const chatMessages = document.getElementById('chatMessages');
            const messageInput = document.getElementById('messageInput');
            const attachmentInput = document.getElementById('attachmentInput');
            const sendMessageBtn = document.getElementById('sendMessageBtn');
            const parentsListModal = document.getElementById('parentsListModal');
            let selectedParentId = null;
            let selectedParentName = '';
            let messagePollingInterval = null; // Ajout du polling

            // Sélectionner un parent et démarrer la discussion
            function selectParent(parent) {
                selectedParentId = parent.id;
                selectedParentName = `${parent.nom} ${parent.prenom}`;
                chatHeader.textContent = `Discussion avec ${selectedParentName}`;
                messageInput.disabled = false;
                attachmentInput.disabled = false;
                sendMessageBtn.disabled = false;
                chatMessages.innerHTML = '<div class="text-center text-muted">Chargement des messages...</div>';
                loadMessages();
                startMessagePolling(); // Démarrer le polling
            }

            // Charger la liste de tous les parents dans le modal (sans spinner)
            function loadParentsModal() {
                parentsListModal.innerHTML = '';
                fetch('{{ url("teacher/all-parents") }}', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    parentsListModal.innerHTML = '';
                    if (!data.parents || data.parents.length === 0) {
                        parentsListModal.innerHTML = '<div class="text-center text-muted p-3">Aucun tuteur.</div>';
                        return;
                    }
                    data.parents.forEach(parent => {
                        const listItem = document.createElement('button');
                        listItem.type = 'button';
                        listItem.className = 'list-group-item list-group-item-action';
                        listItem.innerHTML = `
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">${parent.nom} ${parent.prenom}</h6>
                            </div>
                            <small class="text-muted">
                                ${parent.children.length ? parent.children.map(child => child.name).join(', ') : 'Aucun enfant'}
                            </small>
                        `;
                        listItem.addEventListener('click', function() {
                            selectParent(parent);
                            const parentModal = bootstrap.Modal.getInstance(document.getElementById('parentModal'));
                            parentModal.hide();
                        });
                        parentsListModal.appendChild(listItem);
                    });
                })
                .catch(error => {
                    parentsListModal.innerHTML = `<div class="alert alert-danger m-3">Erreur lors du chargement des tuteurs: ${error.message}</div>`;
                });
            }

            // Charger les messages pour un parent
            function loadMessages() {
                if (!selectedParentId) return;
                fetch(`{{ url('teacher/messages') }}/${selectedParentId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    chatMessages.innerHTML = '';

                    if (!data.messages || data.messages.length === 0) {
                        chatMessages.innerHTML = '<div class="text-center text-muted">Aucun message dans cette conversation.</div>';
                        return;
                    }

                    data.messages.forEach(message => {
                        const messageElement = document.createElement('div');
                        messageElement.className = `message ${message.sender.type === 'teacher' ? 'sent' : 'received'}`;

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
                    chatMessages.innerHTML = `
                        <div class="alert alert-danger">
                            Erreur lors du chargement des messages: ${error.message}
                        </div>
                    `;
                });
            }

            // Polling automatique des messages
            function startMessagePolling() {
                stopMessagePolling();
                if (selectedParentId) {
                    messagePollingInterval = setInterval(loadMessages, 3000);
                }
            }
            function stopMessagePolling() {
                if (messagePollingInterval) {
                    clearInterval(messagePollingInterval);
                    messagePollingInterval = null;
                }
            }

            // Envoyer un message au tuteur sélectionné
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = messageInput.value.trim();
                const attachment = attachmentInput.files[0];

                if ((!message && !attachment) || !selectedParentId) {
                    alert("Veuillez sélectionner un parent et saisir un message ou une pièce jointe.");
                    return;
                }

                const formData = new FormData();
                formData.append('parent_id', selectedParentId);
                if (message) formData.append('message', message);
                if (attachment) formData.append('attachment', attachment);

                sendMessageBtn.disabled = true;
                sendMessageBtn.textContent = 'Envoi...';

                fetch('{{ url("teacher/send-message") }}', {
                    method: 'POST',
                    body: formData,
                    ...fetchConfig
                })
                .then(response => response.json())
                .then(data => {
                    sendMessageBtn.disabled = false;
                    sendMessageBtn.textContent = 'Envoyer';

                    if (data.success) {
                        messageInput.value = '';
                        attachmentInput.value = '';
                        loadMessages();
                        // Le polling continue, pas besoin de recharger la page
                    } else {
                        alert(`Erreur: ${data.message}`);
                    }
                })
                .catch(error => {
                    sendMessageBtn.disabled = false;
                    sendMessageBtn.textContent = 'Envoyer';
                    alert(`Erreur lors de l'envoi du message: ${error.message}`);
                });
            });

            // Charger la liste des parents au démarrage
            loadParentsModal();
        });
    </script>
</body>
</html>
