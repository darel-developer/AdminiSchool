<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\teacherchat.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie Enseignant</title>
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
        <button class="btn btn-primary mb-3" id="contactParentBtn">Contactez un parent</button>

        <!-- Modal pour la sélection du parent -->
        <div class="modal fade" id="parentModal" tabindex="-1" aria-labelledby="parentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="parentModalLabel">Sélectionnez un parent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="parentList" class="list-group">
                            <!-- Les parents seront chargés ici dynamiquement -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone de messagerie -->
        <div class="chat-container">
            <div class="chat-header" id="chatHeader">Sélectionnez un parent pour commencer</div>
            <div class="chat-messages" id="chatMessages">
                <!-- Les messages seront chargés ici -->
            </div>
            <div class="chat-input">
                <textarea id="messageInput" rows="1" placeholder="Écrivez votre message ici..."></textarea>
                <button class="btn btn-primary" id="sendMessageBtn" disabled>Envoyer</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            

            const contactParentBtn = document.getElementById('contactParentBtn');
            const chatHeader = document.getElementById('chatHeader');
            const chatMessages = document.getElementById('chatMessages');
            const messageInput = document.getElementById('messageInput');
            const sendMessageBtn = document.getElementById('sendMessageBtn');
            const parentList = document.getElementById('parentList');
            let selectedParentId = null;

            // Charger les parents et afficher la fenêtre modale
            contactParentBtn.addEventListener('click', function () {
                console.log("[Étape 1] Début du chargement des parents...");

                fetch('/teacher/get-parents')
                    .then(response => {
                        console.log("[Étape 2] Réponse reçue du serveur :", response);
                        if (!response.ok) {
                            throw new Error(`Erreur HTTP: ${response.status} ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("[Étape 3] Données des parents reçues :", data);

                        if (data.error) {
                            console.error("[Erreur] Message d'erreur reçu :", data.error);
                            alert(data.error);
                            return;
                        }

                        console.log("[Étape 4] Construction de la liste des parents...");
                        parentList.innerHTML = '';
                        data.parents.forEach(parent => {
                            console.log(`[Étape 4.1] Ajout du parent : ${parent.nom} ${parent.prenom}`);
                            const listItem = document.createElement('li');
                            listItem.className = 'list-group-item list-group-item-action';
                            listItem.textContent = `${parent.nom} ${parent.prenom}`;
                            listItem.dataset.id = parent.id;
                            listItem.addEventListener('click', function () {
                                console.log(`[Étape 5] Parent sélectionné : ${parent.nom} ${parent.prenom}`);
                                selectedParentId = parent.id;
                                chatHeader.textContent = `Discussion avec ${parent.nom} ${parent.prenom}`;
                                sendMessageBtn.disabled = false;
                                loadMessages();
                                const parentModal = bootstrap.Modal.getInstance(document.getElementById('parentModal'));
                                parentModal.hide();
                            });
                            parentList.appendChild(listItem);
                        });

                        console.log("[Étape 6] Affichage de la fenêtre modale...");
                        const parentModal = new bootstrap.Modal(document.getElementById('parentModal'));
                        parentModal.show();
                    })
                    .catch(error => {
                        console.error("[Erreur] Erreur lors du chargement des parents :", error);
                        alert("Erreur lors du chargement des parents.");
                    });
            });

            // Charger les messages
            function loadMessages() {
                if (!selectedParentId) return;

                console.log(`[Étape 7] Chargement des messages pour le parent ID : ${selectedParentId}`);

                fetch(`/get-messages/${selectedParentId}`)
                    .then(response => {
                        console.log("[Étape 8] Réponse reçue pour les messages :", response);
                        return response.json();
                    })
                    .then(data => {
                        console.log("[Étape 9] Données des messages reçues :", data);

                        chatMessages.innerHTML = '';
                        data.messages.forEach(message => {
                            console.log(`[Étape 9.1] Ajout du message : ${message.message}`);
                            const messageElement = document.createElement('div');
                            messageElement.textContent = message.message;
                            messageElement.className = 'mb-2 p-2 rounded ' + (message.teacher_id ? 'bg-primary text-white' : 'bg-light');
                            chatMessages.appendChild(messageElement);
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    })
                    .catch(error => {
                        console.error("[Erreur] Erreur lors de la récupération des messages :", error);
                        alert("Erreur lors de la récupération des messages.");
                    });
            }

            // Envoyer un message
            sendMessageBtn.addEventListener('click', function () {
                const message = messageInput.value.trim();
                if (!message || !selectedParentId) return;

                console.log(`[Étape 10] Envoi du message : "${message}" au parent ID : ${selectedParentId}`);

                fetch('/send-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        parent_id: selectedParentId,
                        message: message
                    })
                })
                    .then(response => {
                        console.log("[Étape 11] Réponse reçue pour l'envoi du message :", response);
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            console.log("[Étape 12] Message envoyé avec succès.");
                            messageInput.value = '';
                            loadMessages();
                        } else {
                            console.error("[Erreur] Échec de l'envoi du message.");
                            alert("Erreur lors de l'envoi du message.");
                        }
                    })
                    .catch(error => {
                        console.error("[Erreur] Erreur lors de l'envoi du message :", error);
                        alert("Erreur lors de l'envoi du message.");
                    });
            });
        });
    </script>
</body>
</html>