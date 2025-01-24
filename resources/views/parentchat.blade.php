<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat avec l'école</title>
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
            background-color: #343a40;
            color: white;
            padding: 15px;
            display: flex;
            flex-direction: column;
        }
        .sidebar-item {
            margin-bottom: 15px;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
        }
        .sidebar-item img {
            margin-right: 10px;
        }
        .sidebar-item:hover {
            background-color: #495057;
            border-radius: 5px;
            padding: 10px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .chat-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            height: 80vh;
        }
        .chat-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .messages {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }
        .message {
            padding: 10px 15px;
            border-radius: 20px;
            margin-bottom: 10px;
            max-width: 60%;
            word-wrap: break-word;
        }
        .message.sent {
            background-color: #d1e7dd;
            align-self: flex-end;
        }
        .message.received {
            background-color: #f8d7da;
            align-self: flex-start;
        }
        .message-input {
            display: flex;
            align-items: center;
        }
        .message-input input {
            flex-grow: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ced4da;
            margin-right: 10px;
        }
        .message-input button {
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            background-color: #0d6efd;
            color: white;
            cursor: pointer;
        }
        .message-input button:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="paiement">
            Paiement
        </a>
        <a href="{{route('parentchat')}}" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
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
        <h1>Chat avec l'école</h1>
        <div class="chat-container">
            <div class="chat-header">Zone de Messagerie</div>
            <div class="messages" id="messagesContainer">
                <!-- Example messages -->
                <div class="message sent">Bonjour, comment puis-je vous aider?</div>
                <div class="message received">J'ai une question concernant les paiements.</div>
                <!-- Add more messages here -->
            </div>
            <div class="message-input">
                <input type="text" id="messageInput" placeholder="Écrire un message...">
                <button type="button" id="sendButton">Envoyer</button>
            </div>
        </div>
    </div>

    <script>
        const messagesContainer = document.getElementById('messagesContainer');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');

        async function fetchMessages() {
            const response = await fetch('/api/fetch-messages');
            const messages = await response.json();

            messagesContainer.innerHTML = '';
            messages.forEach(message => {
                const messageDiv = document.createElement('div');
                if (message.is_from_tuteur) {
                    messageDiv.classList.add('message', 'received');
                } else {
                    messageDiv.classList.add('message', 'sent');
                }
                messageDiv.textContent = message.content;
                messagesContainer.appendChild(messageDiv);
            });
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        sendButton.addEventListener('click', async () => {
            const messageText = messageInput.value.trim();
            if (messageText !== '') {
                const response = await fetch('/api/send-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ content: messageText }),
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
        });

        // Fetch messages every 5 seconds
        setInterval(fetchMessages, 5000);

        fetchMessages();
    </script>
</body>
</html>