<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        .chat-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .chat-box {
            height: 400px;
            overflow-y: scroll;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }
        .chat-message {
            margin-bottom: 10px;
        }
        .chat-message.user {
            text-align: right;
        }
        .chat-message.bot {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="chat-container">
            <h1>Help Support</h1>
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="chat-box" id="chatBox">
                <!-- Messages will be appended here -->
            </div>
            <form id="chatForm" method="POST" action="{{ route('help.support.send') }}">
                @csrf
                <div class="input-group mt-3">
                    <input type="text" name="message" id="messageInput" class="form-control" placeholder="Posez votre question sur l'utilisation de l'application..." required>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('chatForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const messageInput = document.getElementById('messageInput');
            const chatBox = document.getElementById('chatBox');
            const userMessage = messageInput.value.trim();
            if (!userMessage) return;

            // Affiche le message utilisateur
            const userDiv = document.createElement('div');
            userDiv.classList.add('chat-message', 'user');
            userDiv.textContent = userMessage;
            chatBox.appendChild(userDiv);
            chatBox.scrollTop = chatBox.scrollHeight;

            // Envoie la question au contrôleur Laravel pour obtenir la réponse du bot
            fetch("{{ route('help.support.bot') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ message: userMessage })
            })
            .then(response => response.json())
            .then(data => {
                const botDiv = document.createElement('div');
                botDiv.classList.add('chat-message', 'bot');
                botDiv.textContent = data.reply;
                chatBox.appendChild(botDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            })
            .catch(() => {
                const botDiv = document.createElement('div');
                botDiv.classList.add('chat-message', 'bot');
                botDiv.textContent = "Désolé, une erreur est survenue. Veuillez réessayer.";
                chatBox.appendChild(botDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            });

            messageInput.value = '';
        });
    </script>
</body>
</html>