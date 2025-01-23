<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - École</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        .sidebar-item img {
            width: 30px;
            height: 30px;
            margin-right: 15px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            background: #fff;
        }
        /* Modernisation de la zone de chat */
    .chat-container {
        border: none;
        border-radius: 15px;
        padding: 20px;
        background: #f4f7f9;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 20px auto;
    }
    .messages {
        height: 400px;
        overflow-y: auto;
        border-radius: 10px;
        padding: 15px;
        background: #ffffff;
        box-shadow: inset 0px 2px 6px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .message {
        padding: 12px 16px;
        border-radius: 15px;
        font-size: 14px;
        max-width: 75%;
        word-wrap: break-word;
        position: relative;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }
    .message.sent {
        background-color: #d1f7c4;
        align-self: flex-end;
        color: #4a7c4a;
    }
    .message.received {
        background-color: #fbe4e6;
        color: #8a4a4a;
    }
    .message-time {
        font-size: 11px;
        color: #aaa;
        position: absolute;
        bottom: -18px;
        right: 10px;
    }
    .input-group {
        margin-top: 15px;
        display: flex;
        gap: 10px;
    }
    .input-group input {
        border-radius: 20px;
        padding: 12px 15px;
        border: 1px solid #ddd;
        outline: none;
        flex-grow: 1;
        box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
    }
    .input-group button {
        border-radius: 20px;
        padding: 10px 20px;
        background: linear-gradient(135deg, #ff7f50, #ff6f61);
        color: white;
        border: none;
        box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
        transition: background 0.3s ease;
    }
    .input-group button:hover {
        background: linear-gradient(135deg, #ff6f61, #ff7f50);
    }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <div class="sidebar">
        <a href="{{ route('schoolevenement') }}" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            Document
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="paiement">
            Paiement
        </a>
        <a href="{{ route('schoolchat') }}" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/event.png') }}" alt="chat">
            Event
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/book.png') }}" alt="chat">
           Book
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Settings
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>

    <div class="content">
        <h1>Chat avec les Tuteurs</h1>
        <div class="chat-container">
            <!-- Zone des messages -->
            <div class="messages" id="messages">
                <!-- Les messages s'afficheront ici -->
            </div>

            <!-- Zone d'entrée du message -->
            <div class="input-group">
                <input type="text" id="messageInput" class="form-control" placeholder="Répondez au tuteur..." />
                <button class="btn btn-primary" id="sendButton">Envoyer</button>
            </div>
        </div>
    </div>

    <script>
        const messagesContainer = document.getElementById('messages');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');

        // Récupérer l'ID du tuteur (vous pouvez l'ajouter dynamiquement)
        const tuteurId = 1; // Exemple d'ID de tuteur

        // Fonction pour récupérer les messages
        async function fetchMessages() {
            const response = await fetch(`/api/school/fetch-messages/${tuteurId}`, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin',
            });

            const data = await response.json();
            if (response.ok) {
                displayMessages(data);
            } else {
                console.error(data.error);
            }
        }

        // Fonction pour afficher les messages
        function displayMessages(messages) {
            messagesContainer.innerHTML = '';
            messages.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message', message.tuteur_id ? 'received' : 'sent');
                messageDiv.textContent = message.content;
                messagesContainer.appendChild(messageDiv);
            });
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Fonction pour envoyer un message
        async function sendMessage() {
            const messageText = messageInput.value.trim();
            if (messageText !== '') {
                const response = await fetch('/api/school/send-message', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ message: messageText, tuteur_id: tuteurId }),
                    credentials: 'same-origin',
                });

                const data = await response.json();
                if (response.ok) {
                    fetchMessages();
                    messageInput.value = '';
                } else {
                    console.error(data.error);
                }
            }
        }

        // Écouteur pour le bouton Envoyer
        sendButton.addEventListener('click', sendMessage);

        // Initialisation des messages
        fetchMessages();
    </script>
</body>
</html>
