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
        .chat-container {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            background: #fff;
            max-width: 800px;
            margin: 20px auto;
        }
        .messages {
            height: 400px;
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            background: #f9f9f9;
        }
        .message {
            padding: 8px 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .message.sent {
            background-color: #d1e7dd;
            align-self: flex-end;
        }
        .message.received {
            background-color: #f8d7da;
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <div class="sidebar">
        <a href="{{route('schoolevenement')}}" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
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

        // Fonction pour récupérer les messages
        async function fetchMessages() {
            const response = await fetch('/api/fetch-messages', {
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
                const response = await fetch('/api/send-message', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ message: messageText }),
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