<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\teacherchat.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat Enseignant</title>
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
            padding: 10px 20px;
            text-decoration: none;
            color: #bdc3c7;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ecf0f1;
        }

        .sidebar-item img {
            width: 25px;
            height: 25px;
            margin-right: 15px;
        }
        .sidebar-item.active {
            background-color: #1abc9c;
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

        .chat-container {
            height: 70vh;
            display: flex;
            flex-direction: column;
        }
        .chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 0.5rem;
                display: flex;
            flex-direction: column;
        }
        .message {
            margin-bottom: 1rem;
            padding: 0.7rem 1.2rem;
            border-radius: 1.2rem;
            max-width: 70%;
            position: relative;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            word-break: break-word;
            display: flex;
            flex-direction: column;
        }
        .message.sent {
            background-color: #007bff;
            color: #fff;
            border-bottom-right-radius: 0.4rem;
            border-bottom-left-radius: 1.2rem;
            align-items: flex-end;
            align-self: flex-end;
        }
        .message.sent::after {
            content: "";
            position: absolute;
            right: -10px;
            top: 18px;
            border-width: 10px 0 10px 10px;
            border-style: solid;
            border-color: transparent transparent transparent #007bff;
        }
        .message.received {
            background-color: #e9ecef;
            color: #222;
            border-bottom-left-radius: 0.4rem;
            border-bottom-right-radius: 1.2rem;
            align-items: flex-start;
            align-self: flex-start;
        }
        .message.received::after {
            content: "";
            position: absolute;
            left: -10px;
            top: 18px;
            border-width: 10px 10px 10px 0;
            border-style: solid;
            border-color: transparent #e9ecef transparent transparent;
        }
        .message .sender {
            font-size: 0.8rem;
            margin-bottom: 0.2rem;
            font-weight: bold;
            opacity: 0.7;
        }
        .message .content {
            font-size: 1rem;
        }
        .message .time {
            font-size: 0.7rem;
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
        #loadingSpinner {
            display: none;
            text-align: center;
            padding: 1rem;
        }
        @media (max-width: 768px) {
            .chat-container {
                height: 60vh;
            }
            .message {
                max-width: 90%;
            }
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
        
        <a href="{{route('teacherchat')}}" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
        </a>
        <a href="{{ route('teacher.statistics') }}" class="sidebar-item">
            <img src="{{ asset('images/statistics.png') }}" alt="statistics">
            Statistiques
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Settings
        </a>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <h1>Messagerie Enseignant</h1>
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
                        <div id="parentsListModal" class="list-group">
                            <!-- SUPPRIME le spinner ici -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone de messagerie -->
        <div class="container mt-4">
            <div class="row">
                
                <div class="col-md-8">
                    <div class="card chat-container">
                        <div class="card-header" id="chatHeader">
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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
