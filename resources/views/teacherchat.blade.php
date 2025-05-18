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
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
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
        }
        .message {
            margin-bottom: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            max-width: 75%;
        }
        .message.sent {
            background-color: #007bff;
            color: white;
            margin-left: auto;
        }
        .message.received {
            background-color: #e9ecef;
            margin-right: auto;
        }
        .message .sender {
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
        }
        .message .time {
            font-size: 0.7rem;
            opacity: 0.8;
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
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
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
                        <div id="parentsList" class="list-group">
                            <div id="loadingParents" class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Chargement...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone de messagerie -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Parents d'élèves
                        </div>
                        <div class="card-body">
                            <div id="parentsList" class="list-group">
                                <div id="loadingParents" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Chargement...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            const chatMessages = document.getElementById('chatMessages');
            const chatHeader = document.getElementById('chatHeader');
            const messageForm = document.getElementById('messageForm');
            const messageInput = document.getElementById('messageInput');
            const attachmentInput = document.getElementById('attachmentInput');
            const sendMessageBtn = document.getElementById('sendMessageBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const loadingParents = document.getElementById('loadingParents');

            let selectedParentId = null;
            let isLoadingMessages = false;

            // Charger la liste des parents
            function loadParents() {
                fetch('{{ route("teacher.get-parents") }}', fetchConfig)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Erreur HTTP: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        loadingParents.style.display = 'none';
                        parentsList.innerHTML = '';

                        if (!data.parents || data.parents.length === 0) {
                            parentsList.innerHTML = '<div class="text-center text-muted p-3">Aucun parent trouvé pour votre classe.</div>';
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
                                    ${parent.children ? parent.children.map(child => child.name).join(', ') : 'Aucun enfant'}
                                </small>
                            `;
                            listItem.addEventListener('click', () => selectParent(parent));
                            parentsList.appendChild(listItem);
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des parents:', error);
                        loadingParents.style.display = 'none';
                        parentsList.innerHTML = `
                            <div class="alert alert-danger m-3">
                                Erreur lors du chargement des parents: ${error.message}
                            </div>
                        `;
                    });
            }

            // Sélectionner un parent
            function selectParent(parent) {
                selectedParentId = parent.id;
                chatHeader.textContent = `Discussion avec ${parent.nom} ${parent.prenom}`;
                messageInput.disabled = false;
                attachmentInput.disabled = false;
                document.querySelectorAll('#parentsList button').forEach(btn => {
                    btn.classList.remove('active');
                });
                event.currentTarget.classList.add('active');
                loadMessages();
            }

            // Charger les messages
            function loadMessages() {
                if (!selectedParentId || isLoadingMessages) return;

                isLoadingMessages = true;
                loadingSpinner.style.display = 'block';
                chatMessages.style.opacity = '0.5';

                fetch(`{{ route('teacher.messages', '') }}/${selectedParentId}`, fetchConfig)
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.error || `Erreur HTTP: ${response.status}`);
                            });
                        }
                        return response.json();
                    })
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
                    })
                    .finally(() => {
                        isLoadingMessages = false;
                        loadingSpinner.style.display = 'none';
                        chatMessages.style.opacity = '1';
                    });
            }

            // Envoyer un message
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = messageInput.value.trim();
                const attachment = attachmentInput.files[0];

                if ((!message && !attachment) || !selectedParentId) return;

                const formData = new FormData();
                formData.append('parent_id', selectedParentId);
                if (message) formData.append('message', message);
                if (attachment) formData.append('attachment', attachment);

                sendMessageBtn.disabled = true;
                messageInput.disabled = true;
                attachmentInput.disabled = true;

                const sendConfig = {
                    ...fetchConfig,
                    method: 'POST',
                    body: formData
                };

                fetch('{{ route("teacher.send-message") }}', sendConfig)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error('Erreur serveur:', data.error);
                            throw new Error(typeof data.error === 'string' ? data.error : 'Une erreur est survenue');
                        }
                        messageInput.value = '';
                        attachmentInput.value = '';
                        loadMessages();
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert(`Erreur lors de l'envoi du message: ${error.message}`);
                    })
                    .finally(() => {
                        sendMessageBtn.disabled = false;
                        messageInput.disabled = false;
                        attachmentInput.disabled = false;
                    });
            });

            // Activer/désactiver le bouton d'envoi
            function toggleSendButton() {
                sendMessageBtn.disabled = !selectedParentId ||
                    (!messageInput.value.trim() && !attachmentInput.files.length);
            }

            messageInput.addEventListener('input', toggleSendButton);
            attachmentInput.addEventListener('change', toggleSendButton);

            // Charger les parents au démarrage
            loadParents();
        });
    </script>
</body>
</html>
